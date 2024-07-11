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
                    <a href="/for-official-business?status=Pending" class="h2 card-text text-white">{{$for_approval}}</a>
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
                    <a href="/for-official-business?status=Approved" class="h2 card-text text-white">{{$approved}}</a>
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
                    <a href="/for-official-business?status=Declined" class="h2 card-text text-white">{{$declined}}</a>
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
                <h4 class="card-title">For Approval OB</h4>

                <form method='get' onsubmit='show();' enctype="multipart/form-data">
                  <div class=row>
                    <div class='col-md-2'>
                      <div class="form-group">
                        <label class="text-right">From</label>
                        <input type="date" value='{{$from}}' class="form-control form-control-sm" name="from" onchange='get_min(this.value);' required />
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
                        <th>Employee Name</th>
                        <th>Date Filed</th>
                        <th>Date</th>
                        <th>Time In-Out</th>
                        <th>Destination</th>
                        <th>Person/Company to see</th>
                        <th>Purpose</th>
                        <th>Approvers</th> 
                        <th>Attachment</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach ($obs as $form_approval)
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
                          @foreach($form_approval->approver as $k => $approver)
                            @if($approver->approver_id == $approver_id && $form_approval->level == $k && $form_approval->status == 'Pending')
                              <button type="button" class="btn btn-success btn-sm" id="{{ $form_approval->id }}" data-target="#ob-approved-remarks-{{ $form_approval->id }}" data-toggle="modal" title="Approve">
                                <i class="ti-check btn-icon-prepend"></i>                                                    
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" id="{{ $form_approval->id }}" data-target="#ob-declined-remarks-{{ $form_approval->id }}" data-toggle="modal" title="Decline">
                                <i class="ti-close btn-icon-prepend"></i>                                                    
                              </button> 
                            @endif<br> 
                          @endforeach
                        </td>
                        <td>
                            <strong>{{$form_approval->user->name}}</strong> <br>
                            <small>Position : {{$form_approval->user->employee->position}}</small> <br>
                            <small>Location : {{$form_approval->user->employee->location}}</small> <br>
                            <small>Department : {{ $form_approval->user->employee->department ? $form_approval->user->employee->department->name : ""}}</small>
                        </td>
                        <td> {{ $form_approval->created_at }} </td>
                        <td> {{ date('d/m/Y ', strtotime($form_approval->applied_date)) }}</td>
                        <td> {{ date('H:i', strtotime($form_approval->date_from)) }} - {{ date('H:i', strtotime($form_approval->date_to)) }}  </td>
                        <td> {{$form_approval->destination}}</td>
                        <td> {{$form_approval->persontosee}}</td>
                        <td> 
                          <p title="{{$form_approval->remarks}}" style="width: 250px;white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                            {{$form_approval->remarks}}
                          </p>
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
                          @if($form_approval->attachment)
                          <a href="{{url($form_approval->attachment)}}" target='_blank' class="text-start"><button type="button" class="btn btn-outline-info btn-sm ">View Attachment</button></a>
                          @endif
                        </td>
                        <td>
                          @if ($form_approval->status == 'Pending')
                            <label class="badge badge-warning">{{ $form_approval->status }}</label>
                          @elseif($form_approval->status == 'Approved')
                            <label class="badge badge-success" title="{{$form_approval->approval_remarks}}">{{ $form_approval->status }}</label>
                          @elseif($form_approval->status == 'Declined' || $form_approval->status == 'Cancelled')
                            <label class="badge badge-danger" title="{{$form_approval->approval_remarks}}">{{ $form_approval->status }}</label>
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
            text: "You want to approve this OB?",
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
                  url: '/approve-ob-all',
                  data: dataToSend,
                  dataType: 'json',
                  success: function(response) {
                    console.log(response)
                    document.getElementById("loader").style.display = "none";
                    Swal.fire("OB has been Approved " + "("+response+")", {
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
            text: "You want to disapprove this OB?",
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
                  url: '/disapprove-ob-all',
                  data: dataToSend,
                  dataType: 'json',
                  success: function(response) {
                    console.log(response)
                    document.getElementById("loader").style.display = "none";
                    swal("OB has been Disapproved " + "("+response+")", {
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

@foreach ($obs as $ob)
  @include('for-approval.remarks.ob_approved_remarks')
  @include('for-approval.remarks.ob_declined_remarks')
@endforeach

@endsection

