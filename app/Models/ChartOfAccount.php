<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccount extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'chart_of_accounts';

    protected $fillable = [
        'tenant_id','type','code', 'name'
    ];
}
