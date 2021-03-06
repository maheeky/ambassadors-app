<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductUpdatedEvent;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Product::all(), Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));
        event(new ProductUpdatedEvent);

        return response($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('title', 'description', 'image', 'price'));

        event(new ProductUpdatedEvent);

        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        event(new ProductUpdatedEvent);

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
    public function frontend()
    {
        if( \Cache::get('products_frontend') ) {
            $products = \Cache::get('products_frontend');
        } else {
            $products = Product::all();
        }
        \Cache::set('products_frontend', $products, 30*60);

        return $products;
    }
    
    public function backend(Request $request)
    {
        $page = $request->input('page', 1);

        /** @var Collection $products */
        $products = \Cache::remember('products_backend', 30*60, function() {
                return Product::all();
            });
        /**
         * If we are in a search.
         */
        $s = $request->input('s');
        if($s) 
        {
            $products = $products->filter(
                    fn(Product $product) => 
                    \Str::contains($product->title, $s) || \Str::contains($product->description, $s)
            );
        }

        //Grab count to pass into meta array
        $total = $products->count();
        if( $sort = $request->input('sort')) {
            if( $sort === 'asc' ) {
                $products = $products->sortBy([
                    //Use spaceship operator to return -1,0 or 1 based on whether a is less than, equal to or greater than b. 
                    fn($a, $b) => $a['price'] <=> $b['price']
                ]);
            } else if( $sort === 'desc' ) {
                $products = $products->sortBy([
                    //Use spaceship operator to return -1,0 or 1 based on whether a is less than, equal to or greater than b. 
                    fn($a, $b) => $b['price'] <=> $a['price']
                ]);
            }
        }

        return [
            'data' => $products->forPage($page, 9)->values(),
            'meta' => [
                'total' => $products->count(),
                'page' => $page,
                'last_page' => ceil($total / 9)
            ],
        ];
    }
}
