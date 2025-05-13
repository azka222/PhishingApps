<?php
namespace App\Http\Controllers;

use App\Jobs\RequestApprovalCampaignJob;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\CompanyCampaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
    public $url;

    public function __construct()
    {
        $this->url = env('GOPHISH_URL');
    }
    public function getIdFromGophish($module)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/$module/");
        $existingIds = collect($response->json())->pluck('id');
        $newId       = $existingIds->max() + 1;
        return $newId;
    }
    public function sendNewApproval(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:campaigns',
        ]);

        $campaign = Campaign::find($request->id);
        if ($campaign->status_id != 1) {
            return response()->json([
                'message' => 'Campaign already approved or rejected',
            ], 403);
        }
        $campaign->updated_at = Carbon::now();
        $campaign->save();

        $this->sendApprovalEmail($campaign->id);

        return response()->json([
            'message' => 'Approval request sent successfully',
        ]);
    }

    public function getAllApproval(Request $request)
    {
        if (Gate::allows('HaveAccessApproval')) {
            if (Gate::allows('IsAdmin')) {
                $campaigns = Campaign::query();
                if ($request->has('companyId') && ! empty($request->companyId)) {
                    $campaigns->where('company_id', $request->companyId);
                }
            } else {
                $campaigns = Campaign::where('company_id', auth()->user()->company_id);
            }

            if ($request->has('search') && ! empty($request->search)) {
                $campaigns->where('name', 'like', "%{$request->search}%");
            }

            if ($request->has('status') && ! empty($request->status)) {
                $campaigns->where('status_id', $request->status);
            }

            $campaigns      = $campaigns->orderBy('updated_at', 'desc')->orderBy('status_id', 'asc');
            $totalCampaigns = $campaigns->count();
            $campaigns      = $campaigns->paginate($request->has('show') ? $request->show : 10);
            $firstPageTotal = count($campaigns->items());
            return response()->json([
                'approvals'      => $campaigns->items(),
                'totalApproval'  => $totalCampaigns,
                'currentPage'    => $campaigns->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount'      => $campaigns->lastPage(),

            ]);

        }
    }

    public function submitCampaignApproval(Request $request)
    {
        $request->validate([
            'id'      => 'required|exists:campaigns',
            'status'  => 'required|in:2,3',
            'message' => 'required',
        ]);

        if (Gate::allows('HaveAccessApproval')) {
            $campaign             = Campaign::find($request->id);
            $campaign->status_id  = $request->status;
            $campaign->notes      = $request->message;
            $campaign->updated_at = Carbon::now();

            if ($request->status == 2) {
                $jsonData = json_decode($campaign->data);
                $newId    = $this->getIdFromGophish('campaigns');
                $jsonData->name .= " -+- $newId";
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                ])->post("{$this->url}/campaigns/", $jsonData);
                    
                if ($response->successful() && $response != [] && $response->json() != []) {
                  
                    $idGophish                    = $response->json()['id'];
                    $companyCampaign              = new CompanyCampaign();
                    $companyCampaign->company_id  = $request->company_id;
                    $companyCampaign->campaign_id = $idGophish;
                    $companyCampaign->status      = 1;
                    $companyCampaign->save();
                    $campaign->token = null;
                    $campaign->save();
                    return response()->json([
                        'message' => 'Campaign successfully approved',
                    ]);
                } else {
                    return response()->json([
                        'message' => 'failed to create campaign',
                    ], 500);
                }

            } else if ($request->status == 3) {
                $campaign->status_id = 3;
                $campaign->token     = null;
                $campaign->save();
                return response()->json([
                    'message' => 'Campaign successfully rejected',
                ]);

            }
        }
    }

    public function sendApprovalEmail($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        if (! $campaign->token) {
            $campaign->token = Str::random(32);
            $campaign->save();
        }
        $company      = Company::find($campaign->company_id);
        $companyOwner = $company->user->email;
        RequestApprovalCampaignJob::dispatch($companyOwner, $campaign->id);

        return response()->json(['message' => 'Approval email sent successfully!']);
    }

    public function approve(Request $request, $campaignId)
    {

        $campaign = Campaign::findOrFail($campaignId);
        if (! $campaign || $campaign->token !== $request->token) {
            return response()->json(['message' => 'Invalid token or campaign not found'], 403);
        }
        $campaign->status_id = 2;
        $campaign->token     = null;
        $campaign->save();

        $jsonData = json_decode($campaign->data);
        $newId    = $this->getIdFromGophish('campaigns');
        $jsonData->name .= " -+-$newId";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->post("{$this->url}/campaigns/", $jsonData);

        if ($response->successful() && $response != [] && $response->json() != []) {
            $idGophish                    = $response->json()['id'];
            $companyCampaign              = new CompanyCampaign();
            $companyCampaign->company_id  = Auth()->user()->company_id;
            $companyCampaign->campaign_id = $idGophish;
            $companyCampaign->status      = 1;
            $companyCampaign->save();
            $campaign->save();
            return redirect()->route('campaignDetailsView', ['id' => $newId]);

        } else {
            return response()->json([
                'message' => 'failed to create campaign',
            ], 500);
        }

    }

    public function reject(Request $request, $campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        if ($campaign->token !== $request->token) {
            return response()->json(['message' => 'Invalid token'], 403);
        }
        $campaign->token     = null;
        $campaign->status_id = 3;
        $campaign->save();
        return view('contents.page.approval');
    }

}
