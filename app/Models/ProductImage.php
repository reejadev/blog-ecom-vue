<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    // Specify the table if it's not the default 'product_images'
    protected $table = 'product_images';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'product_id',
        'image_path',
        'mime_type',
        'size',
    ];


    public function product()
{
    //return $this->belongsTo(Product::class);
    return $this->belongsTo(Product::class, 'product_id', 'id');
}
}