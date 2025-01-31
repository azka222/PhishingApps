<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\RequestApprovalCampaignJob;
use App\Mail\ApprovalMail;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\EmailTemplateCompany;
use App\Models\Group;
use App\Models\SendingProfileCompany;
use App\Models\TargetGroup;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GophishController extends Controller
{
    public $url = 'http://127.0.0.1:3333/api';

    public static function updateTarget($target, $original)
    {
        $group = TargetGroup::where('target_id', $target->id)->pluck('group_id');
        if ($group->count() > 0) {
            $gophishGroup = Group::where('company_id', auth()->user()->company_id)->whereIn('id', $group)->pluck('gophish_id');
            foreach ($gophishGroup as $value) {
                $instance        = new self();
                $tempGroup       = $instance->getDetailsModuleGophish('groups', intval($value));
                $tempGroupMember = $tempGroup['targets'];
                foreach ($tempGroupMember as &$member) {
                    if ($member['email'] == $original['email']) {
                        $member['email']      = $target->email;
                        $member['first_name'] = $target->first_name;
                        $member['last_name']  = $target->last_name;
                        $member['position']   = $target->position->name;
                    }
                }
                unset($member);
                $jsonData = [
                    'id'            => intval($tempGroup['id']),
                    'name'          => $tempGroup['name'],
                    'targets'       => $tempGroupMember,
                    'modified_date' => $instance->getTimeGoPhish(),
                ];
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                ])->put("{$instance->url}/groups/{$tempGroup['id']}", $jsonData);
                if (! $response->successful() || $response->body() == null) {
                    return false;
                } else {
                    continue;
                }
            }
        } else {
            return true;
        }
    }

    public function getTimeGoPhish()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Chicago'));
        $formattedDate = $date->format('Y-m-d\TH:i:s.uP');
        return $formattedDate;
    }

    public function getIdFromGophish($module)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get('http://127.0.0.1:3333/api/' . $module);
        $existingIds = collect($response->json())->pluck('id');
        $newId       = $existingIds->max() + 1;
        return $newId;
    }

    public function getDetailsModuleGophish($module, $id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/{$module}/{$id}");
        return $response->json();
    }

    // ================================== Landing Pages ==================================
    public function landingPagePreview($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/pages/{$id}");
        return view('contents.page.preview-page', ['data' => $response->json()]);
    }

    public function getLandingPage(Request $request)
    {
        $apiKey = env('GOPHISH_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get('http://127.0.0.1:3333/api/pages');

        if (! $response->successful()) {
            return response()->json(['error' => 'Failed to fetch landing pages'], 500);
        }

        $landingPages = $response->json();

        if ($request->has('search') && $request->search != null) {
            $landingPages = array_filter($landingPages, function ($landingPage) use ($request) {
                return stripos($landingPage['name'], $request->search) !== false;
            });
        }

        if ($request->has('capture_credentials') && $request->capture_credentials == 2) {
        } else if ($request->has('capture_credentials') && $request->capture_credentials == 1) {
            $landingPages = array_filter($landingPages, function ($landingPage) {
                return $landingPage['capture_credentials'] == true;
            });
        } else if ($request->has('capture_credentials') && $request->capture_credentials == 0) {
            $landingPages = array_filter($landingPages, function ($landingPage) {
                return $landingPage['capture_credentials'] == false;
            });
        }

        if ($request->has('capture_passwords') && $request->capture_passwords == 2) {
        } else if ($request->has('capture_passwords') && $request->capture_passwords == 1) {
            $landingPages = array_filter($landingPages, function ($landingPage) {
                return $landingPage['capture_passwords'] == true;
            });
        } else if ($request->has('capture_passwords') && $request->capture_passwords == 0) {
            $landingPages = array_filter($landingPages, function ($landingPage) {
                return $landingPage['capture_passwords'] == false;
            });
        }

        $landingPages  = collect($landingPages);
        $perPage       = $request->has('show') ? (int) $request->show : 10;
        $currentPage   = $request->has('page') ? (int) $request->page : 1;
        $pagedData     = $landingPages->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $pagedData,
            $landingPages->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $totalGroup     = $landingPages->count();
        $firstPageTotal = $landingPages->slice(0, $perPage)->count();
        return response()->json([
            'landingPage'    => $paginatedData->items(),
            'targetTotal'    => $totalGroup,
            'currentPage'    => $paginatedData->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount'      => $paginatedData->lastPage(),
        ]);
    }

    // ================================== End Landing Pages ==================================

    // ================================== Email Templates ==================================

    public function createEmailTemplate(Request $request)
    {
        if (Gate::allows('CanCreateEmailTemplate')) {
            $request->validate([
                'template_name'    => 'required|string',
                'email_subject'    => 'required|string',
                'status'           => 'required|boolean',
                'email_body'       => 'required',
                'email_attachment' => 'required|file|max:1000',
                'sender_name'      => 'required|string',
                'sender_email'     => 'required|email',
            ]);

            if (auth()->user()->adminCheck()) {
                $request->validate([
                    'company' => 'required|integer|exists:companies,id',
                ]);
            }

            if ($request->hasFile('email_attachment')) {
                $attachments = [
                    [
                        'content' => base64_encode(file_get_contents($request->file('email_attachment')->path())),
                        'type'    => $request->file('email_attachment')->getClientMimeType(),
                        'name'    => $request->file('email_attachment')->getClientOriginalName(),
                    ],
                ];
            } else {
                $attachments = [];
            }

            if ($request->body_type == 'html') {
                $email_html = $request->email_body;
                $email_text = null;
            } else {
                $email_text = $request->email_body;
                $email_html = null;
            }

            $formattedDate = $this->getTimeGoPhish();
            $newId         = $this->getIdFromGophish('templates');
            $envelope      = $request->sender_name . ' <' . $request->sender_email . '>';
            $jsonData      = [
                'id'              => $newId,
                'name'            => $request->template_name . ' -+-' . $newId,
                'subject'         => $request->email_subject,
                'envelope_sender' => $envelope,
                'text'            => $email_text,
                'html'            => $email_html,
                'modified_date'   => $formattedDate,
                'attachments'     => $attachments,
            ];
            $jsonString = json_encode($jsonData);
            $response   = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->post("{$this->url}/templates/", $jsonData);
            if ($response->successful() && $response->body() != []) {
                $idGophish                         = $response->json()['id'];
                $companyEmailTemplate              = new EmailTemplateCompany();
                $companyEmailTemplate->company_id  = auth()->user()->adminCheck() ? $request->company : auth()->user()->company_id;
                $companyEmailTemplate->template_id = $idGophish;
                $companyEmailTemplate->status      = $request->status;
                $companyEmailTemplate->save();
                return response()->json(['message' => 'Email template created successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            abort(403);
        }

    }

    public function getEmailTemplate(Request $request)
    {
        if (Gate::allows('CanReadEmailTemplate')) {
            if ($request->has('status') && $request->status != null) {
                $emailTemplate = auth()->user()->accessibleEmailTemplate()->where('status', $request->status);
            }
            if (Gate::allows('IsAdmin')) {
                if ($request->has('companyId') && $request->companyId != null) {
                    $emailTemplate->where('company_id', $request->companyId);
                }
            }
            $emailTemplate = $emailTemplate->pluck('template_id');

            $responses = [];

            foreach ($emailTemplate as $value) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                ])->get("{$this->url}/templates/{$value}");

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['name'])) {
                        $data['name'] = explode('-+-', $data['name'])[0];
                    }
                    $responses[] = $data;
                }
            }

            $responseCollection = collect($responses);

            if ($request->has('search') && $request->search != null) {
                $responseCollection = $responseCollection->filter(function ($item) use ($request) {
                    return stripos($item['name'], $request->search) !== false;
                });
            }
            $perPage       = $request->has('show') ? (int) $request->show : 10;
            $currentPage   = $request->has('page') ? (int) $request->page : 1;
            $pagedData     = $responseCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedData = new LengthAwarePaginator(
                $pagedData,
                $responseCollection->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $totalTemplate  = $responseCollection->count();
            $firstPageTotal = $responseCollection->slice(0, $perPage)->count();

            return response()->json([
                'data'           => $paginatedData->items(),
                'templateTotal'  => $totalTemplate,
                'currentPage'    => $paginatedData->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount'      => $paginatedData->lastPage(),
            ]);
        } else {
            abort(403);
        }

    }

    public function updateEmailTemplate(Request $request)
    {
        if (Gate::allows('CanUpdateEmailTemplate')) {
            $request->validate([
                'template_name'        => 'required|string',
                'email_subject'        => 'required|string',
                'email_body'           => 'required',
                'status'               => 'required|boolean',
                'old_email_attachment' => [
                    'nullable',
                    'string',
                    Rule::requiredIf(function () use ($request) {
                        return $request->input('email_attachment') === null;
                    }),
                ],
                'email_attachment'     => [
                    'nullable',
                    'file',
                    'max:1000',
                    Rule::requiredIf(function () use ($request) {
                        return $request->input('old_email_attachment') === 'null';
                    }),
                ],
                'sender_name'          => 'required|string',
                'sender_email'         => 'required|email',
                'body_type'            => 'required|in:text,html',
            ]);

            $formattedDate = $this->getTimeGoPhish();

            if ($request->hasFile('email_attachment') && $request->email_attachment != null) {
                $attachments = [
                    [
                        'content' => base64_encode(file_get_contents($request->file('email_attachment')->path())),
                        'type'    => $request->file('email_attachment')->getClientMimeType(),
                        'name'    => $request->file('email_attachment')->getClientOriginalName(),
                    ],
                ];
            } else {
                $tempFile       = $request->old_email_attachment;
                $tempAttachment = json_decode($tempFile);
                $attachments    = [
                    [
                        'content' => $tempAttachment->content,
                        'type'    => $tempAttachment->type,
                        'name'    => $tempAttachment->name,
                    ],

                ];
            }

            if ($request->body_type == 'html') {
                $email_html = $request->email_body;
                $email_text = null;
            } else {
                $email_text = $request->email_body;
                $email_html = null;
            }
            $templateId = $request->id;
            $envelope   = $request->sender_name . ' <' . $request->sender_email . '>';
            $jsonData   = [
                'id'              => intval($request->id),
                'template_id'     => $request->id,
                'name'            => $request->template_name . ' -+-' . $request->id,
                'subject'         => $request->email_subject,
                'text'            => $email_text,
                'envelope_sender' => $envelope,
                'html'            => $email_html,
                'modified_date'   => $formattedDate,
                'attachments'     => $attachments,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->put("{$this->url}/templates/{$templateId}", $jsonData);
            if ($response->successful() && $response->body() != []) {
                if ($request->status != null) {
                    $companyEmailTemplate         = auth()->user()->accessibleEmailTemplate()->where('template_id', $templateId)->first();
                    $companyEmailTemplate->status = $request->status;
                    $companyEmailTemplate->save();
                }
                return response()->json(['message' => 'Email template updated successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function deleteEmailTemplate(Request $request)
    {
        if (Gate::allows('CanDeleteEmailTemplate')) {
            $templateId = intval($request->id);
            $response   = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->delete("{$this->url}/templates/{$templateId}");
            if ($response->successful() && $response->body() != []) {
                $companyEmailTemplate = auth()->user()->accessibleEmailTemplate()->where('template_id', $templateId)->first();
                $companyEmailTemplate->delete();
                return response()->json(['message' => 'Email template deleted successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function activateEmailTemplate(Request $request)
    {
        if (Gate::allows('CanUpdateEmailTemplate')) {
            $templateId                   = intval($request->id);
            $companyEmailTemplate         = auth()->user()->accessibleEmailTemplate()->where('template_id', $templateId)->first();
            $companyEmailTemplate->status = 1;
            $companyEmailTemplate->save();
            return response()->json(['message' => 'Email template activated successfully']);
        }
    }

    // ================================== End Email Templates ==================================

    // ================================== Sending Profile ==================================

    public function createSendingProfile(Request $request)
    {
        if (Gate::allows('CanCreateSendingProfile')) {
            $request->validate([
                'profile_name'       => 'required|string',
                'interface_type'     => 'required|in:smtp',
                'email_smtp'         => 'required|email',
                'host'               => 'required|regex:/^[a-zA-Z0-9.-]+:[0-9]+$/',
                'ignore_certificate' => 'required|boolean',
                'username'           => 'nullable|string',
                'password'           => 'nullable|string',
                'http_headers'       => 'nullable|array',
            ]);
            if (auth()->user()->adminCheck()) {
                $request->validate([
                    'company' => 'required|integer|exists:companies,id',
                ]);
            }
            $newId         = $this->getIdFromGophish('smtp');
            $formattedDate = $this->getTimeGoPhish();
            $envelope      = $request->email_smtp;
            $httpHeaders   = [];
            if ($request->has('http_headers') && $request->http_headers != null) {
                foreach ($request->http_headers as $key => $value) {
                    $httpHeaders[] = [
                        'key'   => $value['header_email'],
                        'value' => $value['header_value'],
                    ];
                }
            }
            $jsonData = [
                'id'                 => $newId,
                'name'               => $request->profile_name . ' -+-' . $newId,
                'interface_type'     => $request->interface_type,
                'from_address'       => $envelope,
                'host'               => $request->host,
                'username'           => $request->username,
                'password'           => $request->password,
                'ignore_cert_errors' => $request->ignore_certificate == 1 ? true : false,
                'modified_date'      => $formattedDate,
                'headers'            => $httpHeaders,

            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->post("{$this->url}/smtp/", $jsonData);
            if ($response->successful() && $response->body() != []) {
                $idGophish                                 = $response->json()['id'];
                $companySendingProfile                     = new SendingProfileCompany();
                $companySendingProfile->company_id         = auth()->user()->adminCheck() ? $request->company : auth()->user()->company_id;
                $companySendingProfile->sending_profile_id = $idGophish;
                $companySendingProfile->status             = 1;
                $companySendingProfile->save();
                return response()->json(['message' => 'Sending profile created successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

    }

    public function getSendingProfile(Request $request)
    {
        if (Gate::allows('CanReadSendingProfile')) {
            if ($request->has('status') && $request->status != null) {
                $sendingProfile = auth()->user()->accessibleSendingProfile()->where('status', $request->status);
            }

            if (Gate::allows('IsAdmin')) {
                if ($request->has('companyId') && $request->companyId != null) {
                    $sendingProfile->where('company_id', $request->companyId);
                }
            }
            $sendingProfile = $sendingProfile->pluck('sending_profile_id');

            $responses = [];
            foreach ($sendingProfile as $value) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                ])->get("{$this->url}/smtp/{$value}");

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['name'])) {
                        $data['name'] = explode('-+-', $data['name'])[0];
                    }
                    $responses[] = $data;
                }
            }

            $responseCollection = collect($responses);
            if ($request->has('search') && $request->search != null) {
                $responseCollection = $responseCollection->filter(function ($item) use ($request) {
                    return stripos($item['name'], $request->search) !== false;
                });
            }
            $perPage       = $request->has('show') ? (int) $request->show : 10;
            $currentPage   = $request->has('page') ? (int) $request->page : 1;
            $pagedData     = $responseCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedData = new LengthAwarePaginator(
                $pagedData,
                $responseCollection->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $totalProfile   = $responseCollection->count();
            $firstPageTotal = $responseCollection->slice(0, $perPage)->count();

            return response()->json([
                'data'           => $paginatedData->items(),
                'profileTotal'   => $totalProfile,
                'currentPage'    => $paginatedData->currentPage(),
                'firstPageTotal' => $firstPageTotal,
                'pageCount'      => $paginatedData->lastPage(),
            ]);
        } else {
            abort(403);
        }

    }

    public function updateSendingProfile(Request $request)
    {
        if (Gate::allows('CanUpdateSendingProfile')) {
            $request->validate([
                'id'                 => 'required|integer',
                'name'               => 'required|string',
                'interface_type'     => 'required|in:smtp',
                'email'              => 'required|email',
                'host'               => 'required|regex:/^[a-zA-Z0-9.-]+:[0-9]+$/',
                'status'             => 'required|boolean',
                'ignore_cert_errors' => 'required|boolean',
                'username'           => 'nullable|string',
                'password'           => 'nullable|string',
                'http_headers'       => 'nullable|array',
            ]);

            $formattedDate = $this->getTimeGoPhish();

            if ($request->has('http_headers') && $request->http_headers != null) {
                $httpHeaders = [];
                foreach ($request->http_headers as $key => $value) {
                    $httpHeaders[] = [
                        'key'   => $value['header_email'],
                        'value' => $value['header_value'],
                    ];
                }
            } else {
                $httpHeaders = [];
            }
            $envelope = $request->email;
            $jsonData = [
                'id'                 => intval($request->id),
                'name'               => $request->name . ' -+-' . $request->id,
                'interface_type'     => $request->interface_type,
                'from_address'       => $envelope,
                'host'               => $request->host,
                'username'           => $request->username,
                'password'           => $request->password,
                'ignore_cert_errors' => $request->ignore_cert_errors == 1 ? true : false,
                'modified_date'      => $formattedDate,
                'headers'            => $httpHeaders,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->put("{$this->url}/smtp/{$request->id}", $jsonData);
            if ($response->successful() && $response->body() != []) {
                if ($request->status != null) {
                    $companySendingProfile         = auth()->user()->accessibleSendingProfile()->where('sending_profile_id', $request->id)->first();
                    $companySendingProfile->status = $request->status;
                    $companySendingProfile->save();
                }
                return response()->json(['message' => 'Sending profile updated successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function deleteSendingProfile(Request $request)
    {
        if (Gate::allows('CanDeleteSendingProfile')) {
            $profileId = intval($request->id);
            $response  = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->delete("{$this->url}/smtp/{$profileId}");
            if ($response->successful() && $response->body() != []) {
                $companySendingProfile = auth()->user()->accessibleSendingProfile()->where('sending_profile_id', $profileId)->first();
                $companySendingProfile->delete();
                return response()->json(['message' => 'Sending profile deleted successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function activateSendingProfile(Request $request)
    {
        if (Gate::allows('CanUpdateSendingProfile')) {
            $profileId                     = intval($request->id);
            $companySendingProfile         = auth()->user()->accessibleSendingProfile()->where('sending_profile_id', $profileId)->first();
            $companySendingProfile->status = 1;
            $companySendingProfile->save();
            return response()->json(['message' => 'Sending profile activated successfully']);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function testSendingProfile(Request $request)
    {
        $request->validate([
            'interface_type'     => 'required|in:smtp',
            'email_smtp'         => 'required|email',
            'host'               => 'required|regex:/^[a-zA-Z0-9.-]+:[0-9]+$/',
            'ignore_certificate' => 'required|boolean',
            'username'           => 'nullable|string',
            'password'           => 'nullable|string',
            'http_headers'       => 'nullable|array',
            'target_email'       => 'required|email',
            'target_name'        => 'required|string',
        ]);
        [$host, $port] = explode(':', $request->input('host'));
        config([
            'mail.mailers.smtp.host'       => $host,
            'mail.mailers.smtp.port'       => $port,
            'mail.mailers.smtp.username'   => $request->input('username'),
            'mail.mailers.smtp.password'   => $request->input('password'),
            'mail.mailers.smtp.encryption' => $request->input('ignore_certificate') ? null : 'ssl',
            'mail.from.address'            => $request->input('email_smtp'),
            'mail.from.name'               => $request->input('username'),
        ]);

        try {
            Mail::raw('This is a test email to validate the SMTP configuration.', function ($message) use ($request) {
                $message->to($request->input('target_email'))
                    ->subject('Hi ' . $request->input('target_name') . ', this is a test email from Gophish');
                if ($request->input('http_headers')) {
                    foreach ($request->input('http_headers') as $header => $value) {
                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                        $message->getHeaders()->addTextHeader($header, $value);
                    }
                }
            });
            return response()->json(['message' => 'Test email sent successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Test email failed to send: ' . $e->getMessage(),
            ], 500);
        }
    }
    // ================================== End Sending Profile ==================================

    // ================================== Campaign ==================================
    public function getCampaignResources()
    {
        $emailTemplatesApp  = auth()->user()->accessibleEmailTemplate()->where('status', 1)->pluck('template_id');
        $sendingProfilesApp = auth()->user()->accessibleSendingProfile()->where('status', 1)->pluck('sending_profile_id');
        $groupApp           = auth()->user()->accessibleGroup()->where('status', 1)->pluck('gophish_id');
        $emailTemplates     = [];
        $sendingProfiles    = [];
        $groups             = [];
        $landingPages       = [];
        foreach ($emailTemplatesApp as $value) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->get("{$this->url}/templates/{$value}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['name'])) {
                    $data['name'] = explode('-+-', $data['name'])[0];
                }
                $emailTemplates[] = ['id' => $data['id'], 'name' => $data['name']];
            }
        }
        foreach ($sendingProfilesApp as $value) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->get("{$this->url}/smtp/{$value}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['name'])) {
                    $data['name'] = explode('-+-', $data['name'])[0];
                }
                $sendingProfiles[] = ['id' => $data['id'], 'name' => $data['name']];
            }
        }
        foreach ($groupApp as $value) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->get("{$this->url}/groups/{$value}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['name'])) {
                    $data['name'] = explode('-+-', $data['name'])[0];
                }
                $groups[] = ['id' => $data['id'], 'name' => $data['name']];
            }
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/pages");
        if ($response->successful()) {
            $data = $response->json();
            foreach ($data as $value) {
                if (isset($value['name'])) {
                    $value['name'] = explode('-+-', $value['name'])[0];
                }
                $landingPages[] = ['id' => $value['id'], 'name' => $value['name']];
            }
        }
        return response()->json([
            'emailTemplates'  => $emailTemplates,
            'sendingProfiles' => $sendingProfiles,
            'groups'          => $groups,
            'landingPages'    => $landingPages,
        ]);
    }
    public function testConnection(Request $request)
    {
        $request->validate([
            'id'    => 'required|integer',
            'name'  => 'required|string',
            'email' => 'required|email',
        ]);
        $id       = $request->input('id');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/smtp/{$id}");

        if (! $response->successful()) {
            return response()->json(['error' => 'Failed to fetch SMTP configuration'], 500);
        }
        $smtp = $response->json();
        try {
            if (! isset($smtp['host'], $smtp['from_address'])) {
                return response()->json(['error' => 'Invalid SMTP configuration'], 400);
            }
            [$host, $port]    = explode(':', $smtp['host']);
            $formattedAddress = $this->formatAddress($smtp['from_address']);
            config([
                'mail.mailers.smtp.host'       => $host,
                'mail.mailers.smtp.port'       => $port,
                'mail.mailers.smtp.username'   => $smtp['username'],
                'mail.mailers.smtp.password'   => $smtp['password'],
                'mail.mailers.smtp.encryption' => $smtp['ignore_cert_errors'] ? null : 'ssl',
                'mail.from.address'            => $formattedAddress['email'],
                'mail.from.name'               => $formattedAddress['name'],
            ]);
            Mail::raw('This is a test email to validate the SMTP configuration.', function ($message) use ($request) {
                $message->to($request->input('email'))
                    ->subject('Hi ' . $request->input('name') . ', this is a test email from Gophish');
                if ($request->input('http_headers')) {
                    foreach ($request->input('http_headers') as $header => $value) {
                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                        $message->getHeaders()->addTextHeader($header, (string) $value);
                    }
                }
            });
            return response()->json(['message' => 'Test email sent successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Test email failed: ' . $e->getMessage()], 500);
        }
    }

    public function formatAddress($address)
    {
        if (preg_match('/^(.+?)\s*<(.+?)>$/', $address, $matches)) {
            return [
                'name'  => $matches[1],
                'email' => $matches[2],
            ];
        }
        if (preg_match('/^[^@]+@[^@]+\.[^@]+$/', $address)) {
            return [
                'name'  => '',
                'email' => $address,
            ];
        }
        return [
            'name'  => 'Default Name',
            'email' => 'default@example.com',
        ];
    }

    public function createCampaign(Request $request)
    {
        if (Gate::allows('IsAdmin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        } else if (Gate::allows('CanCreateCampaign')) {
            $request->validate([
                'name'       => 'required|string',
                'template'   => 'required|integer|exists:email_template_companies,template_id',
                'page'       => 'required|integer',
                'launchDate' => 'required|date',
                'end_date'   => 'nullable|date',
                'url'        => 'required|url',
                'status'     => 'required|in:1,0',
                'profile'    => 'required|integer|exists:sending_profile_companies,sending_profile_id',
                'groups'     => 'required|array|min:1',
            ]);

            $launchDate = new DateTime($request->launchDate);
            $launchDate->modify('-7 hours');
            $launchDate->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $formattedLaunchDate = $launchDate->format('Y-m-d\TH:i:s.uP');
            $end_date            = $request->end_date && $request->end_date != null ? new DateTime($request->end_date) : null;
            if ($end_date) {
                $end_date->modify('-7 hours');
                $end_date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                $formattedEndDate = $end_date->format('Y-m-d\TH:i:s.uP');
            } else {
                $formattedEndDate = null;
            }

            $templateId = intval($request->template);
            $pageId     = intval($request->page);
            $profileId  = intval($request->profile);
            $groupIds   = $request->groups;
            $groupName  = [];

            $template = $this->getDetailsModuleGophish('templates', $templateId);
            $page     = $this->getDetailsModuleGophish('pages', $pageId);
            $profile  = $this->getDetailsModuleGophish('smtp', $profileId);
            foreach ($groupIds as $groupId) {
                $group               = $this->getDetailsModuleGophish('groups', $groupId);
                $groupName[]['name'] = $group['name'];
            }
            $pageName     = $page['name'];
            $templateName = $template['name'];
            $profileName  = $profile['name'];

            $jsonData = [
                'name'         => $request->name,
                'template'     => [
                    'name' => $templateName,

                ],
                'url'          => $request->url,
                'page'         => [
                    'name' => $pageName,

                ],
                'smtp'         => [
                    'name' => $profileName,

                ],
                'launch_date'  => $formattedLaunchDate,
                'send_by_date' => $formattedEndDate,
                'groups'       => $groupName,
            ];

            $campaign             = new Campaign();
            $campaign->data       = json_encode($jsonData);
            $campaign->company_id = auth()->user()->company_id;
            $campaign->user_id    = auth()->user()->id;
            $campaign->updated_at = Carbon::now();
            $campaign->status_id  = 1;
            $campaign->save();

            $company      = Company::find($campaign->company_id);
            $companyOwner = $company->user->email;
            RequestApprovalCampaignJob::dispatch($companyOwner, $campaign->id);

            return response()->json([
                'success' => true,
                'message' => 'Campaign created successfully',
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

    }

    public function getCampaigns(Request $request)
    {

        if (Gate::allows('CanReadCampaign')) {
            if ($request->has('status') && ($request->status == 1 || $request->status == 3)) {
                $campaigns = Campaign::where('status_id', $request->status);
                if (Gate::allows('IsAdmin')) {
                    if ($request->has('companyId') && $request->companyId != null) {
                        $campaigns->where('company_id', $request->companyId);
                    }
                } else {
                    $campaigns->where('company_id', auth()->user()->company_id);
                }
                if ($request->has('search') && $request->search != null) {
                    $searchTerm = $request->search;
                    $campaigns->whereRaw("JSON_EXTRACT(data, '$.name') LIKE ?", ["%{$searchTerm}%"]);
                }
                if ($request->has('show') && $request->show != null) {
                    $perPage = $request->show;
                }
                if ($request->has('page') && $request->page != null) {
                    $currentPage = $request->page;
                }
                $campaigns = $campaigns->paginate($perPage);
                return response()->json([
                    'data'           => $campaigns->items(),
                    'campaignTotal'  => $campaigns->total(),
                    'currentPage'    => $campaigns->currentPage(),
                    'firstPageTotal' => $campaigns->count(),
                    'pageCount'      => $campaigns->lastPage(),
                ]);

            } else {
                $campaigns = auth()->user()->accessibleCampaign();
                if (Gate::allows('IsAdmin')) {
                    if ($request->has('companyId') && $request->companyId != null) {
                        $campaigns->where('company_id', $request->companyId);
                    }
                }
                $campaigns     = $campaigns->get();
                $campaignsData = [];
                foreach ($campaigns as $campaign) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
                    ])->get("{$this->url}/campaigns/{$campaign->campaign_id}");
                    if ($response->successful()) {
                        $data = $response->json();
                        if (isset($data['name'])) {
                            $data['name'] = explode('-+-', $data['name'])[0];
                        }
                        $campaignsData[] = $data;
                    }
                }
                $responseCollection = collect($campaignsData);
                if ($request->has('search') && $request->search != null) {
                    $responseCollection = $responseCollection->filter(function ($item) use ($request) {
                        return stripos($item['name'], $request->search) !== false;
                    });
                }
                $perPage       = $request->has('show') ? (int) $request->show : 10;
                $currentPage   = $request->has('page') ? (int) $request->page : 1;
                $pagedData     = $responseCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
                $paginatedData = new LengthAwarePaginator(
                    $pagedData,
                    $responseCollection->count(),
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->query()]
                );

                $totalCampaign  = $responseCollection->count();
                $firstPageTotal = $responseCollection->slice(0, $perPage)->count();
                return response()->json([
                    'data'           => $paginatedData->items(),
                    'campaignTotal'  => $totalCampaign,
                    'currentPage'    => $paginatedData->currentPage(),
                    'firstPageTotal' => $firstPageTotal,
                    'pageCount'      => $paginatedData->lastPage(),
                ]);
            }
        } else {
            abort(403);
        }
    }

    public function deleteCampaign(Request $request)
    {
        if (Gate::allows('IsCompanyAdmin', auth()->user()->company_id)) {
            $campaignId = intval($request->id);
            $response   = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
            ])->delete("{$this->url}/campaigns/{$campaignId}");
            if ($response->successful() && $response->body() != []) {
                $companyCampaign = auth()->user()->accessibleCampaign()->where('campaign_id', $campaignId)->first();
                $companyCampaign->delete();
                return response()->json(['message' => 'Campaign deleted successfully']);
            } else {
                return response()->json(['error' => $response->json()], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

    }

    public function getCampaignData(Request $request)
    {
        if (Gate::allows('CanReadCampaign')) {
            $campaignId               = intval($request->id);
            $data                     = $this->getDetailsModuleGophish('campaigns', $campaignId);
            $data['name']             = explode('-+-', $data['name'])[0];
            $data['template']['name'] = explode('-+-', $data['template']['name'])[0];
            $data['page']['name']     = explode('-+-', $data['page']['name'])[0];
            $data['smtp']['name']     = explode('-+-', $data['smtp']['name'])[0];
            $page                     = $request->page ? $request->page : 1;
            $perPage                  = 5;

            if (isset($data['results']) && is_array($data['results'])) {
                $totalResults              = count($data['results']);
                $totalPages                = ceil($totalResults / $perPage);
                $offset                    = ($page - 1) * $perPage;
                $data['paginated_results'] = array_slice($data['results'], $offset, $perPage);
                if ($request->has('search') && $request->search != null) {
                    $data['paginated_results'] = array_filter($data['paginated_results'], function ($result) use ($request) {
                        return stripos($result['email'], $request->search) !== false;
                    });
                }
                $data['pagination'] = [
                    'current_page'  => $page,
                    'per_page'      => $perPage,
                    'total_results' => $totalResults,
                    'total_pages'   => $totalPages,
                ];
            }

            return response()->json($data);
        } else {
            abort(403);
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

        Mail::to($companyOwner)->send(new ApprovalMail($campaign));

        return response()->json(['message' => 'Approval email sent successfully!']);
    }

}
