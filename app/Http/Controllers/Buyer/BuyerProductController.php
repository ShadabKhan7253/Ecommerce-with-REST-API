<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $product = $buyer->transactions()
        ->with('product')
        ->get()
        ->pluck('product');
        return $this->showAll($product);
    }
}
