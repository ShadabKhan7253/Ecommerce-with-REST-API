<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductsController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request, Seller $seller)
    {
        // Till the product is not associated with the category, it cannot be marks as Available

        $rules = [
            'name' => 'required|max:255',
            'description' => 'required|min:5',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        return $this->showOne($product,201);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'name' => 'max:255',
            'description' => 'min:5',
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::AVAILABLE_PRODUCT . ",". Product::UNAVAILABLE_PRODUCT,
            // 'image' => 'image'
        ];

        $this->validate($request,$rules);
        $this->validateSeller($seller,$product);

        $product->fill($request->only(['name','description','quantity','status']));

        if($request->has('status')) {
            if($product->isAvailable() && $product->categories()->count() === 0) {
                throw new HttpException(409,"A product must have atleast one category associated to mark it as avaible");
            }
        }

        if($request->has('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

        if($product->isClean()) {
            $this->errorResponse("You should update one field at leats",422);
        }

        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->validateSeller($seller, $product);
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne(new Product(), 204);
    }

    private function validateSeller(Seller $seller, Product $product)
    {
        if($seller->id !== $product->seller_id) {
            throw new HttpException(422,"You are trying to update someone else's product!");
        }
    }
}
