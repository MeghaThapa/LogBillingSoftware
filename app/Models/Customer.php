<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    protected $datas = ['deleted_at']; //for softDelete
    protected $fillables =
     [
        'name',
        'address',
        'email',
        'contact_no_1',
        'contact_no_2',
        'remark',
        

    ];

}
