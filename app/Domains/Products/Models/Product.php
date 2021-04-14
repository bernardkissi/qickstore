<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


     /**
     * Fillable properties of the model.
     *
     * @var array
     */
     protected $fillable = [
        
       'name',
       'price',
       'description',
       'slug'

     ];


     /**
     *  Route key returned
     *
     * @return string
     */
     public function getRouteKeyName()
     {

          return 'slug';
     }


     /**
     *  Product belongs to category relationship
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
     public function categories()
     {

         return $this->belongsToMany(Category::class);
     }
}
