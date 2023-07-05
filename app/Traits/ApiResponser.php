<?php

namespace App\Traits;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    public function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }
    public function errorResponse($message, $code)
    {
        return response()->json(['error'=>$message, 'code'=>$code], $code);
    }
    public function showAll(Collection $collection, int $code = 200)
    {
        return $this->successResponse(['data'=>$collection], $code);
    }
    public function showOne(Model $model,int $code = 200)
    {
        return $this->successResponse(['data'=>$model], $code);
    }

}
