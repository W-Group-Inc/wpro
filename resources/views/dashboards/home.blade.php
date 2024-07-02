@extends('layouts.header')
@section('css_header')
<link rel="stylesheet" href="{{asset('./body_css/vendors/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome {{auth()->user()->employee->first_name}},</h3>
                </div>
              </div>
            </div>
        </div>
          <div class="row">
              <div class="col-md-4 transparent">
                <div class="row">
                    <div class="col-md-12 mb-4 transparent">
                        <div class="card">
                          <div class="card-body">
                            <h3 class="card-title">{{date('M d, Y')}} </h3>
                            <div class="media">
                                <i class="ti-time icon-md text-info d-flex align-self-center mr-3"></i>
                                <div class="media-body">
                                  <p class="card-text">Time In : 
                                    @if($attendance_now != null){{date('h:i A',strtotime($attendance_now->time_in))}} <br>
                                    @php
                                          $employee_schedule = employeeSchedule($schedules,$attendance_now->time_in,$schedules[0]->schedule_id);
                                          $estimated_out = "";
                                          if($employee_schedule != null)
                                          {
                                            if(date('h:i A',strtotime($attendance_now->time_in)) < date('h:i A',strtotime($employee_schedule['time_in_from'])))
                                            {
                                                $estimated_out = date('h:i A',strtotime($employee_schedule['time_out_from']));
                                            }
                                            else
                                            {
                                                $hours = intval($employee_schedule['working_hours']);
                                                $minutes = ($employee_schedule['working_hours']-$hours)*60;
                                                $estimated_out = date('h:i A', strtotime("+".$hours." hours",strtotime($attendance_now->time_in)));
                                                $estimated_out = date('h:i A', strtotime("+".$minutes." minutes",strtotime($estimated_out)));
                                            }
                                            if(date('h:i A',strtotime($attendance_now->time_in)) > date('h:i A',strtotime($employee_schedule['time_in_to'])))
                                            {
                                                $estimated_out = date('h:i A',strtotime($employee_schedule['time_out_to']));
                                            }

                                          }
                                          else {
                                            $estimated_out = "No Schedule";
                                          }
                                          
                                        @endphp
                                    @if($attendance_now->time_out == null )
                                        
                                        Estimated Out : {{$estimated_out}} 
                                    @else
                                    Time Out : {{date('h:i A',strtotime($attendance_now->time_out))}} <br>
                                    Estimated Out : {{$estimated_out}} 
                                    @endif
                                  @else NO TIME IN 
                                  @endif</p>
                                  {{-- <button type="button" class="btn btn-outline-danger btn-fw btn-sm">Time Out</button> --}}
                                </div>
                              </div>
                          </div>
                        </div>
                        @if(count(auth()->user()->subbordinates) > 0)
                        <div class="card mt-2">
                          <div class="card-body">
                            <p class="card-title ">Subordinates </p>
                              <div class="table-responsive" >
                                <table class="table table-hover table-bordered tablewithSearchonly" >
                                  <thead>
                                    <tr>
                                      <th>Name</th>
                                      <th>In</th>
                                      <th>Out</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      
                                    @foreach(auth()->user()->subbordinates as $emp)
                                    <tr>
                                      <td>{{$emp->first_name}} {{$emp->last_name}} </td>
                                      @php
                                          // dd($attendance_employees);
                                          $time_in = $attendance_employees->where('employee_code',$emp->employee_number)->where('time_in','!=',null)->first();
                                          $leave_with_pay = $emp ? $emp->approved_leaves_with_pay->where('date_from', date('Y-m-d'))->first() : null;
                                      @endphp
                                      <td>
                                        @if($leave_with_pay)
                                            Leave-With-Pay
                                        @elseif($time_in && $time_in->time_in)
                                            {{ date('h:i A', strtotime($time_in->time_in)) }}
                                        @else
                                            Absent
                                        @endif
                                      </td>
                                      <td>
                                        @if($time_in)
                                            @if($time_in->time_out)
                                                {{ date('h:i a', strtotime($time_in->time_out)) }}
                                            @else
                                                Absent
                                            @endif
                                        @else
                                            Absent
                                        @endif
                                    </td>                                    
                                    </tr>
                                    @endforeach
                    
                                  </tbody>
                              </table>
                              </div>
                          </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-title mb-0">(<small><i>{{date('M 01')}} - {{date('M t')}}</i></small>)</p>
                        <div class="table-responsive">
                          <table class="table table-striped table-borderless">
                            <thead>
                              <tr>
                                <th>Holiday</th>
                                <th>Date</th>
                              </tr>  
                            </thead>
                            <tbody>
                              @foreach($holidays as $holiday)
                              <tr>
                                <td>{{$holiday->holiday_name}}</td>
                                <td class="font-weight-medium"><div class="badge badge-success">{{date('M d',strtotime($holiday->holiday_date))}}</div></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>                             
              <div class="col-md-2">
             
              </div>
              <div class="col-md-3">
              <div class='row'>
                <div class="col-md-12">
                  <div class="card ">
                    <div class="card-body " >
                      <p class="card-title">Birthday Celebrants</p>
                      <ul class="icon-data-list w-100"  style="overflow-y: scroll; height:300px;">
                        @foreach($employee_birthday_celebrants as $celebrant)
                        <li>
                          <div class="d-flex">
                            <img src="{{URL::asset($celebrant->avatar)}}"  onerror="this.src='{{URL::asset('/images/no_image.png')}}';" alt="user">
                            <div>
                              <p class="text-info mb-1"><small>{{$celebrant->first_name}} {{$celebrant->last_name}} - ({{$celebrant->company->company_code}})</small></p>
                              <small>{{date('M d',strtotime($celebrant->birth_date))}}</small>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @if (checkUserPrivilege('allow_prob',auth()->user()->id) == 'yes')
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card mt-2">
                        <div class="card-body">
                          <div class="card-title">Probationary Employee</div>
                          <ul class="icon-data-list w-100"  style="overflow-y: scroll; height:300px;">
                            @foreach($probationary_employee as $prob_emp)
                            <li>
                              <div class="d-flex">
                                <img src="{{URL::asset($prob_emp->avatar)}}"  onerror="this.src='{{URL::asset('/images/no_image.png')}}';" alt="user">
                                <div>
                                  <p class="text-info mb-1"><small>{{$prob_emp->first_name}} {{$prob_emp->last_name}}</small></p>
                                  <p class="mb-0"><small>{{$prob_emp->company->company_name}}</small></p>
                                  <p class="mb-0"><small>{{$prob_emp->position}}</small></p>
                                  <p class="mb-0"><small>{{date('M d, Y',strtotime($prob_emp->original_date_hired))}}</small></p>
                                  <p class="mb-0"><small>
                                    @php
                                      $date_from = new DateTime($prob_emp->original_date_hired);
                                      $date_diff = $date_from->diff(new DateTime(date('Y-m-d')));
                                      $y_s = $date_diff->format('%y') > 1 ? 's' : '';
                                      $m_s = $date_diff->format('%m') > 1 ? 's' : '';
                                      $d_s = $date_diff->format('%d') > 1 ? 's' : '';
                                    @endphp
                                    {{$date_diff->format('%y Year'.$y_s.' %m month'.$m_s.' %d day'.$d_s.'')}}</small>
                                  </p>
                                  <button type="button" id="edit{{ $prob_emp->id }}" class="btn btn-info btn-rounded btn-icon"
                                    data-target="#edit_prob{{ $prob_emp->id }}" data-toggle="modal" title='Edit'>
                                    <i class="ti-pencil-alt"></i>
                                  </button>
                                </div>
                              </div>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                  </div>
                </div>
              @endif
              </div>
            <div class="col-md-3 ">
              <div class="row">
                <div class="col-md-12">
                  <div class="card" >
                    <div class="card-body">
                      <div class="card-title">
                        Employee Anniversaries
                      </div>
                      <ul class="icon-data-list w-100" style="overflow-y: scroll; height:300px;" >
                        @foreach($employee_anniversaries->sortBy('original_date_hired') as $emp)
                        @php
                          $original_date_hired = new DateTime($emp->original_date_hired);
                          $current_date = new DateTime();
                          $current_anniversary = new DateTime($current_date->format('Y') . '-' . $original_date_hired->format('m-d'));
                          $s = $current_date->diff($original_date_hired)->format('%y') > 1 ? 's' : '';
                          
                          if ($current_anniversary >= $current_date) {
                            $anniv_year = $current_date->diff($original_date_hired)->y + 1;
                          }
                          else {
                            $anniv_year = $current_date->diff($original_date_hired)->y;
                          }
                          
                        @endphp
                        <li>
                          <div class="d-flex">
                            <img src="{{URL::asset($emp->avatar)}}"  onerror="this.src='{{URL::asset('/images/no_image.png')}}';" alt="user">
                            <div>
                              <p class="text-info mb-1"><small>{{$emp->first_name}} {{$emp->last_name}}</small> <i>(<small class='text-danger'>{{$anniv_year.' year'.$s.' of service'}}</small>)</i></p>
                              <p class="mb-0"><small>{{$emp->company->company_code}}</small> - <small>{{$emp->department->name}}</small></p>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class='row'>
                <div class="col-md-12">
                  <div class="card mt-2">
                    <div class="card-body " >
                      <p class="card-title">Welcome new Hires</p>
                      <ul class="icon-data-list w-100"  style="overflow-y: scroll; height:300px;">
                        @foreach($employees_new_hire as $employee)
                        <li>
                          <div class="d-flex">
                            <img src="{{URL::asset($employee->avatar)}}"  onerror="this.src='{{URL::asset('/images/no_image.png')}}';" alt="user">
                            <div>
                              <p class="text-info mb-1"><small>{{$employee->first_name}} {{$employee->last_name}}</small> <i>(<small>{{date('M. d',strtotime($employee->original_date_hired))}}</small>)</i> - <small>{{$employee->company->company_code}}</small></p>
                          
                              <p class="mb-0"><small>{{$employee->position}}</small> - <small>{{$employee->department->name}}</small></p>
                             
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>    
          <div class='row'>
          </div>
    </div>
</div>
<div class="modal fade" id="event_data" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Description : <span id='modalBody'>
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('footer')

<script src="{{asset('./body_css/js/tooltips.js')}}"></script>
<script src="{{asset('./body_css/js/popover.js')}}"></script>
<script src="{{asset('./body_css/vendors/moment/moment.min.js')}}"></script>

@foreach ($probationary_employee as $prob_emp)
@include('dashboards_modal.edit_prob')
@endforeach
@endsection
