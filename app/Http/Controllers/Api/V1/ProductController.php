<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductCollection;
use App\Services\V1\ProductQuery;
use App\Http\Requests\V1\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ProductQuery();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return new ProductCollection(Product::paginate());
            
        }else{
            return Product::where($queryItems)->get();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
