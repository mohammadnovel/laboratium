<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReportService extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id', 
        'service_id',
        'user_id',
        'qty'
    ];

    public function report()
    {
        return $this->belongsTo('App\Models\Report');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
