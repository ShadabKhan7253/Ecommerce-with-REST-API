<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    const UNAVAILABLE_PRODUCT = "unavailable";
    const AVAILABLE_PRODUCT = "available";

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    public function isAvailable(): bool
    {
        return $this->status === self::AVAILABLE_PRODUCT;
    }

    protected $hidden = ['pivot'];

    public static function boot()
    {
        parent::boot();
        self::updated(function (Product $product) {
            if($product->qunatity === 0 && $product->isAvailable()) {
                $product->status = self::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
