<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GoogleToken;
use Carbon\Carbon;
use Google\Client as GoogleClient;

class RefreshGoogleTokens extends Command
{
    protected $signature = 'google:refresh-tokens';
    protected $description = 'Refresh Google access tokens for users.';

    public function handle()
    {
        $tokens = GoogleToken::where('expires_in', '<', now())->get();

        foreach ($tokens as $token) {
            $client = new GoogleClient();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->refreshToken($token->refresh_token);
            $newToken = $client->getAccessToken();

            $token->update([
                'access_token' => $newToken['access_token'],
                'expires_in'   => now()->addSeconds($newToken['expires_in']),
            ]);
        }

        $this->info('Google tokens refreshed successfully.');
    }
}