<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bill;
use App\Models\User;
use App\Models\Size;
use App\Models\Color;
use App\Models\Coupon;
 
use Cart;
use Auth;
use DB;
use Mail;


class CheckOutController extends Controller
{
    public function index(){

        $data['items']  = Cart::content();
        $data['sizes']  = Size::All();
        $data['colors'] = Color::All();
        $data['p_s_c']  = DB::table('product_size_colors')->get();
        return view('FE.checkout',$data); 
    }

    public function checkCoupon(){
        $data['items']  = Cart::content();
        $data['sizes']  = Size::All();
        $data['colors'] = Color::All();
        $data['p_s_c']  = DB::table('product_size_colors')->get();
        $data['coupons'] = Coupon::where('coupon_code', request('coupon'))->first();

        if($data['coupons'] == null){
            return back()->withErrors('Mã giảm giá không tồn tại');
        }else{
            if($data['coupons']->coupon_number > 0){
                return view('FE.checkout',$data); 
            }else{
                return back()->withErrors('Mã giảm giá đã hết hạn');
            }
        }
    }

     public function checkout(){
        $data['user'] = User::find(Auth::user()->id);
        $data['user']->full_name = request('name');
        $email = $data['user']->email = request('email'); 
        $data['user']->phone = request('phone');
        $data['user']->address = request('address');
        $data['user']->provincial  = request('calc_shipping_provinces');
        $data['user']->district   = request('calc_shipping_district');
        $data['user']->save();

        $data['cart'] = Cart::content();
        $data['sizes']= Size::All();
        $data['colors']= Color::All();

        $bill = new Bill();
        $bill->name_bill = "HOÁ ĐƠN ĐẶT HÀNG";
        $bill->date = date("Y-m-d");
        $bill->user_id = Auth::user()->id;
        $bill->price_total =  request('total');
        $bill->type_bill = 1; // 1 Đơn đặt hàng
        $bill->id_shipping_unit = 1;
        $bill->id_shipping_price = 1;
        $bill->id_local = 1;
        $bill->sale = request('coupon');
        $bill->seller = 0;
        $bill->price_ship = request('shipping_rate_id');
        $bill->note = request('note');
        $bill->status = 1;  // 1 Đặt hàng
        $bill->save();
        
        foreach($data['cart'] as $key => $value){
            
            DB::table('bill_details')->insert([
                [ 
                    'id_bill' => $bill->id_bill ,
                    'id_product' => $value->id,
                    'id_size' => $value->options->size,
                    'id_color' => $value->options->color,
                    'qty' =>  $value->qty,
                    'unit_price' =>  $value->price,
               ]
            ]);
            $stock = DB::table('product_size_colors')->select('quantity') #LẤY SỐ LƯỢNG HIỆN CÓ
            ->where('product_size_colors.id_product', $value->id)
            ->where('product_size_colors.id_size', $value->options->size)
            ->where('product_size_colors.id_color', $value->options->color)
            ->get();
            
            $p_size_color= DB::table('product_size_colors')  # SỐ LƯỢNG SAU CÙNG = SỐ LƯỢNG HIỆN CÓ - ĐÃ MUA
            ->where('product_size_colors.id_product', $value->id)
            ->where('id_size',$value->options->size)
            ->where('id_color',$value->options->color)
            ->update(['quantity' => ($stock[0]->quantity - $value->qty)]);
        }

        Mail::send('FE.email', $data, function ($message) use ($email){
            $message->from('www.tummachine0614@gmail.com', 'shop Tums');
            $message->to($email, $email);
            $message->cc('tranvanhoanghai2510@gmail.com', 'hai');
            $message->subject('Xác nhận hoá đơn mua hàng');
        });

        Cart::destroy();
        if(request('id_coupon') != null){
            $coupons = Coupon::find(request('id_coupon'));
            $coupons->coupon_number = $coupons->coupon_number - 1;
            $coupons->save();
        }

        return view('FE.success', $data);
    }
}
