<?php

namespace App\Http\Controllers;

use App\Models\DPContants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function __construct()
    {
        $isUserLoggedIn = Auth::check();
        view()->share('isUserLoggedIn', $isUserLoggedIn);
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
