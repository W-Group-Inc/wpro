<?php

namespace App\Http\Controllers;

use App\AttendanceDetailedReport;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfectAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $header = 'perfect_attendance';
        $company_id = $request->company;
        $month = $request->month;

        $allowed_companies = getUserAllowedCompanies(auth()->user()->id);
        $companies = Company::whereIn('id', $allowed_companies)->get();

        $attendances = AttendanceDetailedReport::select('company_id', 'employee_no', 'name')
            ->whereHas('employee', function($query){
                $query->where('classification', 2); // Regular Employee Only
            })
            ->whereYear('log_date', date('Y', strtotime($month)))
            ->whereMonth('log_date', date('m', strtotime($month)))
            ->where('company_id', $company_id)
            ->groupBy('company_id', 'employee_no', 'name')
            ->having(DB::raw('SUM(undertime_min)'), '=', 0.00)
            ->having(DB::raw('SUM(late_min)'), '=', 0.00)
            ->having(DB::raw('SUM(abs)'), '=', 0.00)
            ->get();

        return view('perfect_attendance.perfect_attendance', compact('header','companies','company_id','month','attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
