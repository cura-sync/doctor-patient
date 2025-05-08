<?php

namespace Modules\Playground\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PlaygroundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isGoogleCalendarConnected = $this->isUserGoogleCalendarConnected;

        // Playground Card Data
        $totalTransactions = Transactions::where('user_id', Auth::user()->id)->count();
        $mostRecentTransaction = DB::table('transactions as t')
            ->select('d.document_name', 't.created_at')
            ->join('documents as d', 't.document_id', '=', 'd.id')
            ->where('t.user_id', Auth::user()->id)
            ->orderBy('t.created_at', 'desc')
            ->first();

        $quote = $this->getQuote();

        $googleCalendarConnectionStatus = DB::table('users')->where('id', Auth::user()->id)->value('google_calendar_connection_status');

        return view('playground::index', compact([
            'isGoogleCalendarConnected',
            'totalTransactions',
            'mostRecentTransaction',
            'quote',
            'googleCalendarConnectionStatus'
        ]));
    }

    private function getQuote()
    {
        $response = Http::withHeaders([
            'X-Api-Key' => env('QUOTE_API_KEY'),
        ])->get('https://api.api-ninjas.com/v1/quotes');

        if ($response->successful()) {
            $quote = $response->json()[0];
            return $quote;
        }
    }
}
