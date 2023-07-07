<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        if($buyer->id === $product->seller_id){
            return $this->errorResponse("Woahh!! We caught for increasing your sales number", 409);
        }
        if(!$product->isAvailable()){
            return $this->errorResponse("Product is not available", 409);
        }
        if($request->quantity > $product->quantity){
            return $this->errorResponse("We do not have sufficient quantity", 409);
        }
        if(!$buyer->isVerified()){
            return $this->errorResponse("You must be verified to purchase on our portal", 409);
        }
        if(!$product->seller->isVerified()){
            return $this->errorResponse("Seller is not verified user! We cannot proceed with this transaction", 409);
        }

        $transaction = DB::transaction(function () use($product, $request, $buyer) {
            $product->decrement('quantity', $request->quantity);

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'product_id' => $product->id,
                'buyer_id' => $buyer->id
            ]);
            return $transaction;
        });
        return $this->showOne($transaction);
    }
}
