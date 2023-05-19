<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];
    public function Products(){
        return $this->hasMany('App\Models\Category');
       }
}
