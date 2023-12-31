<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionsController extends ApiController
{
    public function index(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }
}
