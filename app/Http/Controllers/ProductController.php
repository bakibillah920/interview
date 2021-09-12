<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request) {

        $variantArr = Variant::join('product_variants', 'product_variants.variant_id', 'variants.id')
                ->select('variants.title', 'product_variants.variant', 'variants.id')
                ->distinct('product_variants.variant')
                ->get();

        $variantListArr = array();
        foreach ($variantArr as $variant) {
            $variantListArr[$variant->id][] = $variant->variant;
        }

        $variantNameArr = Variant::pluck('title', 'id')->toArray();


        $varianPIdArr = $rangePIdArr = [];
        if (!empty($request->variant_id)) {
            $varianPIdArr = ProductVariant::where('variant', $request->variant_id)->pluck('product_id', 'id')->toArray();
        }
        if (!empty($request->price_from) && !empty($request->price_to)) {
            $rangePIdArr = ProductVariantPrice::whereBetween('price', [$request->price_from, $request->price_to])
                            ->pluck('product_id')->toArray();
        }


        // get product Query 
        $targetArr = Product::select('products.*');
        $targetArr = $targetArr->with(['ProductVariantPrice' => function($q) use($request, $varianPIdArr) {
                $q->join('products', 'products.id', 'product_variant_prices.product_id');
                $q->leftJoin('product_variants as one', 'one.id', 'product_variant_prices.product_variant_one');
                $q->leftJoin('product_variants as two', 'two.id', 'product_variant_prices.product_variant_two');
                $q->leftJoin('product_variants as three', 'three.id', 'product_variant_prices.product_variant_three');

                if (!empty($request->from) && !empty($request->to)) {
                    $q = $q->whereBetween('product_variant_prices.price', [$request->from, $request->to]);
                }
                if (!empty($varianPIdArr)) {
                    $q = $q->where(function ($query) use ($request, $varianPIdArr) {
                                $query->whereIn('product_variant_prices.product_variant_one', array_keys($varianPIdArr));
                                $query->orWhereIn('product_variant_prices.product_variant_two', array_keys($varianPIdArr));
                                $query->orWhereIn('product_variant_prices.product_variant_three', array_keys($varianPIdArr));
                            });
                }

                $q = $q->select('product_variant_prices.*', 'one.variant as one_variant', 'two.variant as two_variant'
                        , 'three.variant as three_variant');
            }
        ]);

        // end Product Query 
        // get vaiant wise query 
        if (!empty($request->variant_id)) {
            $targetArr = $targetArr->whereIn('products.id', $varianPIdArr);
        }
        // end variant wise query 
        if (!empty($request->price_from) && !empty($request->price_to)) {
            $targetArr = $targetArr->whereIn('products.id', $rangePIdArr);
        }

        $searchText = $request->title;
        if (!empty($searchText)) {
            $targetArr = $targetArr->where(function ($query) use ($searchText) {
                $query->where('products.title', 'LIKE', '%' . $searchText . '%');
            });
        }

        if (!empty($request->date)) {
            $targetArr = $targetArr->whereDate('products.created_at', '=', $request->date);
        }



        $targetArr = $targetArr->paginate(3);

//        $targetArr = $targetArr->get();
//                echo '<pre>';
//                print_r($targetArr->toArray());
//                exit;

        return view('products.index', compact('targetArr', 'variantListArr', 'variantNameArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create() {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        $variantArr = Variant::join('product_variants', 'product_variants.variant_id', 'variants.id')
                ->select('variants.title', 'product_variants.variant', 'variants.id')
                ->where('product_variants.product_id', $id)
                ->distinct('product_variants.variant')
                ->get();

        $variantListArr = array();
        foreach ($variantArr as $variant) {
            $variantListArr[$variant->id][] = $variant->variant;
        }

        $variants = Variant::pluck('title', 'id')->toArray();


        // get product Query 
        $targetArr = Product::select('products.*', 'product_images.file_path')
                ->leftJoin('product_images', 'product_images.product_id', 'products.id')
                ->where('products.id', $id)
                ->first();


        $previewArr = Product::select('products.*');
        $previewArr = $previewArr->with(['ProductVariantPrice' => function($q) {
                $q->join('products', 'products.id', 'product_variant_prices.product_id');
                $q->leftJoin('product_variants as one', 'one.id', 'product_variant_prices.product_variant_one');
                $q->leftJoin('product_variants as two', 'two.id', 'product_variant_prices.product_variant_two');
                $q->leftJoin('product_variants as three', 'three.id', 'product_variant_prices.product_variant_three');
                $q = $q->select('product_variant_prices.*', 'one.variant as one_variant', 'two.variant as two_variant'
                        , 'three.variant as three_variant');
            }
        ]);
        $previewArr = $previewArr->where('products.id', $id)->first();

        return view('products.edit', compact('variants', 'targetArr', 'variantListArr', 'variants','previewArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        echo '<pre>';
        print_r($request->all());exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        //
    }

}
