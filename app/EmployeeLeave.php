<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeave extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function created_by_info()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class,'leave_type','id');
    } 
    
    public function employee()
    {
        return $this->belongsTo(Employee::class,'user_id','user_id');
    }     

    public function schedule()
    {
        return $this->hasMany(ScheduleData::class,'schedule_id','schedule_id');
    }   
    
    public function approver()
    {
        return $this->hasMany(EmployeeApprover::class,'user_id','user_id');
    }   
    
    public function dailySchedules()
    {
        return $this->hasManyThrough(DailySchedule::class, Employee::class, 'user_id', 'employee_code', 'user_id', 'employee_code');
    }
    public function approveBy()
    {
        return $this->belongsTo(User::class,'approved_by','id');
    }
}
