<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplateCompany;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class GophishController extends Controller
{
    public $url = 'http://127.0.0.1:3333/api';

    // ================================== Landing Pages ==================================
    public function landingPagePreview($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get("{$this->url}/pages/{$id}");
        return view('contents.preview-page', ['data' => $response->json()]);
    }

    public function getLandingPage(Request $request)
    {
        $apiKey = env('GOPHISH_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get('http://127.0.0.1:3333/api/pages');

        if (!$response->successful()) {
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

        $landingPages = collect($landingPages);
        $perPage = $request->has('show') ? (int) $request->show : 10;
        $currentPage = $request->has('page') ? (int) $request->page : 1;
        $pagedData = $landingPages->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $pagedData,
            $landingPages->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $totalGroup = $landingPages->count();
        $firstPageTotal = $landingPages->slice(0, $perPage)->count();
        return response()->json([
            'landingPage' => $paginatedData->items(),
            'targetTotal' => $totalGroup,
            'currentPage' => $paginatedData->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount' => $paginatedData->lastPage(),
        ]);
    }

    // ================================== End Landing Pages ==================================

    // ================================== Email Templates ==================================

    public function createEmailTemplate(Request $request)
    {

        $request->validate([
            'template_name' => 'required|string',
            'email_subject' => 'required|string',
            'email_text' => 'required|string',
            'status' => 'required|boolean',
            'email_html' => 'required|string',
            'email_attachment' => 'required|file|mimes:jpg,jpeg,png|max:1000',
            'sender_name' => 'required|string',
            'sender_email' => 'required|email',
        ]);
        if ($request->hasFile('email_attachment')) {
            $attachments = [
                [
                    'content' => base64_encode(file_get_contents($request->file('email_attachment')->path())),
                    'type' => $request->file('email_attachment')->getClientMimeType(),
                    'name' => $request->file('email_attachment')->getClientOriginalName(),
                ],
            ];
        } else {
            $attachments = [];
        }

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Chicago'));
        $formattedDate = $date->format('Y-m-d\TH:i:s.uP');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->get('http://127.0.0.1:3333/api/templates');
        $existingIds = collect($response->json())->pluck('id');
        $newId = $existingIds->max() + 1;
        $envelope = $request->sender_name . ' <' . $request->sender_email . '>';
        $jsonData = [
            'id' => $newId,
            'name' => $request->template_name . ' -+-' . $newId,
            'subject' => $request->email_subject,
            'envelope_sender' => $envelope,
            'text' => $request->email_text,
            'html' => '<html><head></head><body>Please reset your password <a href\"{{.URL}}\">here</a></body></html>',
            'modified_date' => $formattedDate,
            'attachments' => $attachments,
        ];
        $jsonString = json_encode($jsonData);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GOPHISH_API_KEY'),
        ])->post("{$this->url}/templates/", $jsonData);
        if ($response->successful() && $response->body() != []) {
            $companyEmailTemplate = new EmailTemplateCompany();
            $companyEmailTemplate->company_id = auth()->user()->company_id;
            $companyEmailTemplate->template_id = $newId;
            $companyEmailTemplate->status = $request->status;
            $companyEmailTemplate->save();
            return response()->json(['message' => 'Email template created successfully']);
        } else {
            return response()->json(['error' => $response->json()], 500);
        }

    }

    public function getEmailTemplate(Request $request)
    {
        if ($request->has('status') && $request->status != null) {
            $emailTemplate = EmailTemplateCompany::where('company_id', auth()->user()->company_id)->where('status', $request->status)->pluck('template_id');
        }

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
        $perPage = $request->has('show') ? (int) $request->show : 10;
        $currentPage = $request->has('page') ? (int) $request->page : 1;
        $pagedData = $responseCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $pagedData,
            $responseCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $totalTemplate = $responseCollection->count();
        $firstPageTotal = $responseCollection->slice(0, $perPage)->count();

        return response()->json([
            'data' => $paginatedData->items(),
            'templateTotal' => $totalTemplate,
            'currentPage' => $paginatedData->currentPage(),
            'firstPageTotal' => $firstPageTotal,
            'pageCount' => $paginatedData->lastPage(),
        ]);

    }

    // ================================== End Email Templates ==================================

}
