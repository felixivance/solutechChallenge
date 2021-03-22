<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;
    protected $fillable=['supply_id','product_id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supply_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
