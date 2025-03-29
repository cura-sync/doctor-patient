<?php

namespace Modules\Bills\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Bill Analysis',
            'subtitle' => 'Upload your medical bill and get a detailed analysis of expenses, categorization, and potential savings.'
        ];
        return view('bills::index', compact('pageHeader'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bills::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('bills::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('bills::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
