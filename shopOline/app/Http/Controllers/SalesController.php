<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Product_type;
use App\Models\Color;
use App\Models\Size;
use App\Models\Bill;
use App\Models\Notice;
use App\Models\User;

use DB;
use Cart;
use Auth;

class SalesController extends Controller
{
    public function index()
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('sales')->content();
        return view('BE.sales', $data);
    }

    public function addCart($id)
    {
        $product = Product::join('product_size_colors', 'products.id_product', '=', 'product_size_colors.id_product')
                            ->join('product_images', 'products.id_product', '=', 'product_images.id_product')
                            ->find($id);

        Cart::instance('sales')->add(['id' => $id, 'name' => $product->name_product, 'qty' => 1, 'price' => $product->price1,'weight' => 0, 'options' => ['id_size' => request('id_size'), 'id_color'=> request('id_color'), 'stock' => request('stock'), 'size' => request('size') , 'color' => request('color')]]);
        $data['carts'] = Cart::content();
        return back ();
    }

    public function updateCart($id)
    {
        Cart::instance('sales')->update($id, request('qty'));
        return back ();
    }

    public function deleteCart($id)
    {
        Cart::instance('sales')->remove($id);
        return back();
    }

    public function checkout()
    {
        $bill = new Bill();
        $bill->name_bill = "HOÁ ĐƠN BÁN HÀNG";
        $bill->date = date("Y-m-d");

        if(request('name') == null){
            $bill->user_id = 2;
        }else{
            $bill->user_id = request('name');
        }

        $bill->price_total =  request('total');
        $bill->type_bill = 2; // 2 bán lẻ
        $bill->sale = request('sale');
        $bill->seller = Auth::user()->id;
        $bill->note = request('note');
        $bill->status = 4;  // 4 Đã thanh toán
        $bill->save();

        $data['cart'] = Cart::instance('sales')->content();
        
        foreach($data['cart'] as $key => $value){
             
            DB::table('bill_details')->insert([
                [ 
                    'id_bill' => $bill->id_bill ,
                    'id_product' => $value->id,
                    'id_size' => $value->options->id_size,
                    'id_color' => $value->options->id_color,
                    'qty' =>  $value->qty,
                    'unit_price' =>  $value->price,
            ]
            ]);
            
            $stock = DB::table('product_size_colors')->select('quantity') # LẤY SỐ LƯỢNG HIỆN CÓ
            ->where('product_size_colors.id_product', $value->id)
            ->where('product_size_colors.id_size', $value->options->id_size)
            ->where('product_size_colors.id_color', $value->options->id_color)
            ->first();

            $p_size_color= DB::table('product_size_colors')  # SỐ LƯỢNG SAU CÙNG = SỐ LƯỢNG HIỆN CÓ - ĐÃ MUA
            ->where('product_size_colors.id_product', $value->id)
            ->where('id_size',$value->options->id_size)
            ->where('id_color',$value->options->id_color)
            ->update(['quantity' => ($stock->quantity - $value->qty)]);
        }

        Cart::instance('sales')->destroy();
        $notice = new Notice();
            $notice->name = Auth::user()->full_name;
            $notice->content = 'vừa bán đơn hàng với giá trị : ';
            $notice->value = $bill->price_total;
            $notice->icon = 'fa fa-clipboard';
            $notice->save();
        return back(); 
    }

    public function search($key)
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->where('name_product', 'like', '%'.$key.'%')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('sales')->content();
        return view('BE.sales', $data , compact('key'));
    }

    public function suggestions()
    {
        $key = request('key');
        $data['user'] = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('user_types.type', 2)
                        ->where('users.full_name', 'like', '%'.$key.'%')
                        ->get();
                        
        echo json_encode($data);
    }

    public function sort($sort)
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.price1', $sort)
                                ->paginate(12);
        $data['carts'] = Cart::instance('sales')->content();
        $data['cate'] = Product_type::all();
        return view('BE.sales', $data);
    }

    public function discount()
    {
        $value = request('value');
        $option = request('option');
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('sales')->content();
       
        return view('BE.sales', $data, compact('option','value'));
    }
}
