<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $this->middleware('view-coupon');
        $data['coupons'] = Coupon::orderBy('coupon_id', 'desc')->paginate(10);
        return view('BE.products.coupon', $data);
    }

    public function add()
    {
        request()->validate([
            'code' => "required|unique:coupons,coupon_code",
        ],[
            'code.required' => 'code không được trống',
            'code.unique' => 'code đã tốn tại',
        ]);

        $coupon = new Coupon();
        $coupon->coupon_name    = request('name');
        $coupon->coupon_code    = strtoupper(request('code'));
        $coupon->coupon_number	= request('number');
        $coupon->coupon_time    = request('time');
        $coupon->coupon_status  = request('status');
        $coupon->coupon_value   = request('value');
        $coupon->save();
        return back();
    }

    public function edit($id)
    {
        $data['coupons'] = Coupon::find($id);
        echo json_encode($data);
    }

    public function update($id)
    {
        request()->validate([
            'code' => "required|unique:coupons,coupon_code,{$id},coupon_id",
        ],[
            'code.required' => 'code không được trống',
            'code.unique' => 'code đã tốn tại',
        ]);

        $coupon = Coupon::find($id);
        $coupon->coupon_name    = request('name');
        $coupon->coupon_code    = strtoupper(request('code'));
        $coupon->coupon_number	= request('number');
        $coupon->coupon_time    = request('time');
        $coupon->coupon_status  = request('status');
        $coupon->coupon_value   = request('value');
        $coupon->save();
        return back();
    }

    public function delete($id)
    {
        Coupon::find($id)->delete();
        return back()->with('success','Xoá thành công');
    }
}
