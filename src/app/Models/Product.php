<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Season;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','image','detail'];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }
    // use HasFactory;

    // protected $guarded = [
    //     'id',
    // ];

    // public function seasons()
    // {
    //     return $this->belongsToMany(Season::class, 'product_season');
    // }
}
