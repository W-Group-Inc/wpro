@extends('layouts.header')
@section('css_header')
<link rel="stylesheet" href="{{asset('./body_css/vendors/fullcalendar/fullcalendar.min.css')}}">
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Timekeeping Dashboard</h3>  
                        <form method='get' onsubmit='show();' enctype="multipart/form-data">
                            <div class="row">
                                <div class='col-md-2'>
                                    <div class="form-group">
                                        <label class="text-right">From</label>
                                        <input type="date" value='{{$from}}' class="form-control form-control-sm" name="from"
                                            max='{{ date('Y-m-d') }}' onchange='get_min(this.value);' required />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="form-group">
                                        <label class="text-right">To</label>
                                        <input type="date" value='{{$to}}' class="form-control form-control-sm" id='to' name="to"
                                            max='{{ date('Y-m-d') }}' required />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <button type="submit" class="form-control form-control-sm btn btn-primary mb-2 btn-sm">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Leaves</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Details</th>
                                  <th>Approver</th>
                                </tr>
                              </thead>
                              <tbody> 
                                @foreach ($leaves as $item)
                                    <tr>
                                        <td>
                                            <strong>{{$item->user->name}}</strong> <br>
                                            <small>User ID : {{$item->user->id}}</small> <br>
                                            <small>{{$item->user->employee->company->company_name}}</small>
                                        
                                        </td>
                                        <td>
                                            Date From: {{date('M d, Y', strtotime($item->date_from))}} <br>
                                            Date To:  {{date('M d, Y', strtotime($item->date_to))}} <br>
                                            @if ($item->status == 'Pending')
                                                <label class="badge badge-warning">{{ $item->status }}</label>
                                            @elseif($item->status == 'Approved')
                                                <label class="badge badge-success">{{ $item->status }}</label>
                                            @elseif($item->status == 'Rejected' || $item->status == 'Cancelled')
                                                <label class="badge badge-danger">{{ $item->status }}</label>
                                            @endif  
                                        </td>
                                        <td id="tdStatus{{ $item->id }}">
                                            @if(count($item->approver) > 0)
                                                @foreach($item->approver as $approver)
                                                    @if($item->level >= $approver->level)
                                                    @if ($item->level == 0 && $item->status == 'Declined')
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                    @else
                                                        {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                                    @endif
                                                    @else
                                                    @if ($item->status == 'Declined')
                                                        {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                    @else
                                                        {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                                    @endif
                                                    @endif<br>
                                                @endforeach
                                            @else
                                            <label class="badge badge-danger mt-1">No Approver</label>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach               
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Official Business</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Details</th>
                                  <th>Approver</th>
                                </tr>
                              </thead>
                              <tbody> 
                                @foreach ($obs as $item)
                                <tr>
                                    <td>
                                        <strong>{{$item->user->name}}</strong> <br>
                                        <small>User ID : {{$item->user->id}}</small> <br>
                                        <small>{{$item->user->employee->company->company_name}}</small>
                                    
                                    </td>
                                    <td>
                                        Date: {{date('M d, Y', strtotime($item->applied_date))}} <br>
                                        Time:  {{ date('H:i', strtotime($item->date_from)) }} - {{ date('H:i', strtotime($item->date_to)) }}<br>
                                        @if ($item->status == 'Pending')
                                            <label class="badge badge-warning">{{ $item->status }}</label>
                                        @elseif($item->status == 'Approved')
                                            <label class="badge badge-success">{{ $item->status }}</label>
                                        @elseif($item->status == 'Rejected' || $item->status == 'Cancelled')
                                            <label class="badge badge-danger">{{ $item->status }}</label>
                                        @endif  
                                    </td>
                                    <td id="tdStatus{{ $item->id }}">
                                        @if(count($item->approver) > 0)
                                            @foreach($item->approver as $approver)
                                                @if($item->level >= $approver->level)
                                                @if ($item->level == 0 && $item->status == 'Declined')
                                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                                @endif
                                                @else
                                                @if ($item->status == 'Declined')
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                                @endif
                                                @endif<br>
                                            @endforeach
                                        @else
                                        <label class="badge badge-danger mt-1">No Approver</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach             
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Work From Home</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Details</th>
                                  <th>Approver</th>
                                </tr>
                              </thead>
                              <tbody> 
                                @foreach ($wfhs as $item)
                                <tr>
                                    <td>
                                        <strong>{{$item->user->name}}</strong> <br>
                                        <small>User ID : {{$item->user->id}}</small> <br>
                                        <small>{{$item->user->employee->company->company_name}}</small>
                                    
                                    </td>
                                    <td>
                                        Date: {{date('M d, Y', strtotime($item->applied_date))}} <br>
                                        Time:  {{ date('H:i', strtotime($item->date_from)) }} - {{ date('H:i', strtotime($item->date_to)) }}<br>
                                        @if ($item->status == 'Pending')
                                            <label class="badge badge-warning">{{ $item->status }}</label>
                                        @elseif($item->status == 'Approved')
                                            <label class="badge badge-success">{{ $item->status }}</label>
                                        @elseif($item->status == 'Rejected' || $item->status == 'Cancelled')
                                            <label class="badge badge-danger">{{ $item->status }}</label>
                                        @endif  
                                    </td>
                                    <td id="tdStatus{{ $item->id }}">
                                        @if(count($item->approver) > 0)
                                            @foreach($item->approver as $approver)
                                                @if($item->level >= $approver->level)
                                                @if ($item->level == 0 && $item->status == 'Declined')
                                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                                @endif
                                                @else
                                                @if ($item->status == 'Declined')
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                                @endif
                                                @endif<br>
                                            @endforeach
                                        @else
                                        <label class="badge badge-danger mt-1">No Approver</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach                    
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Overtime</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Details</th>
                                  <th>Approver</th>
                                </tr>
                              </thead>
                              <tbody> 
                                @foreach ($overtimes as $item)
                                <tr>
                                    <td>
                                        <strong>{{$item->user->name}}</strong> <br>
                                        <small>User ID : {{$item->user->id}}</small> <br>
                                        <small>{{$item->user->employee->company->company_name}}</small>
                                    
                                    </td>
                                    <td>
                                        Date: {{date('M d, Y', strtotime($item->ot_date))}} <br>
                                        Time:  {{ date('H:i', strtotime($item->start_time)) }} - {{ date('H:i', strtotime($item->end_time)) }}<br>
                                        @if ($item->status == 'Pending')
                                            <label class="badge badge-warning">{{ $item->status }}</label>
                                        @elseif($item->status == 'Approved')
                                            <label class="badge badge-success">{{ $item->status }}</label>
                                        @elseif($item->status == 'Rejected' || $item->status == 'Cancelled')
                                            <label class="badge badge-danger">{{ $item->status }}</label>
                                        @endif  
                                    </td>
                                    <td id="tdStatus{{ $item->id }}">
                                        @if(count($item->approver) > 0)
                                            @foreach($item->approver as $approver)
                                                @if($item->level >= $approver->level)
                                                @if ($item->level == 0 && $item->status == 'Declined')
                                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                                @endif
                                                @else
                                                @if ($item->status == 'Declined')
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                                @endif
                                                @endif<br>
                                            @endforeach
                                        @else
                                        <label class="badge badge-danger mt-1">No Approver</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach                      
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">DTR Approvals</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Details</th>
                                  <th>Approver</th>
                                </tr>
                              </thead>
                              <tbody> 
                                @foreach ($dtrs as $item)
                                <tr>
                                    <td>
                                        <strong>{{$item->user->name}}</strong> <br>
                                        <small>User ID : {{$item->user->id}}</small> <br>
                                        <small>{{$item->user->employee->company->company_name}}</small>
                                    
                                    </td>
                                    <td>
                                        Date: {{date('M d, Y', strtotime($item->dtr_date))}} <br>
                                        Time:  {{ date('H:i', strtotime($item->time_in)) }} - {{ date('H:i', strtotime($item->time_out)) }}<br>
                                        Correction:  {{ $item->correction }}<br>
                                        @if ($item->status == 'Pending')
                                            <label class="badge badge-warning">{{ $item->status }}</label>
                                        @elseif($item->status == 'Approved')
                                            <label class="badge badge-success">{{ $item->status }}</label>
                                        @elseif($item->status == 'Rejected' || $item->status == 'Cancelled')
                                            <label class="badge badge-danger">{{ $item->status }}</label>
                                        @endif  
                                    </td>
                                    <td id="tdStatus{{ $item->id }}">
                                        @if(count($item->approver) > 0)
                                            @foreach($item->approver as $approver)
                                                @if($item->level >= $approver->level)
                                                @if ($item->level == 0 && $item->status == 'Declined')
                                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                                @endif
                                                @else
                                                @if ($item->status == 'Declined')
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                                @else
                                                    {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                                @endif
                                                @endif<br>
                                            @endforeach
                                        @else
                                        <label class="badge badge-danger mt-1">No Approver</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach                     
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Used Leaves</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Count</th>
                                </tr>
                              </thead>
                              <tbody> 
                                                    
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Earned Leaves</h3>  
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered tablewithSearch">
                              <thead>
                                <tr>
                                  <th>Employee</th>
                                  <th>Count</th>
                                </tr>
                              </thead>
                              <tbody> 
                                                    
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4  stretch-card transparent">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Employee Attendances</h3>  
                        <table class="table table-hover table-bordered tablewithSearch">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Lates</th>
                                <th>Undertime</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody> 
                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection