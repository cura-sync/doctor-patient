<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GoogleToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\UserHandler;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Manage Account',
            'subtitle' => 'View your usage history and manage your account.'
        ];
        return view('user::index', compact('pageHeader'));
    }

    public function transactions()
    {
        $breadcrumbs = [
            [
                'label' => 'Home', 
                'url' => route('user.index')
            ],
            [
                'label' => 'Manage users', 
                'url' => route('user.index')
            ],
            [
                'label' => 'Transactions', 
                'url' => route('user.transactions')
            ],
        ];
        return view('user::transaction_grid', compact('breadcrumbs'));
    }

    public function checkGoogleConnection()
    {
        // Check google calendar connection
        $userGoogleConnection = false;
        $googleCalendar = GoogleToken::where('user_id', Auth::user()->id)->first();
        if ($googleCalendar) {
            $userGoogleConnection = true;
        }

        // Check google calendar connection status
        $userGoogleConnectionStatus = false;
        $user = User::where('id', Auth::user()->id)->first();
        if ($user->google_calendar_connection_status) {
            $userGoogleConnectionStatus = true;
        }

        return response()->json([
            'userGoogleConnection' => $userGoogleConnection,
            'userGoogleConnectionStatus' => $userGoogleConnectionStatus
        ]);
    }

    public function fetchUserTransactions(Request $request)
    {
        $userHandler = new UserHandler();
        return $userHandler->getUserTransactions($request);
    }

    public function deleteTransaction(Request $request)
    {
        $userHandler = new UserHandler();
        return $userHandler->deleteTransaction($request);
    }

    public function viewDetails(Request $request)
    {
        $userHandler = new UserHandler();
        return $userHandler->fetchTransactionDetails($request);
    }

    public function toggleGoogleConnection(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->google_calendar_connection_status = $request->userGoogleConnection;
        if (!$user->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to update google calendar connection status'
            ]);
        }
        return response()->json([
            'error' => false,
            'message' => 'Google calendar connection status updated'
        ]);
    }
}
