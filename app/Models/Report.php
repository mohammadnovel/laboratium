<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_date', 'to_date', 'status','user_id','notes'
    ];

    public function report_compotition()
    {
        return $this->hasMany('App\Models\DetailReportCompotition');
    }

    public function report_service()
    {
        return $this->hasMany('App\Models\DetailReportService');
    }

    public function report_parameter()
    {
        return $this->hasMany('App\Models\DetailReportParameter');
    }

    public function report_patient_indification()
    {
        return $this->hasMany('App\Models\DetailReportPatientIndification');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
