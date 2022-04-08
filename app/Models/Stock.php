<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable=[
        'batch_number',
        'quantity',
        'cp',
        'sp',
        'purchase_items_id',
        'order_items_id',
        'status'
    ];

    public function purchaseItem(){
        return $this->belongsTo(PurchaseItem::class, 'purchase_items_id');
    }

    public function orderItem(){
        return $this->belongsTo(order_item::class,'order_items_id');
    }
}
