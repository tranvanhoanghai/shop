<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Bill;
use App\Models\Size;
use App\Models\Color;
use DB;
use Cart;
use Auth;

class CartController extends Controller
{
    public function index(){
        $data['items'] = Cart::content();
        $data['sizes']= Size::All();
        $data['colors']= Color::All();
        $data['p_s_c']= DB::table('product_size_colors')->get();
       // dd($data['items'] );
        return view('FE.cart',$data); 
    }

    public function addCart(Request $request, $id){
        $product = Product::join('product_size_colors', 'products.id_product', '=', 'product_size_colors.id_product')
                        ->join('product_images', 'products.id_product', '=', 'product_images.id_product')
                        ->find($id);

        Cart::add(['id' => $id, 'name' => $request->namep, 'qty' => $request->quantity, 'price' => $request->pricep,'weight' => 0, 'options' => ['size' => $request->size, 'color'=> $request->color,'img'=>$product->image , 'slug'=>$request->slug]]);
        $data['items'] = Cart::content();
        return back(); 
    }

    public function upCart(Request $request){
        $rowId =  $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        return redirect ('cart');
    }

    public function deCart($id){
        Cart::remove($id);
        return back();
    }
}
