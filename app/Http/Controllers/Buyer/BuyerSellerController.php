<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $seller = $buyer->transactions()
        ->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique();

        return $this->showAll($seller);
    }
}
