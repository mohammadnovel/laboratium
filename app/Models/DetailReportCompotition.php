<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReportCompotition extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id', 
        'compotition_id', 
        'user_id',
        'qty'
    ];

    public function report()
    {
        return $this->belongsTo('App\Models\Report');
    }

    public function compotition()
    {
        return $this->belongsTo('App\Models\Compotition');
    }
}
