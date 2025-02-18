@extends('layouts.header')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class='row'>
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Leave Type</th>
                        <th>Total</th>
                        <th>Used</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $is_allowed_to_file_vl = false;
                          $is_allowed_to_file_sl = false;
                          $is_allowed_to_file_sil = false;

                          $is_allowed_to_file_ml = false;
                          $is_allowed_to_file_pl = false;
                          $is_allowed_to_file_spl = false;
                          $is_allowed_to_file_splw = false;
                          $is_allowed_to_file_splvv = false;
                          $is_allowed_to_file_el = false;
                          $is_allowed_to_file_bl = false;

                          $vl_balance = 0;
                          $sl_balance = 0;
                          $pl_balance = 0;
                          $ml_balance = 0;
                          $spl_balance = 0;
                          $splw_balance = 0;
                          $splvv_balance = 0;
                          $el_balance = 0;
                          $bl_balance = 0;
                      @endphp

                      @if(count($leave_balances) > 0)
                        @foreach($leave_balances as $leave)
                        <tr>
                          <td>{{$leave->leave->leave_type}}</td>
                          <td>
                            @if ($leave->leave->id == '1')
                              @php
                                $date_from = new DateTime($employee_status->original_date_hired);
                                $date_diff = $date_from->diff(new DateTime(date('Y-m-d')));
                                $total_months = (($date_diff->y) * 12) + ($date_diff->m);

                                // $vl_beginning_balance = 0;
                                // if($total_months > 11){ //
                                  
                                //   $original_date_hired_m_d = date('m-d',strtotime($employee_status->original_date_hired));
                                //   $original_date_hired_m = date('m',strtotime($employee_status->original_date_hired));
                                //   $today = date('Y-m-d');
                                //   $last_year = date('Y', strtotime('-1 year', strtotime($today)) );
                                //   $original_date_hired = $last_year . '-' . $original_date_hired_m_d;

                                //   if($last_year == 2022){
                                //       $vl_beginning_balance = $leave->count;
                                //   }
                                // }
                                // else{
                                //   $vl_beginning_balance = $leave->count;
                                // }

                        
                                    $vl_beginning_balance = $leave->count;
                                
                                
                                $total_vl = $vl_beginning_balance + $earned_vl;
                              @endphp
                              {{ ($total_vl) }}
                            @elseif ($leave->leave->id == '2')
                              @php
                                $date_from = new DateTime($employee_status->original_date_hired);
                                $date_diff = $date_from->diff(new DateTime(date('Y-m-d')));
                                $total_months = (($date_diff->y) * 12) + ($date_diff->m);

                                $sl_beginning_balance = 0;
                                // if($total_months > 11){ //
                                  
                                //   $original_date_hired_m_d = date('m-d',strtotime($employee_status->original_date_hired));
                                //   $original_date_hired_m = date('m',strtotime($employee_status->original_date_hired));
                                //   $today = date('Y-m-d');
                                //   $last_year = date('Y', strtotime('-1 year', strtotime($today)) );
                                //   $original_date_hired = $last_year . '-' . $original_date_hired_m_d;

                                //   if($last_year == 2022){
                                //       $sl_beginning_balance = $leave->count;
                                //   }
                                // }
                                // else{
                                //   $sl_beginning_balance = $leave->count;
                                // }

                                $sl_beginning_balance = $leave->count;

                                
                                $total_sl = $sl_beginning_balance + $earned_sl;
                              @endphp
                                {{ ($total_sl) }}
                            @elseif ($leave->leave->id == '10')
                                {{$earned_sil + $leave->count}}
                            @elseif ($leave->leave->id == '3')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '4')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '5')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '7')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '8')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '6')
                                {{$leave->count}}
                            @elseif ($leave->leave->id == '11')
                                {{$leave->count}}
                            @endif
                          </td>
                          <td>
                            @if ($leave->leave->id == '1')
                                {{$used_vl}}
                            @elseif ($leave->leave->id == '2')
                                {{$used_sl}}
                            @elseif ($leave->leave->id == '10')
                                {{$used_sil}}
                            @elseif ($leave->leave->id == '3')
                                {{$used_ml}}
                            @elseif ($leave->leave->id == '4')
                                {{$used_pl}}
                            @elseif ($leave->leave->id == '5')
                                {{$used_spl}}
                            @elseif ($leave->leave->id == '7')
                                {{$used_splw}}
                            @elseif ($leave->leave->id == '8')
                                {{$used_splvv}}
                            @elseif ($leave->leave->id == '6')
                                {{$used_el}}
                            @elseif ($leave->leave->id == '11')
                                {{$used_bl}}
                            @endif
                          </td>
                          <td>
                            @if ($leave->leave->id == '1')
                                @php
                                  $date_from = new DateTime($employee_status->original_date_hired);
                                  $date_diff = $date_from->diff(new DateTime(date('Y-m-d')));
                                  $total_months = (($date_diff->y) * 12) + ($date_diff->m);

                                  // $vl_beginning_balance = 0;
                                  // if($total_months > 11){ //
                                    
                                  //   $original_date_hired_m_d = date('m-d',strtotime($employee_status->original_date_hired));
                                  //   $original_date_hired_m = date('m',strtotime($employee_status->original_date_hired));
                                  //   $today = date('Y-m-d');
                                  //   $last_year = date('Y', strtotime('-1 year', strtotime($today)) );
                                  //   $original_date_hired = $last_year . '-' . $original_date_hired_m_d;

                                  //   if($last_year == 2022){
                                  //       $vl_beginning_balance = $leave->count;
                                  //   }
                                  // }
                                  // else{
                                  //   $vl_beginning_balance = $leave->count;
                                  // }
                                  
                                      $vl_beginning_balance = $leave->count;
                                 
                                  $count_vl = ($vl_beginning_balance + $earned_vl) - $used_vl;
                                  if($count_vl > 0){
                                    if($total_months > 11){
                                        $is_allowed_to_file_vl = true;
                                    }else{
                                        $is_allowed_to_file_vl = false;
                                    }
                                  }else{
                                    $is_allowed_to_file_vl = false;
                                  }

                                  $vl_balance = $count_vl;
                                
                                    $vl_previous = $vl_balance - $earned_vl;
                                    if($vl_previous <= 0.00 || $vl_previous <= 0.000)
                                    {
                                        $vl_previous = 0;
                                    }
                                    // dd($vl_previous);
                                  $vl_balance_final = $vl_balance - $vl_previous;
                                //   dd($vl_balance_final);
                                @endphp
                                {{-- {{ $vl_balance }} --}}
                                @if($vl_previous == 0)
                                {{$vl_balance}}
                                @else
                                {{ $vl_balance_final }}
                                @endif
                            @elseif ($leave->leave->id == '2')
                                
                                @php
                                  $date_from = new DateTime($employee_status->original_date_hired);
                                  $date_diff = $date_from->diff(new DateTime(date('Y-m-d')));
                                  $total_months = (($date_diff->y) * 12) + ($date_diff->m);

                                  // $sl_beginning_balance = 0;
                                  // if($total_months > 11){ //
                                    
                                  //   $original_date_hired_m_d = date('m-d',strtotime($employee_status->original_date_hired));
                                  //   $original_date_hired_m = date('m',strtotime($employee_status->original_date_hired));
                                  //   $today = date('Y-m-d');
                                  //   $last_year = date('Y', strtotime('-1 year', strtotime($today)) );
                                  //   $original_date_hired = $last_year . '-' . $original_date_hired_m_d;

                                  //   if($last_year == 2022){
                                  //       $sl_beginning_balance = $leave->count;
                                  //   }
                                  // }
                                  // else{
                                  //   $sl_beginning_balance = $leave->count;
                                  // }

                                  // $sl_beginning_balance = 0;
                                  // $today  = date('Y-m-d');
                                  // $date_hired_md = date('m-d',strtotime($employee_status->original_date_hired));
                                  // $date_hired_m = date('m',strtotime($employee_status->original_date_hired));
                                  // $last_year = date('Y', strtotime('-1 year', strtotime($today)) );
                                  // $this_year = date('Y');

                                  // $date_hired_this_year = $this_year . '-'. $date_hired_md;

                                  // if($last_year == 2022 && $today < $date_hired_this_year){
                                      $sl_beginning_balance = $leave->count;
                                  // }

                                  // if($total_months < 11){
                                  //   $sl_beginning_balance = $leave->count;
                                  // }
                                  
                                  $count_sl = ($sl_beginning_balance + $earned_sl) - $used_sl;
                                  
                                  if($count_sl > 0){
                                    if($total_months > 11){
                                        $is_allowed_to_file_sl = true;
                                    }else{
                                        $is_allowed_to_file_sl = false;
                                    }
                                  }else{
                                    $is_allowed_to_file_sl = false;
                                  }

                                  $sl_balance = $count_sl;

                                $sl_balance_previous_year = $sl_balance - $earned_sl;
                                if ($sl_balance_previous_year <= 0.000 || $sl_balance_previous_year <= 0.00 )
                                {
                                    $sl_balance_previous_year = 0;
                                }
                                $sl_balance_final = $sl_balance - $sl_bank->sl_bank_balance;
                                @endphp
                                {{-- {{ $sl_balance}} --}}
                                {{ $sl_balance_final}}
                            @elseif ($leave->leave->id == '10')
                                {{($leave->count + $earned_sil) - $used_sil}}
                                @php
                                  $count_sil = ($leave->count + $earned_sil) - $used_sil;
                                  if($count_sil > 0){
                                    $is_allowed_to_file_sil = true;
                                  }else{
                                    $is_allowed_to_file_sil = false;
                                  }
                                @endphp
                            @elseif ($leave->leave->id == '3')
                                {{($leave->count) - $used_ml}}
                                @php
                                  $count_ml = ($leave->count) - $used_ml;
                                  if($count_ml > 0){
                                    $is_allowed_to_file_ml = true;
                                  }else{
                                    $is_allowed_to_file_ml = false;
                                  }

                                  $ml_balance = $count_ml;
                                @endphp
                            @elseif ($leave->leave->id == '4')
                                {{($leave->count) - $used_pl}}
                                @php
                                  $count_pl = ($leave->count) - $used_pl;
                                  if($count_pl > 0){
                                    $is_allowed_to_file_pl = true;
                                  }else{
                                    $is_allowed_to_file_pl = false;
                                  }

                                  $pl_balance = $count_pl;
                                @endphp
                            @elseif ($leave->leave->id == '5')
                                  {{($leave->count) - $used_spl}}
                                  @php
                                    $count_spl = ($leave->count) - $used_spl;
                                  if($count_spl > 0){
                                    $is_allowed_to_file_spl = true;
                                  }else{
                                    $is_allowed_to_file_spl = false;
                                  }
                                  $spl_balance = $count_spl;
                                @endphp
                            @elseif ($leave->leave->id == '7')
                                {{($leave->count) - $used_splw}}
                                @php
                                  $count_splw = ($leave->count) - $used_splw;
                                  if($count_splw > 0){
                                    $is_allowed_to_file_splw = true;
                                  }else{
                                    $is_allowed_to_file_splw = false;
                                  }

                                  $splw_balance = $count_splw;
                                @endphp
                            @elseif ($leave->leave->id == '9')
                                {{($leave->count) - $used_splvv}}
                                @php
                                  $count_splvv = ($leave->count) - $used_splvv;
                                  if($count_splvv > 0){
                                    $is_allowed_to_file_splvv = true;
                                  }else{
                                    $is_allowed_to_file_splvv = false;
                                  }
                                  $splvv_balance = $count_splvv;
                                @endphp
                            @elseif ($leave->leave->id == '6')
                                {{($leave->count) - $used_el}}
                                @php
                                  $count_el = ($leave->count) - $used_el;
                                  if($count_el > 0){
                                    $is_allowed_to_file_el = true;
                                  }else{
                                    $is_allowed_to_file_el = false;
                                  }
                                  $el_balance = $count_el;
                                @endphp
                            @elseif ($leave->leave->id == '11')
                                {{($leave->count) - $used_bl}}
                                @php
                                  $count_bl = ($leave->count) - $used_bl;
                                  if($count_bl > 0){
                                    $is_allowed_to_file_bl = true;
                                  }else{
                                    $is_allowed_to_file_bl = false;
                                  }
                                  $bl_balance = $count_bl;
                                @endphp
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      @else
                        <tr>
                          <td>VL</td>
                          <td>{{$earned_vl}}</td>
                          <td>{{$used_vl}}</td>
                          <td>{{$earned_vl}}</td>
                          @php
                            if(($earned_vl) >= 1){
                              $is_allowed_to_file_vl = true;
                            }
                          @endphp
                        </tr>
                        <tr>
                          <td>SL</td>
                          <td>{{$earned_sl}}</td>
                          <td>{{$used_sl}}</td>
                          <td>{{$earned_sl}}</td>
                          @php
                            if(($earned_sl) >= 1){
                              $is_allowed_to_file_sl = true;
                            }
                          @endphp
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class='col-lg-2'>
            <div class="card card-tale">
              <div class="card-body">
                <div class="media">
                
                  <div class="media-body">
                    <h4 class="mb-4">Pending</h4>
                    <h2 class="card-text">{{($employee_leaves_all->where('status','Pending'))->count()}}</h2>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class='col-lg-2'>
            <div class="card card-light-danger">
              <div class="card-body">
                <div class="media">
                
                  <div class="media-body">
                    <h4 class="mb-4">Declined/Cancelled</h4>
                    <h2 class="card-text">{{($employee_leaves_all->where('status','Cancelled'))->count() + ($employee_leaves_all->where('status','Declined'))->count()}}</h2>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class='col-lg-2'>
            <div class="card text-success">
              <div class="card-body">
                <div class="media">
                  <div class="media-body">
                    <h4 class="mb-4">Approved</h4>
                    <h2 class="card-text">{{($employee_leaves_all->where('status','Approved'))->count()}}</h2>
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Leave</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            VL from {{date('Y', strtotime('-1 year'))}}
                                        </td>
                                        <td>
                                            @php
                                                if(date('m') == '04')
                                                {
                                                    $vl_balance_previous = 0;
                                                }
                                                else
                                                {
                                                    $vl_balance_previous = $vl_balance - $earned_vl;
                                                    if($vl_balance_previous <= 0.00 || $vl_balance_previous <= 0.000)
                                                    {
                                                        $vl_balance_previous = 0;
                                                    }
                                                }
                                            @endphp

                                            {{$vl_balance_previous}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SL Bank</td>
                                        <td>{{$sl_bank->sl_bank_balance}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Leaves</h4>
                <p class="card-description">
                  @if($allowed_to_file)
                    <button type="button" class="btn btn-outline-success btn-icon-text" data-toggle="modal" data-target="#applyLeave">
                      <i class="ti-plus btn-icon-prepend"></i>                                                    
                      Apply Leave
                    </button>
                  @else
                    <span class="text-danger">You are not allowed to file a leave yet.</span>
                  @endif
                </p>

                <form method='get' onsubmit='show();' enctype="multipart/form-data">
                  <div class=row>
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
                        <input type="date" value='{{$to}}' class="form-control form-control-sm" id='to' name="to" required />
                      </div>
                    </div>
                    <div class='col-md-2 mr-2'>
                      <div class="form-group">
                        <label class="text-right">Status</label>
                        <select data-placeholder="Select Status" class="form-control form-control-sm required js-example-basic-single" style='width:100%;' name='status' required>
                          <option value="">-- Select Status --</option>
                          <option value="Approved" @if ('Approved' == $status) selected @endif>Approved</option>
                          <option value="Pending" @if ('Pending' == $status) selected @endif>Pending</option>
                          <option value="Cancelled" @if ('Cancelled' == $status) selected @endif>Cancelled</option>
                          <option value="Declined" @if ('Declined' == $status) selected @endif>Declined</option>
                        </select>
                      </div>
                    </div>
                    <div class='col-md-2'>
                      <button type="submit" class="form-control form-control-sm btn btn-primary mb-2 btn-sm">Filter</button>
                    </div>
                  </div>
                </form>

                <div class="table-responsive">
                  <table class="table table-hover table-bordered tablewithSearch">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Date Filed</th> 
                        <th>Leave Date</th>
                        <th>Leave Type</th>
                        <th>With Pay </th>
                        <th>Half Day </th>
                        <th>Reason </th>
                        <th>Leave Count</th>
                        <th>Status </th>
                        <th>Approvers </th>
                        <th>Uploaded File</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($employee_leaves as $employee_leave)
                      <tr>
                        <td id="tdActionId{{ $employee_leave->id }}" data-id="{{ $employee_leave->id }}">
                          @if ($employee_leave->status == 'Pending' && $employee_leave->level == 0)
                            <button type="button" id="view{{ $employee_leave->id }}" class="btn btn-primary btn-rounded btn-icon"
                                    data-target="#view_leave{{ $employee_leave->id }}" data-toggle="modal" title='View'>
                                <i class="ti-eye"></i>
                            </button>            
                            <button type="button" id="edit{{ $employee_leave->id }}" class="btn btn-info btn-rounded btn-icon"
                                    data-target="#edit_leave{{ $employee_leave->id }}" data-toggle="modal" title='Edit'>
                                <i class="ti-pencil-alt"></i>
                            </button>
                            @if(isset($cut_off_date))
                                @if($employee_leave->date_from >= $cut_off->cut_off_date)            
                                <button title='Cancel' id="cancel{{ $employee_leave->id }}" onclick="cancel({{ $employee_leave->id }})"
                                        class="btn btn-rounded btn-danger btn-icon">
                                    <i class="fa fa-ban"></i>
                                </button>
                                @endif
                            @else
                                <button title='Cancel' id="cancel{{ $employee_leave->id }}" onclick="cancel({{ $employee_leave->id }})" class="btn btn-rounded btn-danger btn-icon">
                                    <i class="fa fa-ban"></i>
                                </button>
                            @endif
                          @elseif ($employee_leave->status == 'Pending' && $employee_leave->level == 1)
                            <button type="button" id="view{{ $employee_leave->id }}" class="btn btn-primary btn-rounded btn-icon"
                                    data-target="#view_leave{{ $employee_leave->id }}" data-toggle="modal" title='View'>
                                <i class="ti-eye"></i>
                            </button>
                            @if(isset($cut_off_date))
                                @if($employee_leave->date_from >= $cut_off->cut_off_date)            
                                <button title='Cancel' id="cancel{{ $employee_leave->id }}" onclick="cancel({{ $employee_leave->id }})"
                                        class="btn btn-rounded btn-danger btn-icon">
                                    <i class="fa fa-ban"></i>
                                </button>
                                @endif
                            @else
                                <button title='Cancel' id="cancel{{ $employee_leave->id }}" onclick="cancel({{ $employee_leave->id }})" class="btn btn-rounded btn-danger btn-icon">
                                    <i class="fa fa-ban"></i>
                                </button>
                            @endif
                          @elseif ($employee_leave->status == 'Approved')
                            <button type="button" id="view{{ $employee_leave->id }}" class="btn btn-primary btn-rounded btn-icon"
                                    data-target="#view_leave{{ $employee_leave->id }}" data-toggle="modal" title='View'>
                                <i class="ti-eye"></i>
                            </button>
                            <button type="button" id="upload{{ $employee_leave->id }}" class="btn btn-success btn-rounded btn-icon uploadLeaveButton"
                                    data-target="#upload_leave{{ $employee_leave->id }}" data-toggle="modal" title='Upload'>
                                <i class="ti-upload"></i>
                            </button>

                            @if(!in_array($employee_leave->date_from, $attendance_report) || !in_array($employee_leave->date_to, $attendance_report))
                            

                                @if(date('Y-m-d', strtotime($employee_leave->date_from)) > date('Y-m-d'))
                                    <button title='Cancel' id="cancel{{ $employee_leave->id }}" onclick="cancel({{$employee_leave->id}})"
                                            class="btn btn-rounded btn-danger btn-icon">
                                        <i class="fa fa-ban"></i>
                                    </button> 
                                @endif
                            @endif
                          @else
                          <button type="button" id="view{{ $employee_leave->id }}" class="btn btn-primary btn-rounded btn-icon" data-target="#view_leave{{ $employee_leave->id }}" data-toggle="modal" title='View'><i class="ti-eye"></i></button>                                                                               
                          @endif 
                      </td>
                      <td>{{date('M. d, Y h:i A', strtotime($employee_leave->created_at))}}</td>
                      <td>{{date('M. d, Y - l', strtotime($employee_leave->date_from))}} to {{date('M. d, Y - l', strtotime($employee_leave->date_to))}} </td>
                      <td>{{ $employee_leave->leave->leave_type }}</td>
                      @if($employee_leave->withpay == 1)   
                        <td>Yes</td>
                      @else
                        <td>No</td>
                      @endif  
                      @if($employee_leave->halfday == 1)   
                        <td>Yes</td>
                      @else
                        <td></td>
                      @endif  
                      <td>
                        <p title="{{ $employee_leave->reason }}" style="width: 250px;white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                          {{ $employee_leave->reason }}
                        </p>
                      </td>
                      <td>{{ get_count_days($employee_leave->dailySchedules, $employee_leave->employee->ScheduleData, $employee_leave->date_from, $employee_leave->date_to, $employee_leave->halfday,$employee_leave->withpay) }}</td>

                      <td id="tdStatus{{ $employee_leave->id }}">
                        @if ($employee_leave->status == 'Pending')
                          <label class="badge badge-warning  mt-1">{{ $employee_leave->status }}</label>
                        @elseif($employee_leave->status == 'Approved')
                          <label class="badge badge-success mt-1">{{ $employee_leave->status }}</label>
                        @elseif($employee_leave->status == 'Rejected' || $employee_leave->status == 'Cancelled' || $employee_leave->status == 'Declined')
                          <label class="badge badge-danger  mt-1">{{ $employee_leave->status }}</label>
                        @endif                        
                      </td>
                      <td id="tdStatus{{ $employee_leave->id }}">
                        @if(!empty($employee_leave->approved_by))
                            @if($employee_leave->status == 'Declined')
                                {{$employee_leave->approveBy->name}} - <label class="badge badge-danger mt-1">Declined</label>
                            @elseif($employee_leave->status == 'Approved')
                                {{$employee_leave->approveBy->name}} - <label class="badge badge-success mt-1">Approved</label>
                            @else
                                {{$employee_leave->approveBy->name}} - <label class="badge badge-warning mt-1">Pending</label>
                            @endif
                        @else
                            @if(count($employee_leave->approver) > 0)
                            @foreach($employee_leave->approver as $approver)
                                @if($employee_leave->level >= $approver->level)
                                @if ($employee_leave->level == 0 && $employee_leave->status == 'Declined')
                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                @elseif ($employee_leave->level == 1 && $employee_leave->status == 'Declined')
                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Approved</label>
                                @else
                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                @endif
                                @else
                                @if ($employee_leave->status == 'Declined')
                                    {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                                @elseif ($employee_leave->status == 'Approved')
                                    {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                                @else
                                    {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                                @endif
                                @endif<br>
                            @endforeach
                            @else
                            <label class="badge badge-danger mt-1">No Approver</label>
                            @endif
                        @endif
                      </td>
                      <td>
                        @if($employee_leave->leave_file)
                          <a href="storage/{{ $employee_leave->leave_file }}" target="_blank">{{ $employee_leave->leave_file }}</a>
                        @else
                          No file uploaded
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

        </div>
    </div>
</div> 

@include('forms.leaves.apply_leave') 

@foreach ($employee_leaves as $leave)
  @include('forms.leaves.edit_leave')
  @include('forms.leaves.view_leave') 
  @include('forms.leaves.request_to_cancel') 
  @include('forms.leaves.leave_file') 
@endforeach

@endsection

@section('ForApprovalScript')
<script>  

  $(document).ready(function() {
    @foreach($employee_leaves as $employee_leave)
      $('.uploadLeaveButton{{ $employee_leave->id }}').on('click', function() {
          $('#upload_leave{{ $employee_leave->id }}').modal('show');
      });

      $('#uploadBtn{{ $employee_leave->id }}').on('click', function() {
          var formData = new FormData($('#uploadForm{{ $employee_leave->id }}')[0]);
          $.ajax({
              url: '{{ url("upload-attachment/".$employee_leave->id) }}',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Uploaded!',
                      text: 'File uploaded successfully!',
                      timer: 2000,
                      showConfirmButton: false
                  }).then(function() {
                      window.location.reload(true);
                      $('#upload_leave{{ $employee_leave->id }}').modal('hide');
                  });
              },
              error: function(error) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'File upload failed!',
                      confirmButtonText: 'Try Again'
                  });
              }
          });
      });
    @endforeach
  });

  function cancel(id) {
    // console.log(id);
    var element = document.getElementById('tdActionId'+id);
    var dataID = element.getAttribute('data-id');
    
    Swal.fire({
      title: "Are you sure?",
      text: "You want to cancel this leave?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willCancel) => {
      if (willCancel.isConfirmed) {
        document.getElementById("loader").style.display = "block";
        $.ajax({
          url: "disable-leave/" + id,
          method: "POST",
          data: {
            id: id
          },
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(data) {
            document.getElementById("loader").style.display = "none";
            Swal.fire("Leave has been cancelled!", {
              icon: "success",
            }).then(function() {
              document.getElementById("tdStatus" + id).innerHTML =
                "<label class='badge badge-danger'>Cancelled</label>";
              document.getElementById(dataID).remove();
              document.getElementById("edit" + dataID).remove();
            });
          }
        })
      } else {
        Swal.fire({text:"You stop the cancelation of leave.",icon:"success"});
      }
    });
  }
  

</script>
@endsection
