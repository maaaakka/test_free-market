<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Season extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public  function products()
    {
        return $this->belongsToMany(Product::class, 'product_season');
    }

    // use HasFactory;

    // protected $guarded = [
    //     'id',
    // ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_season');
    // }
}
