<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $transaction = $buyer->transactions;
        return $this->showAll($transaction);
    }
}
