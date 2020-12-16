<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  

use App\Models\Bill;
use App\Models\Bill_detail;
use App\Models\User;
use App\Models\Product;
use App\Models\Size; 
use App\Models\Color;
use App\Models\Shipping_unit;
use App\Models\Notice;

use DB;
use Auth;
use Cart;


class BillOrderController extends Controller
{
    public function index() #BILL ORDER
    {
        $data['orders'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->join('shipping_units', 'bills.id_shipping_unit', '=', 'shipping_units.id_shipping_unit') 
                            ->where('type_bill',1)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        return view('BE.bills.order.bill_order',$data); 
    }

    public function view($id, $id_user) # VIEW DETAIL BILL ORDER
    {
        $data['order_details'] = Bill::join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                                ->where('bills.id_bill', $id)
                                ->get();
        $data['orders'] = Bill::where('bills.id_bill', $id)->get();
        $data['bill_count'] = Bill::where('user_id', $id_user)->select(Bill::raw('COUNT(id_bill) as count_bill'))->get();
        $data['users'] = User::join('bills', 'users.id', '=', 'bills.user_id')->where('bills.user_id',  $id_user)->take(1)->get();
        $data['products'] = Product::All();
        $data['sizes'] = Size::All();
        $data['colors'] = Color::All();

        return view('BE.bills.order.detail_bill_order', $data, compact('id')); 
    }

    public function createBillOrder()
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('order')->content();
        $data['cods'] = Shipping_unit::All();
        return view('BE.bills.order.add_bill_order',$data);
    }

    public function addCart($id)
    {
        $product = Product::join('product_size_colors', 'products.id_product', '=', 'product_size_colors.id_product')
                            ->join('product_images', 'products.id_product', '=', 'product_images.id_product')
                            ->find($id);

        Cart::instance('order')->add(['id' => $id, 'name' => $product->name_product, 'qty' => 1, 'price' => $product->price1,'weight' => 0, 'options' => ['id_size' => request('id_size'), 'id_color'=> request('id_color'), 'stock' => request('stock'), 'size' => request('size') , 'color' => request('color')]]);
        $data['carts'] = Cart::instance('order')->content();
        return back ();
    }

    public function updateCart($id)
    {
        Cart::instance('order')->update($id, request('qty'));
        return back ();
    }

    public function deleteCart($id)
    {
        Cart::instance('order')->remove($id);
        return back();
    }

    public function searchProduct($key)
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->where('name_product', 'like', '%'.$key.'%')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('order')->content();
        $data['cods'] = Shipping_unit::All();
        return view('BE.bills.order.add_bill_order', $data,  compact('key'));
    }

    public function addBillOrder()
    {
        try {
            $bill = new Bill();
            $bill->name_bill = "HOÁ ĐƠN ĐẶT HÀNG";
            $bill->date = date("Y-m-d");

            if(request('name') == null){
                $user = new User();
                $user->full_name = request('fullName');
                $user->phone = request('phone');
                $user->address = request('address');
                $user->id_user_type = 3;
                $user->save();

                $bill->user_id = $user->id;
            }else{
                $bill->user_id = request('name');
            }

            $bill->price_total =  request('total');
            $bill->type_bill = 1; // 1 Đặt hàng
            $bill->sale = request('sale');
            $bill->seller = Auth::user()->id;
            $bill->note = request('note');
            $bill->id_shipping_unit = 1;
            $bill->id_shipping_price = 1;
            $bill->id_local = 1;
            $bill->price_ship = 30000;
            $bill->status = 1;  // 1 Chờ xác nhận
            $bill->save();
 
            $data['cart'] = Cart::instance('order')->content();
            
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

            Cart::instance('order')->destroy();
            $notice = new Notice();
            $notice->name = Auth::user()->full_name;
            $notice->content = 'vừa thêm mới đơn đặt hàng với giá trị : ';
            $notice->value = $bill->price_total;
            $notice->icon = 'fas fa-inbox';
            $notice->save();
            return redirect('dashboard/orders'); 

        } catch (\Throwable $th) {
            return back()->withErrors('Chọn hoặc thêm mới khách hàng');
        } 
    }

    public function confirm($id) #CẬP NHẬT XÁC NHẬN ĐƠN
    {
        $bill = Bill::find($id);
        $bill->seller = Auth::user()->id;
        $bill->status = 2;
        $bill->save();
        return back(); 
    }

    public function cod($id) #CẬP NHẬT GIAO HÀNG
    {
        $bill = Bill::find($id);
        $bill->status = 3;
        $bill->save();
        return back(); 
    }

    public function pay($id) #CẬP NHẬT THANH TOÁN
    {
        $bill = Bill::find($id);
        $bill->status = 4;
        $bill->save();
        return back(); 
    }

    public function cancelInvoice($id) #CẬP NHẬT HUỶ ĐƠN
    {
        $detail_bills = Bill_detail::where('id_bill', $id)->get();

        foreach($detail_bills as $detail_bill){
            $stock = DB::table('product_size_colors')->select('quantity')
            ->where('product_size_colors.id_product', $detail_bill->id_product)
            ->where('product_size_colors.id_size', $detail_bill->id_size)
            ->where('product_size_colors.id_color', $detail_bill->id_color)
            ->get();

            foreach($stock as $value){
                $updateQty = DB::table('product_size_colors')
                ->where('id_product', $detail_bill->id_product)
                ->where('id_size', $detail_bill->id_size)
                ->where('id_color', $detail_bill->id_color)
                ->update([
                    'quantity' => ($value->quantity + $detail_bill->qty ),
                ]); 
            }
        };
        $bill = Bill::find($id);
        $bill->status = 5;
        $bill->note = request('reason');
        $bill->save();
        return back()->with('success', 'Đã huỷ'); 
    }


    public function upNote($id) #CẬP NHẬT GHI CHÚ
    {
        $bill = Bill::find($id);
        $bill->note = request('upnote');
        $bill->save();
        return back(); 
    }

    public function search($key) #TÌM KIẾM HOÁ ĐƠN
    {
        $data['orders'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->join('shipping_units', 'bills.id_shipping_unit', '=', 'shipping_units.id_shipping_unit') 
                            ->where('bills.id_bill', 'like', '%'.$key.'%')
                            ->orWhere('users.full_name', 'like', '%'.$key.'%')
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        return view('BE.bills.order.bill_order',$data, compact('key'));
    }

    public function filter($status) #LỌC ĐƠN HÀNG THEO STATUS
    {
        $data['orders'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->join('shipping_units', 'bills.id_shipping_unit', '=', 'shipping_units.id_shipping_unit') 
                            ->where('bills.status', $status)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        return view('BE.bills.order.bill_order',$data, compact('status'));
    }

    public function sell($id) # ĐƠN ĐÃ BÁN
    {
        $data['orders'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->join('shipping_units', 'bills.id_shipping_unit', '=', 'shipping_units.id_shipping_unit') 
                            ->whereBetween('status', [2,4])
                            ->where('bills.seller', $id)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();

        return view('BE.bills.order.bill_order',$data);
    }

    public function cancelSell($id) # ĐƠN ĐÃ HUỶ
    {
        $data['orders'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->join('shipping_units', 'bills.id_shipping_unit', '=', 'shipping_units.id_shipping_unit') 
                            ->where('bills.status', 5)
                            ->where('bills.seller', $id)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();

        return view('BE.bills.order.bill_order',$data);
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
        $data['carts'] = Cart::instance('order')->content();
        $data['cods'] = Shipping_unit::All();

        return view('BE.bills.order.add_bill_order',$data, compact('option','value'));
    }

    public function sort($sort)
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.price1', $sort)
                                ->paginate(12);

        $data['carts'] = Cart::instance('order')->content();
        $data['cods'] = Shipping_unit::All();
        return view('BE.bills.order.add_bill_order',$data);
    }

}
