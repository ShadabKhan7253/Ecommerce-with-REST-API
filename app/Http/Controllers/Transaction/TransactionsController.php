<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends ApiController
{
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
