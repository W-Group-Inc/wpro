<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use App\Handbook;
use App\Employee;
use App\Announcement;
use App\Classification;
use App\ScheduleData;
use App\Holiday;
use App\Document;
use App\EmployeeLeave;
use App\EmployeeOvertime;
use App\EmployeeWfh;
use App\EmployeeOb;
use App\EmployeeDtr;
use App\EmployeeLeaveCredit;
use App\Leave;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $documents = Document::get();
        $schedules = [];
        $attendance_controller = new AttendanceController;
        $current_day = date('d');
        $employee_birthday_celebrants = Employee::whereMonth('birth_date', date('m'))
        ->where(function($query) {
            $query->where('status', 'Active')
                  ->orWhere('status', 'HBU');
        })
        ->orderByRaw("DAY(birth_date) >= ? DESC, DAY(birth_date)", [$current_day])
        ->get();
        
        $employees_new_hire = Employee::where('original_date_hired',">=",date("Y-m-d", strtotime("-1 months")))->orderBy('original_date_hired','desc')->get();
        $sevendays = date('Y-m-d',strtotime("-7 days"));
        if(auth()->user()->employee){
            if(auth()->user()->employee->employee_number){
                $attendance_now = $attendance_controller->get_attendance_now(auth()->user()->employee->employee_number);
                $attendances = $attendance_controller->get_attendances($sevendays,date('Y-m-d',strtotime("-1 day")),auth()->user()->employee->employee_number);
            }else{
                $attendance_now = null;
                $attendances = null;
            }

            $schedules = ScheduleData::where('schedule_id',auth()->user()->employee->schedule_id)->get();
        }else{
            $attendance_now = null;
            $attendances = null;
        }
        // dd($attendances->unique('time_in','Y-m-d'));
        $date_ranges = $attendance_controller->dateRange($sevendays,date('Y-m-d',strtotime("-1 day")));
        $handbook = Handbook::orderBy('id','desc')->first();
        $employees_under = auth()->user()->subbordinates;
        // dd(auth()->user()->employee);
        $attendance_employees = $attendance_controller->get_attendances_employees(date('Y-m-d'),date('Y-m-d'),$employees_under->pluck('employee_number')->toArray());
        $attendance_employees->load('employee.approved_leaves_with_pay');
        // dd($attendance_employees);
        $announcements = Announcement::with('user')->where('expired',null)
        ->orWhere('expired',">=",date('Y-m-d'))->get();
        

        $holidays = Holiday::where('status','Permanent')
        ->whereMonth('holiday_date',date('m'))
        ->orWhere(function ($query)
        {
            $query->where('status',null)->whereYear('holiday_date', '=', date('Y'))->whereMonth('holiday_date',date('m'));
        })
        ->orderBy('holiday_date','asc')->get();

        $employee_anniversaries = Employee::with('department', 'company') ->where(function($query) {
            $query->where('status', 'Active');
        })
          ->whereYear('original_date_hired','!=',date('Y'))
          ->whereMonth('original_date_hired', date('m'))
          ->get();

        $probationary_employee = Employee::with('department', 'company', 'user_info', 'classification_info')
            ->where('classification', "1")
            ->where(function($query) {
                $query->where('status', 'Active')
                      ->orWhere('status', 'HBU');
            })
            ->orderBy('original_date_hired')
            ->get();

        $classifications = Classification::get();
        $leaveTypes = Leave::all();
        return view('dashboards.home',
        array(
            'header' => '',
            'date_ranges' => $date_ranges,
            'handbook' => $handbook,
            'attendance_now' => $attendance_now,
            'attendances' => $attendances,
            'schedules' => $schedules,
            'announcements' => $announcements ,
            'attendance_employees' => $attendance_employees ,
            'holidays' => $holidays ,
            'employee_birthday_celebrants' => $employee_birthday_celebrants ,
            'employees_new_hire' => $employees_new_hire ,
            'employee_anniversaries' => $employee_anniversaries,
            'probationary_employee' => $probationary_employee,
            'classifications' =>$classifications,
            'leaveTypes' => $leaveTypes,
            'documents' => $documents,
        ));
    }

    public function managerDashboard()
    {

        
        $handbook = Handbook::orderBy('id','desc')->first();
        return view('dashboards.dashboard_manager',
        array(
            'header' => 'dashboard-manager',
            'handbook' => $handbook,
        ));
    }

    public function pending_leave_count($approver_id){

        $today = date('Y-m-d');
        $from_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $today) ) ));
        $to_date = date('Y-m-d');
    
        return EmployeeLeave::select('user_id')->with('approver.approver_info')
                                    ->whereHas('approver',function($q) use($approver_id) {
                                        $q->where('approver_id',$approver_id);
                                    })
                                    ->where('status','Pending')
                                    // ->whereDate('created_at','>=',$from_date)
                                    // ->whereDate('created_at','<=',$to_date)
                                    ->count();
    }
    public function pending_overtime_count($approver_id){
    
        $today = date('Y-m-d');
        $from_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $today) ) ));
        $to_date = date('Y-m-d');
    
        return EmployeeOvertime::select('user_id')->whereHas('approver',function($q) use($approver_id) {
                                        $q->where('approver_id',$approver_id);
                                    })
                                    ->where('status','Pending')
                                    // ->whereDate('created_at','>=',$from_date)
                                    // ->whereDate('created_at','<=',$to_date)
                                    ->count();
    }
    public function edit_prob(Request $request, $id) {
        $employee = Employee::findOrFail($id);
    
        $classification = $request->input('classification');
    
        if ($classification) {
            if ($classification == 'for_regularization') {
                $employee->classification = '2';
                $employee->date_regularized = $request->input('date_regular');

                // $leave_credit = EmployeeLeaveCredit::where('user_id',$id)
                //                             ->where('leave_type',$request->leave_type)
                //                             ->first();
                // if($leave_credit){
                //     $leave_credit->count = $request->count;
                //     $leave_credit->save();
                // }else{
                //     $leave_credit = new EmployeeLeaveCredit;
                //     $leave_credit->leave_type = $request->leave_type;
                //     $leave_credit->user_id = $id;
                //     $leave_credit->count = $request->count;
                //     $leave_credit->save();
                // }

                $leave_credit_sick = EmployeeLeaveCredit::where('user_id', $id)
                                                ->where('leave_type', '2')
                                                ->first();
                if ($leave_credit_sick) {
                    $leave_credit_sick->count = $request->input('sl_count');
                    $leave_credit_sick->save();
                } else {
                    $leave_credit_sick = new EmployeeLeaveCredit;
                    $leave_credit_sick->leave_type = '2';
                    $leave_credit_sick->user_id = $id;
                    $leave_credit_sick->count = $request->input('sl_count');
                    $leave_credit_sick->save();
                }

                $leave_credit_vacation = EmployeeLeaveCredit::where('user_id', $id)
                                                    ->where('leave_type', '1')
                                                    ->first();
                if ($leave_credit_vacation) {
                    $leave_credit_vacation->count = $request->input('vl_count');
                    $leave_credit_vacation->save();
                } else {
                    $leave_credit_vacation = new EmployeeLeaveCredit;
                    $leave_credit_vacation->leave_type = '1';
                    $leave_credit_vacation->user_id = $id;
                    $leave_credit_vacation->count = $request->input('vl_count');
                    $leave_credit_vacation->save();
                }

            } elseif ($classification == 'for_resignation') {
                $employee->status = 'Inactive';
                $employee->date_resigned = $request->input('date_resigned');
            }
    
            $employee->save();
            Alert::success('Successfully Updated')->persistent('Dismiss');
            return back();
        } else {
            return back()->withErrors(['classification' => 'Classification is required.']);


        }
    }
    
    public function pending_wfh_count($approver_id){
    
        $today = date('Y-m-d');
        $from_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $today) ) ));
        $to_date = date('Y-m-d');
    
        return EmployeeWfh::select('user_id')->whereHas('approver',function($q) use($approver_id) {
                                        $q->where('approver_id',$approver_id);
                                    })
                                    ->where('status','Pending')
                                    // ->whereDate('created_at','>=',$from_date)
                                    // ->whereDate('created_at','<=',$to_date)
                                    ->count();
    }
    
    public function pending_ob_count($approver_id){
    
        $today = date('Y-m-d');
        $from_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $today) ) ));
        $to_date = date('Y-m-d');
    
        return EmployeeOb::select('user_id')->whereHas('approver',function($q) use($approver_id) {
                                        $q->where('approver_id',$approver_id);
                                    })
                                    ->where('status','Pending')
                                    // ->whereDate('created_at','>=',$from_date)
                                    // ->whereDate('created_at','<=',$to_date)
                                    ->count();
    }
    
    public function pending_dtr_count($approver_id){
    
        $today = date('Y-m-d');
        $from_date = date('Y-m-d',(strtotime ( '-1 month' , strtotime ( $today) ) ));
        $to_date = date('Y-m-d');
    
        return EmployeeDtr::select('user_id')->whereHas('approver',function($q) use($approver_id) {
                                        $q->where('approver_id',$approver_id);
                                    })
                                    ->where('status','Pending')
                                    // ->whereDate('created_at','>=',$from_date)
                                    // ->whereDate('created_at','<=',$to_date)
                                    ->count();
    }
}
