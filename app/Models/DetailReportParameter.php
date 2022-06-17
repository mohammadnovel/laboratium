<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReportParameter extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id', 
        'parameter_id', 
        'user_id',
        'qty'
    ];

    public function report()
    {
        return $this->belongsTo('App\Models\Report');
    }

    public function parameter()
    {
        return $this->belongsTo('App\Models\Parameter');
    }
}
