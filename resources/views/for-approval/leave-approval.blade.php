@extends('layouts.header')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class='row grid-margin'>
          <div class='col-lg-2 mt-2'>
            <div class="card card-tale">
              <div class="card-body">
                <div class="media">                
                  <div class="media-body">
                    <h4 class="mb-4">For Approval</h4>
                    <a href="/for-leave?status=Pending" class="h2 card-text text-white">{{$for_approval}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class='col-lg-2 mt-2'>
            <div class="card card-dark-blue">
              <div class="card-body">
                <div class="media">                
                  <div class="media-body">
                    <h4 class="mb-4">Approved</h4>
                    <a href="/for-leave?status=Approved" class="h2 card-text text-white">{{$approved}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class='col-lg-2 mt-2'>
            <div class="card card-light-danger">
              <div class="card-body">
                <div class="media">                
                  <div class="media-body">
                    <h4 class="mb-4">Declined / Rejected</h4>
                    <a href="/for-leave?status=Declined" class="h2 card-text text-white">{{$declined}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>            
          
          <div class='col-lg-2 mt-2'>
            <div class="card card-light-blue">
              <div class="card-body">
                <div class="media">                
                  <div class="media-body">
                    <h4 class="mb-4">Request to Cancel</h4>
                    <a href="/for-leave?request_to_cancel=1" class="h2 card-text text-white">{{$request_to_cancel}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>  
      

        </div>
        <div class='row'>
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">For Approval Leave</h4>

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
                @if(empty($status) || $status == 'Pending')
                  <label>
                    <input type="checkbox" id="selectAll">
                    <span id="labelSelectAll">Select All</span> 
                  </label>
                @endif

                <button class="btn btn-success btn-sm mb-2" id="approveAllBtn" style="display: none;">Approve</button>
                <button class="btn btn-danger btn-sm mb-2" id="disApproveAllBtn" style="display: none;">Disapprove</button>

                <div class="table-responsive">
                  <table class="table table-hover table-bordered tablewithSearch">
                    <thead>
                      <tr>
                        @if(empty($status) || $status == 'Pending')
                          <th>
                            Select
                          </th>
                        @endif
                        <th>Action </th> 
                        <th>Date Filed</th>
                        <th>Employee Name</th>
                        <th>Form Type</th>
                        <th>Date</th>
                        <th>Count</th>
                        <th>With Pay </th>
                        <th>Half Day </th>
                        <th>Status</th> 
                        <th>Approvers</th> 
                        <th>Reason/Remarks</th> 
                        <th>Attachment</th>
                        <th>Approved Date</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach ($leaves as $form_approval)
                      <tr>
                        @if(empty($status) || $status == 'Pending')
                          <td align="center">
                            @foreach($form_approval->approver as $k => $approver)
                              @if($approver->approver_id == $approver_id && $form_approval->level == $k && $form_approval->status == 'Pending')
                                
                                  <input type="checkbox" class="checkbox-item" data-id="{{$form_approval->id}}">
                                </td>
                              @endif
                            @endforeach
                          </td>
                        @endif
                        <td align="center" id="tdActionId{{ $form_approval->id }}" data-id="{{ $form_approval->id }}">
                          @php
                              $approver_last = '';
                          @endphp
                          @foreach($form_approval->approver as $k => $approver)
                            @if($approver->approver_id == $approver_id && $form_approval->level == $k && $form_approval->status == 'Pending')
                              <button type="button" class="btn btn-success btn-sm" id="{{ $form_approval->id }}" data-target="#leave-approved-remarks-{{ $form_approval->id }}" data-toggle="modal" title="Approve">
                                <i class="ti-check btn-icon-prepend"></i>                                                    
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" id="{{ $form_approval->id }}" data-target="#leave-declined-remarks-{{ $form_approval->id }}" data-toggle="modal" title="Decline">
                                <i class="ti-close btn-icon-prepend"></i>                                                    
                              </button> 
                            @endif<br> 

                            @php
                                $approver_last = $approver->approver_id;
                            @endphp
                          @endforeach

                          @if($approver_last == $approver_id && $form_approval->request_to_cancel == '1')
                            <button type="button" id="view{{ $form_approval->id }}" class="btn btn-warning btn-rounded btn-icon"
                              data-target="#requestToCancelLeave{{ $form_approval->id }}" data-toggle="modal" title='Request to Cancel'>
                              <i class="fa fa-ban"></i>
                          @endif

                        </td>
                        <td>{{date('M. d, Y h:i A', strtotime($form_approval->created_at))}}</td>
                        <td>
                            <strong>{{$form_approval->user->employee->last_name . ' ' . $form_approval->user->employee->first_name }}</strong> <br>
                            <small>Position : {{$form_approval->user->employee->position}}</small> <br>
                            <small>Location : {{$form_approval->user->employee->location}}</small> <br>
                            <small>Department : {{ $form_approval->user->employee->department ? $form_approval->user->employee->department->name : ""}}</small> 
                        </td>
                        <td>{{$form_approval->leave->leave_type}}</td>
                        <td>{{date('M d, Y', strtotime($form_approval->date_from))}} - {{date('M d, Y', strtotime($form_approval->date_to))}}</td>
                        <td>{{get_count_days($form_approval->dailySchedules, $form_approval->schedule,$form_approval->date_from,$form_approval->date_to,$form_approval->halfday,$form_approval->withpay)}}</td>
                        @if($form_approval->withpay == 1)   
                          <td>Yes</td>
                        @else
                          <td>No</td>
                        @endif  
                        @if($form_approval->halfday == 1)   
                          <td>Yes</td>
                        @else
                          <td></td>
                        @endif  
                        <td>
                          @if ($form_approval->status == 'Pending')
                            <label class="badge badge-warning">{{ $form_approval->status }}</label>
                          @elseif($form_approval->status == 'Approved')
                            <label class="badge badge-success" title="{{$form_approval->approval_remarks}}">{{ $form_approval->status }}</label>
                          @elseif($form_approval->status == 'Declined' || $form_approval->status == 'Cancelled')
                            <label class="badge badge-danger" title="{{$form_approval->approval_remarks}}">{{ $form_approval->status }}</label>
                          @endif  
                        </td>
                        <td id="tdStatus{{ $form_approval->id }}">
                          @foreach($form_approval->approver as $approver)
                            @if($form_approval->level >= $approver->level)
                              @if ($form_approval->level == 0 && $form_approval->status == 'Declined')
                              {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                              @else
                                {{$approver->approver_info->name}} -  <label class="badge badge-success mt-1">Approved</label>
                              @endif
                            @else
                              @if ($form_approval->status == 'Declined')
                                {{$approver->approver_info->name}} -  <label class="badge badge-danger mt-1">Declined</label>
                              @else
                                {{$approver->approver_info->name}} -  <label class="badge badge-warning mt-1">Pending</label>
                              @endif
                            @endif<br>
                          @endforeach
                        </td>
                        <td>
                          {{-- <p title="{{$form_approval->reason}}" style="width: 250px;white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                            {{$form_approval->reason}}
                          </p> --}}
                          {!! nl2br(e($form_approval->reason)) !!}
                        </td>
                        <td>
                          @if($form_approval->attachment)
                          <a href="{{url($form_approval->attachment)}}" target='_blank' class="text-start"><button type="button" class="btn btn-outline-info btn-sm ">View Attachment</button></a>
                          @endif
                          @if($form_approval->leave_file)
                          <a href="{{url('storage/'.$form_approval->leave_file)}}" target='_blank' class="text-start"><button type="button" class="btn btn-outline-info btn-sm ">View Attachment</button></a>
                          @endif
                        </td>
                        <td>
                          @if ($form_approval->status == 'Approved')
                            {{ $form_approval->approved_date ? date('M. d, Y', strtotime($form_approval->approved_date)) : ""}}
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

<script>
  $(document).ready(function() {
      // "Select All" checkbox click event
      $('#selectAll').on('click', function() {
          const isChecked = $(this).prop('checked');
          $('.checkbox-item').prop('checked', isChecked);
          updateSelectedCount();

          if ($(this).is(':checked')) {

            const selectedCount = $('.checkbox-item:checked').length;

            if(selectedCount > 0){
              
              // Checkbox is checked, show the button
              $('#approveAllBtn').show();
              $('#disApproveAllBtn').show();

            }
          } else {
              // Checkbox is unchecked, hide the button
              $('#approveAllBtn').hide();
              $('#disApproveAllBtn').hide();

              $('#labelSelectAll').text('Select All');
          }
      });

      $('.checkbox-item').on('click', function() {
          if ($(this).is(':checked')) {
              // Checkbox is checked, show the button
              $('#approveAllBtn').show();
              $('#disApproveAllBtn').show();
          } else {
              // Checkbox is unchecked, hide the button
              $('#approveAllBtn').hide();
              $('#disApproveAllBtn').hide();

              $('#labelSelectAll').text('Select All');
          }

          updateSelectedCount();
      });

      // Submit button click event to perform the POST request
      $('#approveAllBtn').on('click', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to approve this Leave?",
            icon: "warning",
            buttons: true,
          })
          .then((willCancel) => {
            if (willCancel) {
              document.getElementById("loader").style.display = "block";
                  
              const selectedItems = [];
              
              $('.checkbox-item:checked').each(function() {
                  const id = $(this).data('id'); // Get the 'data-id' attribute value
                  selectedItems.push({ id: id });
              });

              const dataToSend = {
                  ids: JSON.stringify(selectedItems)
              };

              $.ajax({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'POST',
                  url: '/approve-leave-all',
                  data: dataToSend,
                  dataType: 'json',
                  success: function(response) {
                    console.log(response)
                    document.getElementById("loader").style.display = "none";
                    Swal.fire(" Leave has been Approved " + "("+response+")", {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },
                  error: function(error) {
                      console.error('Error sending AJAX POST request:', error);
                  }
              });
            }
          });
      });

      // Submit button click event to perform the POST request
      $('#disApproveAllBtn').on('click', function() {
          swal({
            title: "Are you sure?",
            text: "You want to disapprove this Leave?",
            icon: "warning",
            buttons: true,
          })
          .then((willCancel) => {
            if (willCancel) {
              document.getElementById("loader").style.display = "block";
              
              const selectedItems = [];
              
              $('.checkbox-item:checked').each(function() {
                  const id = $(this).data('id'); // Get the 'data-id' attribute value
                  selectedItems.push({ id: id });
              });

              const dataToSend = {
                  ids: JSON.stringify(selectedItems)
              };

              $.ajax({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'POST',
                  url: '/disapprove-leave-all',
                  data: dataToSend,
                  dataType: 'json',
                  success: function(response) {
                    console.log(response)
                    document.getElementById("loader").style.display = "none";
                    swal("Leave has been Disapproved " + "("+response+")", {
                      icon: "success",
                    }).then(function() {
                      location.reload();
                    });
                  },
                  error: function(error) {
                      console.error('Error sending AJAX POST request:', error);
                  }
              });
            }
          });
      });

  
      function updateSelectedCount() {
          const selectedCount = $('.checkbox-item:checked').length;
          $('#approveAllBtn').text( '('+ selectedCount + ') Approve');
          $('#disApproveAllBtn').text( '('+ selectedCount + ') Disapprove');
      }


  });
</script>

@foreach ($leaves as $leave)
  @include('for-approval.remarks.leave_approved_remarks')
  @include('for-approval.remarks.leave_declined_remarks')
  @include('for-approval.request_to_cancel.leave_request_to_cancel')
@endforeach

{{-- @php
function get_count_days_leaves($data,$date_from,$date_to,$halfday)
 {

    if($date_from == $date_to){
        $count = 1;
    }else{
      $data = ($data->pluck('name'))->toArray();
      $count = 0;
      $startTime = strtotime($date_from);
      $endTime = strtotime($date_to);

      for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
        $thisDate = date( 'l', $i ); // 2010-05-01, 2010-05-02, etc
        if(in_array($thisDate,$data)){
            $count= $count+1;
        }
      }
    }

    if($count == 1 && $halfday == 1){
      return '0.5';
    }else{
      return($count);
    }
    
 } 
@endphp   --}}




@endsection

