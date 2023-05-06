<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'image',
        'id_Category',
    ];
   
    public $table='products';
    public function Category(){
        return $this->belongsTo('App\Product');
       }
}
