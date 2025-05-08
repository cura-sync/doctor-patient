<?php

namespace App\Http\Controllers;

use App\Models\GoogleToken;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public $isUserLoggedIn = false;

    public $isUserGoogleCalendarConnected = false;

    public function __construct()
    {
        $this->isUserLoggedIn = Auth::check();
        $this->isUserGoogleCalendarConnected = GoogleToken::isUserGoogleCalendarConnected(Auth::user()->id);

        view()->share([
            'isUserLoggedIn' => $this->isUserLoggedIn, 
            'isUserGoogleCalendarConnected' => $this->isUserGoogleCalendarConnected
        ]);
    }

    /**
     * Filter data by date range
     */
    public function filterByDateRange($gridData, $fromDate, $toDate)
    {
        return array_filter($gridData, function($item) use ($fromDate, $toDate) {
            $itemDate = \DateTime::createFromFormat('d-m-Y', $item['transaction_date'])->getTimestamp();
            
            if (!$itemDate) {
                return false;
            }
            
            if ($fromDate && $itemDate < $fromDate) {
                return false;
            }
            if ($toDate && $itemDate > $toDate) {
                return false;
            }
            return true;
        });
    }
}
