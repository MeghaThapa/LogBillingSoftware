<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    protected $datas = ['deleted_at']; //for softDelete
    protected $fillables =
    [
       'name',
       'unit',
       'status',
       'remark',
       'item_type',
   ];
}
