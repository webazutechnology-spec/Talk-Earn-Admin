<?php
namespace App\Helpers;


use Google\Auth\Credentials\ServiceAccountCredentials;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\WhatsappTemplate;
use App\Models\WhatsappLog;
use App\Models\ActivityLog;
use App\Models\Wallet;
use App\Models\Ledger;
use App\Models\User;

class Helper
{
    
    public static function getTransId($type='')
	{
		if($type == 1)
		{
			return date('dmY').time();
		}
		else if ($type == 2) 
		{
			return config('app.shortname').date('dmy').time();
		}
		else if ($type == 3) 
		{
			return rand(000,999).date('dmy').time();
		}
		else if ($type == 4) 
		{
			return Str::random(12);
		}
		else
		{
			return $type.date('dmy').time();
		}
	}



    
	public static function creadit_ledger($data)
	{
		if (count($data) != 10) {
			return ['status' => 'error', 'message' => 'invalid credentials.'];
		}

		$userwallet = Wallet::where('user_id', $data['user_id'])->first();
		if (!$userwallet) {
			return ['status' => 'error', 'message' => 'invalid credentials.'];
		}

		$walletMap = [
			1 => ['column' => 'main_balance',  'ledger_bal_type' => 'MAIN'],
			2 => ['column' => 'dmt_balance',   'ledger_bal_type' => 'DMT'],
			3 => ['column' => 'aeps_balance',  'ledger_bal_type' => 'AEPS'],
			4 => ['column' => 'digi_balance',  'ledger_bal_type' => 'DIGI'],
			5 => ['column' => 'vps_balance',   'ledger_bal_type' => 'VPS'],
			6 => ['column' => 'bonus_balance', 'ledger_bal_type' => 'BONUS'],
		];

		if (!isset($walletMap[$data['wallet_type']])) {
			return ['status' => 'error', 'message' => 'Invalid Wallet type.'];
		}

		$walletKey = $walletMap[$data['wallet_type']]['column'];
		$ledgerType = $walletMap[$data['wallet_type']]['ledger_bal_type'];

		$wallet_bal = (float) $userwallet->{$walletKey};

		$ledgerBalance = Ledger::where('user_id', $data['user_id'])
			->where('bal_type', $ledgerType)
			->sum(DB::raw('cramount - dramount'));

		if ((float)$wallet_bal !== (float)$ledgerBalance) {
			return ['status' => 'error', 'message' => 'Wallet balance is low.'];
		}

		$creditAmount = abs((float)$data['amount']);
		$current_bal = $wallet_bal + $creditAmount;

		if ($current_bal < 0) {
			return ['status' => 'error', 'message' => 'negative balance not accepted.'];
		}


		$ledgerData = [
			"user_id"      => $data['user_id'],
			"trans_id"     => $data['trans_id'],
			"refrence_id"  => $data['refrence_id'],
			"old_bal"      => $wallet_bal,
			"current_bal"  => $current_bal,
			"cramount"     => $creditAmount,
			"dramount"     => 0.00,
			"cgst"         => (float)$data['cgst'],
			"sgst"         => (float)$data['sgst'],
			"ledger_type"  => $data['ledger_type'],
			"bal_type"     => $ledgerType,
			"trans_from"   => $data['trans_from'],
			"description"  => $data['description']
		];

		$insertId = Ledger::insertGetId($ledgerData);

		if (!$insertId) {
			return ['status' => 'error', 'message' => 'Unable to update ledger.'];
		}

		Wallet::where('user_id', $data['user_id'])->update([
			$walletKey => $current_bal
		]);

		return [
			'status' => 'success',
			'message' => 'Successfully Txn.',
			'insertGetId' => $insertId
		];
	}

	public static function debit_ledger($data)
	{
		if (count($data) != 10) {
			return ['status' => 'error', 'message' => 'invalid credentials.'];
		}

		$userwallet = Wallet::where('user_id', $data['user_id'])->first();
		if (!$userwallet) {
			return ['status' => 'error', 'message' => 'invalid credentials.'];
		}

		$walletMap = [
			1 => ['column' => 'main_balance',  'ledger_bal_type' => 'MAIN'],
			2 => ['column' => 'dmt_balance',   'ledger_bal_type' => 'DMT'],
			3 => ['column' => 'aeps_balance',  'ledger_bal_type' => 'AEPS'],
			4 => ['column' => 'digi_balance',  'ledger_bal_type' => 'DIGI'],
			5 => ['column' => 'vps_balance',   'ledger_bal_type' => 'VPS'],
			6 => ['column' => 'bonus_balance', 'ledger_bal_type' => 'BONUS'],
		];

		if (!isset($walletMap[$data['wallet_type']])) {
			return ['status' => 'error', 'message' => 'Invalid Wallet type.'];
		}

		$walletKey = $walletMap[$data['wallet_type']]['column'];
		$ledgerType = $walletMap[$data['wallet_type']]['ledger_bal_type'];

		$wallet_bal = (float) $userwallet->{$walletKey};

		if ($wallet_bal < 1) {
			return ['status' => 'error', 'message' => 'Wallet balance is low.'];
		}


		$ledgerBalance = Ledger::where('user_id', $data['user_id'])
			->where('bal_type', $ledgerType)
			->sum(DB::raw('cramount - dramount'));


		if ((float)$wallet_bal !== (float)$ledgerBalance) {
			return ['status' => 'error', 'message' => 'Wallet balance is low.'];
		}


		$debitAmount = abs((float)$data['amount']);
		$current_bal = $wallet_bal - $debitAmount;

		if ($current_bal < 0) {
			return ['status' => 'error', 'message' => 'Insufficient balance.'];
		}

		$ledgerData = [
			"user_id"      => $data['user_id'],
			"trans_id"     => $data['trans_id'],
			"refrence_id"  => $data['refrence_id'],
			"old_bal"      => $wallet_bal,
			"current_bal"  => $current_bal,
			"cramount"     => 0.00,
			"dramount"     => $debitAmount,
			"cgst"         => (float)$data['cgst'],
			"sgst"         => (float)$data['sgst'],
			"ledger_type"  => $data['ledger_type'],
			"bal_type"     => $ledgerType,
			"trans_from"   => $data['trans_from'],
			"description"  => $data['description']
		];


		$insertId = Ledger::insertGetId($ledgerData);
		if (!$insertId) {
			return ['status' => 'error', 'message' => 'Ledger update failed.'];
		}

		Wallet::where('user_id', $data['user_id'])->update([
			$walletKey => $current_bal
		]);

		return [
			'status' => 'success',
			'message' => 'Successfully Txn.',
			'insertGetId' => $insertId
		];
	}




    /**
     * Create a new activity log
     *
     * @param array $data
     *      Required keys: user_id, user_type, type, title, message
     *      Optional keys: notification_show, old_data, form_data, reference_id
     */
    public static function logActivity(array $data)
    {   
        $user = User::where('id', auth()->user()->id)->first();

        ActivityLog::create([
            'user_id'       => $user->id,
            'user_type'     => $user->roles->type,
            'type'          => $data['type'],
            'title'         => $data['title'],
            'message'       => $data['message'],
            'route_name'    => $data['route_name'],
            'old_data'      => json_encode($data['old_data']),
            'form_data'     => json_encode($data['form_data']),
            'reference_id'  => $data['ref_id'],
            'notification_show' => $data['show'],
            'deleted_at'    => $user->activity == 'On' ? now() : null
        ]);
        
        if($data['show'] == 'Yes'){
            $title   = $data['title'];
            $message = $data['message'];
            $link    = route($data['route_name']);
            $icon    = 'bx bx-cart-alt'; 

            $user->notify(new NewOrderNotification($title, $message, $link, $icon));
        }
    }



    public static function send_sms($data)
    {
        // 1. Basic Validation
        if (empty($data['send_to_phone']) || empty($data['template_name'])) {
            return;
        }

        // 2. Fetch Template Configuration from DB
        $templateConfig = WhatsappTemplate::where('template_name', $data['template_name'])->first();

        if (!$templateConfig) {
            // Log error: Template not found in DB
            return;
        }

        try {
            // 3. Initialize Base Payload
            $payload = [
                'from_phone_number_id' => '', // Add your ID if needed or keep blank as per your code
                'phone_number'         => '91' . $data['send_to_phone'],
                'template_name'        => $templateConfig->template_name,
                'template_language'    => $templateConfig->language,
            ];

            // 4. Dynamic Mapping
            // We loop through the DB mapping keys (field_1, field_2) 
            // and grab the corresponding value from your $data array.
            foreach ($templateConfig->variable_mapping as $apiField => $dataKey) {
                
                // Use generic text if data is missing, or strictly require it
                $value = isset($data[$dataKey]) ? $data[$dataKey] : ''; 
                
                $payload[$apiField] = $value;
            }

            // 5. Send API Request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://www.flexgoapi.com/api/00971a43-2667-485e-8f48-0884483650c3/contact/send-template-message?token=gIRbyqCAxO7XZ0Uvw9O5YikPZeELz9sA4O1PsOqvonGDk48pDjiH6g9B4BXFx1jW', $payload);

            $responseData = $response->json();

            WhatsappLog::create([
                'phone_number'  => $payload['phone_number'],
                'template_used' => $payload['template_name'],
                'payload_sent'  => $payload,        // no need for json_encode (Eloquent handles it)
                'api_response'  => $responseData,   // also no json_encode
                'status'        => $response->successful() ? 1 : 0,
            ]);

            return $responseData;

        } catch (\Throwable $th) {
            // Log the exception
            \Log::error('WhatsApp Error: ' . $th->getMessage());
            return null;
        }
    }

    /**
     * Send a Firebase Push Notification (HTTP v1) using .env credentials
     *
     * @param  mixed  $user       The user model instance (must have fcm_token)
     * @param  string $title      Notification Title
     * @param  string $body       Notification Body
     * @param  string|null $link  (Optional) Link to open on click
     * @param  string|null $image (Optional) Image URL
     * @return array|bool         Response array or false on failure
     */
    public static function send_fcm_notification($user, $title, $body, $link = null, $image = null)
    {
        // 1. Basic Validation
        if (!$user || empty($user->fcm_token)) {
            return "FCM: User ID {$user->id} has no token.";
        }

        // 2. Get Access Token (Cached for 55 minutes to improve performance)
        $accessToken = Cache::remember('firebase_access_token', 3300, function () {
            
            // A. Load credentials from Config
            $clientEmail = config('services.firebase.client_email');
            $privateKey  = config('services.firebase.private_key');
            $projectId   = config('services.firebase.project_id');

            // B. Validate Config
            if (empty($clientEmail) || empty($privateKey) || empty($projectId)) {
                return "FCM: Missing credentials in .env or config/services.php";
            }

            // C. CRITICAL FIX: Handle Newlines in Private Key
            // If the key in .env contains literal "\n" characters, convert them to real newlines.
            // OpenSSL requires the key to be formatted with real line breaks.
            if (strpos($privateKey, '\\n') !== false) {
                $privateKey = str_replace('\\n', "\n", $privateKey);
            }

            // D. Authenticate manually (Array method, no file needed)
            try {
                $credentials = new ServiceAccountCredentials(
                    'https://www.googleapis.com/auth/firebase.messaging',
                    [
                        'client_email' => $clientEmail,
                        'private_key'  => $privateKey,
                        'project_id'   => $projectId,
                        'type'         => 'service_account', // Required
                    ]
                );

                $token = $credentials->fetchAuthToken();
                return $token['access_token'] ?? null;

            } catch (\Exception $e) {
                return "FCM Auth Error: " . $e->getMessage();
            }
        });

        // 3. Stop if authentication failed
        if (!$accessToken) {
            return "FCM: Could not generate Access Token.";
        }

        // 4. Build the Payload
        $projectId = config('services.firebase.project_id');
        
        $payload = [
            'message' => [
                'token' => $user->fcm_token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'webpush' => [
                    'fcm_options' => [
                        'link' => $link ?? url('/'),
                    ]
                ]
            ]
        ];

        // Add Image if present
        if ($image) {
            $payload['message']['notification']['image'] = $image;
        }

        // 5. Send Request to Google
        try {
            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

            // 6. Return Result
            if ($response->successful()) {
                return $response->json();
            } else {
                return $response->body();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}