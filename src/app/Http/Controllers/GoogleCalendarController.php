<?php

namespace App\Http\Controllers;

use App\Models\GoogleToken;
use App\Models\MedicationAlerts;
use App\Models\User;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    private static function getGoogleClient()
    {
        $client = new GoogleClient();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Calendar::CALENDAR_EVENTS);
        $client->setAccessType('offline'); // To get a refresh token
        $client->setPrompt('consent');
        return $client;
    }

    public static function redirectToGoogle()
    {
        $client = self::getGoogleClient();
        $authUrl = $client->createAuthUrl();    
        return redirect($authUrl);
    }    

    public static function handleGoogleCallback(Request $request)
    {
        $client = self::getGoogleClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));
    
        if (isset($token['error'])) {
            return redirect('/')->with('error', 'Failed to authenticate with Google.');
        }
    
        $userId = Auth::user()->id;
    
        GoogleToken::updateOrCreate(
            ['user_id' => $userId],
            [
                'access_token'  => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at'    => now()->addSeconds($token['expires_in']),
            ]
        );

        User::where('id', $userId)->update(['google_calendar_connection_status' => true]);
    
        return redirect('/playground')->with('status', 'Google Calendar connected!');
    }

    public static function refreshAccessToken($userId)
    {
        $googleToken = GoogleToken::where('user_id', $userId)->first();

        if (!$googleToken || !$googleToken->refresh_token) {
            return null;
        }

        // Check if the access token is still valid
        if (now()->lt($googleToken->expires_at)) {
            return $googleToken->access_token;
        }

        // Get a new access token
        $client = self::getGoogleClient();
        $client->refreshToken($googleToken->refresh_token);
        $newToken = $client->getAccessToken();

        // Update the database
        $googleToken->update([
            'access_token' => $newToken['access_token'],
            'expires_at'   => now()->addSeconds($newToken['expires_at']),
        ]);

        return $newToken['access_token'];
    }

    public static function addDosageEvent(Request $request)
    {
        $userId = Auth::user()->id;
        $timezone = $request->timezone ?? 'Asia/Kolkata'; // Default to Asia/Kolkata if not provided

        $alerts = MedicationAlerts::where('user_id', $userId)
            ->whereNotNull('medication_data')
            ->where('google_calendar_synced', false)
            ->get();

        $accessToken = self::refreshAccessToken($userId);

        if (!$accessToken) {
            return redirect('/auth/google')->with('error', 'Google authentication required.');
        }

        $client = self::getGoogleClient();
        $client->setAccessToken($accessToken);
        $service = new Calendar($client);
        $calendarId = 'primary';

        foreach ($alerts as $alert) {
            $alertData = $alert->medication_data;
            
            foreach ($alertData as $medicineName => $medicineDetails) {
                foreach ($medicineDetails['schedule'] as $scheduleTime) {
                    // Parse the schedule time
                    $startTime = \Carbon\Carbon::parse($scheduleTime);
                    $endTime = $startTime->copy()->addMinutes(5); // Set duration to 5 minutes

                    $notes = $medicineDetails['notes'] ? " - Note: {$medicineDetails['notes']}" : "";
                    
                    $event = new Event([
                        'summary' => "Medication Reminder: {$medicineName}",
                        'description' => "Time to take your medicine: {$medicineName}{$notes}",
                        'start' => ['dateTime' => $startTime->format('Y-m-d\TH:i:s'), 'timeZone' => $timezone],
                        'end' => ['dateTime' => $endTime->format('Y-m-d\TH:i:s'), 'timeZone' => $timezone],
                        'reminders' => [
                            'useDefault' => false,
                            'overrides' => [
                                ['method' => 'popup', 'minutes' => 10],
                                ['method' => 'email', 'minutes' => 30],
                            ],
                        ],
                    ]);

                    try {
                        $service->events->insert($calendarId, $event);
                        $alert->google_calendar_synced = true;
                        $alert->save();
                    } catch (\Exception $e) {
                        Log::error("Failed to create event for {$medicineName}: " . $e->getMessage());
                        continue;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Medicine schedule has been added to Google Calendar!'
        ]);
    }
}