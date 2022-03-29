<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    protected $datas = ['deleted_at'];//softDeletes
    protected $fillables =
    [
       'name',
       'address',
       'contact',
       'pan_no',
       'vat_no',
       'remark',
       

   ];
}
