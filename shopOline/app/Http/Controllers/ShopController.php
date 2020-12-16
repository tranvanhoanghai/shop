<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product_type; #category
use App\Models\Product_image;  
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\User;
use App\Models\Visit; 

use DB;

class ShopController extends Controller
{
    
    public function index(){ //INDEX SHOP
        $data['cates'] = Product_type::where('status', 1)->get();
        $data['product'] = Product::where('status', 'true')
                                    ->orderBy('products.id_product', 'desc')
                                    ->paginate(18);
        $data['image'] = DB::table('product_images')->get();
        $data['sold']= DB::table('product_size_colors')
                            ->select('product_size_colors.id_product',DB::raw('SUM(product_size_colors.quantity) as sold'))
                            ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                            ->groupBy('product_size_colors.id_product')
                            ->get();
        return view('FE.shop', $data);
    }

    public function indexCate($category){  # INDEX SHOP/CATEGORY | CHECK BÁN HẾT
        $data['cates'] = Product_type::where('status', 1)->get();
        $data['product'] = Product::join('product_types', 'products.id_product_type',  '=', 'product_types.id_product_type')
                            ->where('product_types.name_product_type', $category)
                            ->where('products.status', 'true')
                            ->where('product_types.status', 1)
                            ->orderBy('products.id_product', 'desc')
                            ->paginate(18);
        $data['image'] = DB::table('product_images')->get();

        $data['sold']  = DB::table('product_size_colors')
                        ->select('product_size_colors.id_product',DB::raw('SUM(product_size_colors.quantity) as sold'))
                        ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                        ->groupBy('product_size_colors.id_product')
                        ->get();
        return view('FE.shop', $data, compact('category'));
    }

    public function item($slug_product){ #SHOP->CLICK ITEM -> ITEM
        $data['images'] = Product::join('product_images', 'products.id_product', '=', 'product_images.id_product')
                            ->where('products.slug_product', $slug_product)
                            ->get();
        $data['product'] = Product::where('products.slug_product', $slug_product)
                            ->where('status', 'true')
                            ->get();

        $data['colors'] = DB::table('product_size_colors')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->select('product_size_colors.id_color', 'product_size_colors.id_product', 'colors.color')
                                ->distinct('colors.id_color')
                                ->get();
        foreach($data['product'] as $value){
            $data['related_products'] = Product::where('status', 'true')
                                                ->where('id_product_type', $value ->id_product_type)
                                                ->where('id_product','<>', $value ->id_product)
                                                ->inRandomOrder()->take(10)->get();
        }
        $data['image'] = Product_image::All();
        return view('FE.item', $data, compact('slug_product'));
    }

    public function itemCate($category, $slug_product){ #SHOP->CLICK CATEGORY  -> ITEM
        
        $data['images'] = Product::join('product_images', 'products.id_product', '=', 'product_images.id_product')
                                ->where('products.slug_product', $slug_product)
                                ->get();

        $data['product'] = Product::where('products.slug_product', $slug_product)
                                ->get();

        $data['colors'] = DB::table('product_size_colors')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->select('product_size_colors.id_color', 'product_size_colors.id_product', 'colors.color')
                                ->distinct('colors.id_color')
                                ->get();
        foreach($data['product'] as $value){
            $data['related_products'] = Product::where('status', 'true')
                                                ->where('id_product_type', $value ->id_product_type)
                                                ->where('id_product','<>', $value ->id_product)
                                                ->inRandomOrder()->take(10)->get();
        }
        $data['image'] = Product_image::All();
                            
        return view('FE.item', $data, compact('slug_product'));
    }


    public function size(Request $request){ # GET SIZE
    	$color = $request->input('color_id');
        $pro = $request->input('pro'); #id product
        $size = DB::table('product_size_colors')
                        ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                        ->where('product_size_colors.id_color', $color)
                        ->where('product_size_colors.id_product', $pro)
                        ->get();
        return response()->json($size);
    }

    public function stock(Request $request){  # GET NUMBER 
    	$color = $request->input('color_id');
        $size = $request->input('size');
        $pro = $request->input('pro'); #id product
        $num= DB::table('product_size_colors')
                        ->where('product_size_colors.id_color', $color)
                        ->where('product_size_colors.id_size', $size)
                        ->where('product_size_colors.id_product', $pro)
                        ->take(1)
                        ->get();
        return response()->json($num);
    }

    // TÌM KIẾM SẢN PHẨM
    public function search($key)
    {
        $data['cates'] = Product_type::where('status', 1)->get();
        $data['product'] = Product::where('name_product', 'like', '%'.$key.'%')->where('status', 'true')->orderBy('products.id_product', 'desc')->paginate(18);
        $data['image'] = DB::table('product_images')->get();
        $data['sold']= DB::table('product_size_colors')
                            ->select('product_size_colors.id_product',DB::raw ('SUM(product_size_colors.quantity) as sold'))
                            ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                            ->groupBy('product_size_colors.id_product')
                            ->get();
        return view('FE.shop', $data, compact('key'));
    }

    // LỌC THEO GIÁ
    public function filter()
    {
        $up = number_format(request('up'),0,',','');
        $to = number_format(request('to'),0,',','');

        $data['cates'] = Product_type::where('status', 1)->get();
        $data['image'] = DB::table('product_images')->get();
        $data['sold']= DB::table('product_size_colors')
                            ->select('product_size_colors.id_product',DB::raw('SUM(product_size_colors.quantity) as sold'))
                            ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                            ->groupBy('product_size_colors.id_product')
                            ->get();

        $data['product'] = Product::whereBetween('price1', [$up, $to])->where('status', 'true')->orderBy('products.id_product', 'desc')->paginate(100);
        return view('FE.shop', $data);
    }

    //SẮP XẾP

    public function sort($sort)
    {
        switch ($sort) {
            case 'priceAsc':
                $data['cates'] = Product_type::where('status', 1)->get();
                $data['product'] = Product::where('status', 'true')
                                    ->orderBy('products.price1', 'asc')
                                    ->paginate(18);
                $data['image'] = DB::table('product_images')->get();
                $data['sold']= DB::table('product_size_colors')
                                    ->select('product_size_colors.id_product',DB::raw ('SUM(product_size_colors.quantity) as sold'))
                                    ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                                    ->groupBy('product_size_colors.id_product')
                                    ->get();
                return view('FE.shop', $data, compact('sort'));
                break;

            case 'priceDesc':
                $data['cates'] = Product_type::where('status', 1)->get();
                $data['product'] = Product::where('status', 'true')
                                    ->orderBy('products.price1', 'desc')
                                    ->paginate(18);
                $data['image'] = DB::table('product_images')->get();
                $data['sold']= DB::table('product_size_colors')
                                    ->select('product_size_colors.id_product',DB::raw ('SUM(product_size_colors.quantity) as sold'))
                                    ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                                    ->groupBy('product_size_colors.id_product')
                                    ->get();
                return view('FE.shop', $data, compact('sort'));
                break;

            case 'newProduct':
                $data['cates'] = Product_type::where('status', 1)->get();
                $data['product'] = Product::where('status', 'true')
                                    ->orderBy('id_product', 'desc')
                                    ->paginate(18);
                $data['image'] = DB::table('product_images')->get();
                $data['sold']= DB::table('product_size_colors')
                                    ->select('product_size_colors.id_product',DB::raw ('SUM(product_size_colors.quantity) as sold'))
                                    ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                                    ->groupBy('product_size_colors.id_product')
                                    ->get();
                return view('FE.shop', $data, compact('sort'));
                break;

            case 'oldProduct':
                $data['cates'] = Product_type::where('status', 1)->get();
                $data['product'] = Product::where('status', 'true')
                                    ->orderBy('id_product', 'asc')
                                    ->paginate(18);
                $data['image'] = DB::table('product_images')->get();
                $data['sold']= DB::table('product_size_colors')
                                    ->select('product_size_colors.id_product',DB::raw ('SUM(product_size_colors.quantity) as sold'))
                                    ->havingRaw('SUM(product_size_colors.quantity) = ?', [0])
                                    ->groupBy('product_size_colors.id_product')
                                    ->get();
                return view('FE.shop', $data, compact('sort'));
                break;
            
        }
    }
}
