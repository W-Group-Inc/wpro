<!-- Modal -->
<div class="modal fade" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="applyLeaveData" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applyLeaveData">Apply Leave</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="app">
        <form method='POST' action='new-leave' onsubmit="btnLeave.disabled = true; return true;"  enctype="multipart/form-data">
              @csrf       
            <div class="modal-body">
              <div class="app">
                <div class="form-group row">
                  <div class='col-md-2'>
                    Approver 
                  </div>
                  <div class='col-md-9'>
                    @foreach($all_approvers as $approvers)
                      {{$approvers->approver_info->name}}<br>
                    @endforeach
                  </div>
                </div>
                <div class="form-group row">
                  <label for="leave_type" class="col-sm-2 col-form-label">Leave Type</label>
                    <div class="col-sm-4">
                      {{-- <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email"> --}}
                      <select v-on:change="validateLeave" v-model="leave_type" class="form-control"  id="leave_type" style='width:100%;' name='leave_type' required>
                        <option value="">--Select--</option>
                        @foreach($leave_types as $leave_type)
                        {{-- <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option> --}}
                          @if($leave_type->code == 'LWOP')
                          <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @endif
                          @if($leave_type->code == 'VL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($leave_type->code == 'SL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_sil && $leave_type->code == 'SIL' && $employee_status->classifcation == 'Project Based')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                        
                          @elseif($leave_type->code == 'ML')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_pl && $leave_type->code == 'PL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_spl && $leave_type->code == 'SPL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_splw && $leave_type->code == 'SPLW')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_el && $leave_type->code == 'EL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_splvv && $leave_type->code == 'SPLVV')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_bl && $leave_type->code == 'BL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @elseif($is_allowed_to_file_el && $leave_type->code == 'EL')
                            <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <div class='col-sm-5'>
                      <div class='row'>
                        <div class='col-md-6'>
                          <input type="hidden" v-model="leave_balances" name="leave_balances" :value="leave_balances">
                          <div>
                            <label class="form-check-label ">
                              <input type="checkbox" hidden name="withpay" class="form-check-input" :disabled="isAllowedWithPay" id='checkboxwithpay' onclick="return false;" v-model="with_pay">
                              Leave Credit : <span id='leave_credit_total'></span>
                          </label>
                          </div>
                  
                        </div>
                        <div class='col-md-6'>
                          <label class="form-check-label ">
                            <input id="leaveHalfday" type="checkbox" name="halfday" class="form-check-input" value="1">
                            Halfday
                            <br>
                            <div class="halfDayStatus">
                                <select name="halfday_status" class="form-control">
                                    <option value="">Choose One</option>
                                    <option value="First Shift">First Shift</option>
                                    <option value="Second Shift">Second Shift</option>
                                </select>
                            </div>
                        </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class='col-md-2'>
                      Date From 
                    </div>
                    <div class='col-md-4'>
                      <input type="date" name='date_from'  class="form-control" required>
                    </div>
                    <div class='col-md-2'>
                      Date To 
                    </div>
                    <div class='col-md-4'>
                      <input type="date" name='date_to'  class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class='col-md-2'>
                      Reason
                    </div>
                    <div class='col-md-10'>
                      <textarea  name='reason' class="form-control" rows='4' required></textarea>
                    </div>
                  
                  </div>
                  <div class="form-group row">
                    <div class='col-md-2'>
                      Attachment
                    </div>
                    <div class='col-md-10'>
                      <input type="file" name="attachment" class="form-control"  placeholder="Upload Supporting Documents" multiple>
                    </div>
                  
                  </div>
                </div>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="btnLeave" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@php
    $total_vl_balance = 0;
    if ($vl_balance_previous <= 0.5)
    {
        $total_vl_balance = $vl_balance;
    }
    else
    {
        $total_vl_balance = $vl_balance_previous;
    }
@endphp
<script>
  var app = new Vue({
          el: '#app',
          data : {
              with_pay : '',
              leave_type : '',
              isAllowedWithPay : true,
              leave_balances : '',
              vl_balance : '<?php echo $total_vl_balance; ?>',
              sl_balance : '<?php echo $sl_balance; ?>',
              ml_balance : '<?php echo $ml_balance; ?>',
              pl_balance : '<?php echo $pl_balance; ?>',
              spl_balance : '<?php echo $spl_balance; ?>',
              splw_balance : '<?php echo $splw_balance; ?>',
              splvv_balance : '<?php echo $splvv_balance; ?>',
              el_balance : '<?php echo $el_balance; ?>',
              bl_balance : '<?php echo $bl_balance; ?>',
          },
          methods: {
            validateLeave() {
             var amen = false;
              this.leave_balances = '';
              if(this.leave_type == '1'){ // Vacation Leave
                  if(Number(this.vl_balance) >= 0.5){
                    this.leave_balances = this.vl_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '2'){ // Sick Leave
                  if(Number(this.sl_balance) >= 0.5){
                    this.leave_balances = this.sl_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '3'){ // Maternity Leave
                  if(Number(this.ml_balance) >= 0.5){
                    this.leave_balances = this.ml_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '4'){ // Paternity Leave
                  if(Number(this.pl_balance) >= 0.5){
                    this.leave_balances = this.pl_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '5'){ // SPL
                  if(Number(this.spl_balance) >= 0.5){
                    this.leave_balances = this.spl_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '7'){ // SPLW
                  if(Number(this.splw_balance) >= 0.5){
                    this.leave_balances = this.splw_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '9'){ // SPLVV
                  if(Number(this.splvv_balance) >= 0.5){
                    this.leave_balances = this.splvv_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '6'){ // EL
                  if(Number(this.el_balance) >= 0.5){
                    this.leave_balances = this.el_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else if(this.leave_type == '11'){ // BL
                  if(Number(this.bl_balance) >= 0.5){
                    this.leave_balances = this.bl_balance;
                    this.isAllowedWithPay = false;
                    amen = true;
                  }else{
                    this.isAllowedWithPay = true;
                  }
              }
              else { // BL
                    this.isAllowedWithPay = false;
             
              }
              document.getElementById('checkboxwithpay').checked = amen;
              document.getElementById("leave_credit_total").innerHTML = this.leave_balances;
            }
          },
  });

    $(document).ready(function() {
        $("#leave_type").on('change', function() {
            if ($(this).val() == 1) {
                $("[name='date_from']").attr('min', "{{date('Y-m-d', strtotime('+3 days'))}}");
                $("[name='date_to']").attr('min', "{{date('Y-m-d', strtotime('+3 days'))}}");

                $("[name='date_from']").removeAttr('max');
                $("[name='date_to']").removeAttr('max');
            } 
            else if ($(this).val() == 2) {
                // $("[name='date_from']").attr({
                //     'min': "{{date('Y-m-d', strtotime('-3 weekdays'))}}",
                //     'max': "{{date('Y-m-d', strtotime('-1 days'))}}"
                // });

                // @php
                // $("[name='date_from']").attr({
                //     'min': "{{date('Y-m-d', strtotime($attendance_logs[1]->time_in))}}",
                //     'max': "{{date('Y-m-d', strtotime('-1 day'))}}"
                // });

                // $("[name='date_to']").attr({
                //     'min': "{{date('Y-m-d', strtotime($attendance_logs[1]->time_in))}}",
                //     'max': "{{date('Y-m-d', strtotime('-1 day'))}}"
                // });
                // @endphp
                  // Use PHP to format the date and pass it to JavaScript
                  const formattedDate = "<?php echo date('Y-m-d', strtotime($last_logs)); ?>";
                  console.log(formattedDate);
                $("[name='date_from']").attr({
                    'min': "{{!empty($last_logs) ? date('Y-m-d', strtotime($last_logs)) : date('Y-m-d', strtotime('-3 weekdays'))}}",
                    'max': "{{date('Y-m-d', strtotime('-1 day'))}}"
                });
                // console.log({{!date('Y-m-d', strtotime($last_logs))}});
                $("[name='date_to']").attr({
                    'min': "{{!empty($last_logs) ? date('Y-m-d', strtotime($last_logs)) : date('Y-m-d', strtotime('-3 weekdays'))}}",
                    'max': "{{date('Y-m-d', strtotime('-1 day'))}}"
                });
            }
            else {
            $("[name='date_from']").removeAttr('min max');

            $("[name='date_to']").removeAttr('min max');
            }
        })
    })
</script>