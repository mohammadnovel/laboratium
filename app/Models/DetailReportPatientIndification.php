<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReportPatientIndification extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id', 
        'patient_indification_id',
        'user_id',
        'qty'
    ];

    public function report()
    {
        return $this->belongsTo('App\Models\Report');
    }

    public function patient_indification()
    {
        return $this->belongsTo('App\Models\PatientIndification');
    }
}
