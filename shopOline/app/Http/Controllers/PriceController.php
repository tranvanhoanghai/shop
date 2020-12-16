<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Product_type;


class PriceController extends Controller
{
       //  THIẾT LẬP GIÁ

       public function indexPrice()
       {
           $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                   ->orderBy('products.id_product', 'desc')
                   ->paginate(10);
   
           $data['categorys'] = Product_type::All();
           
           return view('BE.products.prices', $data);
       }
   
       public function updatePrice($id)
       {
          $product = Product::find($id);
          $product->price0 = str_replace('.', '',request('price0'));
          $product->price1 = str_replace('.', '',request('price1'));
          $product->save();
          return back();
   
       }
        // FILTER PRODUCT

        public function filterByCate($cate)
        {
            $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                    ->where('product_types.name_product_type', $cate)
                    ->orderBy('products.id_product', 'desc')
                    ->paginate(10);
    
            $data['categorys'] = Product_type::All();
            
            return view('BE.products.prices', $data, compact('cate'));
        }
    
        public function filterByStatus($status)
        {
            $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                    ->where('products.status', $status)
                    ->orderBy('products.id_product', 'desc')
                    ->paginate(10);
    
            $data['categorys'] = Product_type::All();
            
            return view('BE.products.prices', $data, compact('status'));
        }
    
        public function search($key) # SEARCH PRODUCT
        {
            $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                    ->where('products.name_product', 'like', '%'.$key.'%')
                    ->orWhere('products.id_product', 'like', '%'.$key.'%')
                    ->orWhere('product_types.name_product_type', 'like', '%'.$key.'%')
                    ->orderBy('products.id_product', 'desc')
                    ->paginate(10);
            $data['categorys'] = Product_type::All();
            return view('BE.products.prices', $data, compact('key'));
        }
}
