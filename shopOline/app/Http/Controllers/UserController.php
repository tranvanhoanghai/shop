<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_type;
use App\Models\Bill_detail;
use App\Models\Color;
use App\Models\Size;
use Auth;

class UserController extends Controller
{
    # CONTROLLER KHÁCH HÀNG

    public function indexCustomer(){
        $customer = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('user_types.type', 2)
                        ->orderBy('users.id')
                        ->paginate(5);

        $type = User_type::whereNotIn('user_types.type',[0,1,3]) // SELECT KHÁCH HÀNG
                        ->get();
        return view('BE.customers.customer', compact('customer','type'));
    }

    public function searchCustomer($key){
        $customer = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('id', 'like', '%'.$key.'%')
                        ->orWhere('full_name', 'like', '%'.$key.'%')
                        ->where('user_types.type', 2)
                        ->paginate(1);     

        $type = User_type::whereNotIn('user_types.type',[0,1,3]) // SELECT KHÁCH HÀNG
                        ->get();
        return view('BE.customers.customer', compact('customer','key','type'));
    }

    public function addCustomer()
    {
        request()->validate([
            'nameKH'=>'required',
            'email'=>'required|email|unique:users,email,',
            'address'=>'required',
            'phone'=>'required|numeric|digits:10',
        ],[
            'nameKH.required'=>'Tên khách hàng không được trống', 
            'email.required'=>'Email không được trống',
            'email.email'=>'Đúng theo định dạng email',
            'email.unique'=>'Email đã tồn tại',

            'address.required'=>'Địa chỉ không được trống',
            'phone.required'=>'Số điện thoại không được trống',

            'phone.numeric'=>'Phải là số',
            'phone.digits'=>'Tối đa 10 số'
        ]);
        
        $customer = new User();
        $customer->full_name = request('nameKH');
        $customer->email = request('email');
        $customer->address = request('address');
        $customer->phone = request('phone');
        $customer->id_user_type = request('typeKH');
        $customer->save();
        return redirect('dashboard/customers/')->with('success', 'Thêm thành công');
    }

    public function editCustomer($id){ // TÌM ID ĐỂ UPDATE
        $data['user'] = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                                ->where('users.id', $id)
                                ->get();
        echo json_encode($data);
    }

    public function updateCustomer(Request $request, $id){
        $request->validate([
            'nameKH'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'address'=>'required',
            'phone'=>'required|numeric|digits:10',
        ],[
            'nameKH.required'=>'Tên khách hàng không được trống', 
            'email.required'=>'Email không được trống',
            'email.email'=>'Đúng theo định dạng email',
            'email.unique'=>'Email đã tồn tại',

            'address.required'=>'Địa chỉ không được trống',
            'phone.required'=>'Số điện thoại không được trống',

            'phone.numeric'=>'Phải là số',
            'phone.digits'=>'Tối đa 10 số'
        ]);
        
        $customer = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('users.id', $id)
                        ->first();
        $customer->full_name= request('nameKH');
        $customer->email= request('email');
        $customer->address= request('address');
        $customer->phone= request('phone');
        $customer->id_user_type= request('typeKH');

        $customer->save();
        return redirect('dashboard/customers/')->with('success', 'Cập nhật thành công');

    }

    public function deleteCustomer($id){
        User::find($id)->delete();
    }


    # CONTROLLER NHÀ CUNG CẤP

    public function indexSupplier(){
        $supplier = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('user_types.type', 3)
                        ->orderBy('users.id')
                        ->paginate(10);

        $type = User_type::whereNotIn('user_types.type',[0,1,2]) // SELECT NCC
                        ->get();
        return view('BE.customers.supplier', compact('supplier','type'));
    }

    public function searchSupplier($key){
        $supplier = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('id', 'like', '%'.$key.'%')
                        ->orWhere('full_name', 'like', '%'.$key.'%')
                        ->where('user_types.type', 3)
                        ->paginate(1);     

        $type = User_type::whereNotIn('user_types.type',[0,1,2]) // SELECT NCC
                        ->get();
        return view('BE.customers.supplier', compact('supplier','key','type'));
    }

    public function addSupplier(Request $request){
        $request->validate([
            'nameNCC'=>'required',
            'emailNCC'=>'required|email|unique:users,email,',
            'addressNCC'=>'required',
            'phoneNCC'=>'required|digits:10|numeric',
        ],[
            'nameNCC.required'=>'Tên khách hàng không được trống',
            'emailNCC.required'=>'Email không được trống',
            'emailNCC.email'=>'Đúng theo định dạng email',
            'emailNCC.unique'=>'Email đã tồn tại',
            'addressNCC.required'=>'Địa chỉ không được trống',
            'phoneNCC.required'=>'Số điện thoại không được trống',
            'phoneNCC.digits'=>'Số điện thoại tối đa 10 số',
            'phoneNCC.numeric'=>'Phải là số'
        ]);
        
        $supplier = new User();
        $supplier->full_name    = request('nameNCC');
        $supplier->email        = request('emailNCC');
        $supplier->address      = request('addressNCC');
        $supplier->phone        = request('phoneNCC');
        $supplier->id_user_type = request('typeNCC');
        $supplier->save();
        return redirect('dashboard/suppliers/')->with('success', 'Add thành công');
    }

    public function editSupplier($id){ // TÌM ID ĐỂ UPDATE
        $data['user'] = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                                ->where('users.id', $id)
                                ->get();
        echo json_encode($data);
    }

    public function updateSupplier(Request $request, $id){
        $request->validate([
            'upNameNCC'=>'required',
            'upEmailNCC'=>'required|email|unique:users,email,'.$id,
            'upAddressNCC'=>'required', 
            'upPhoneNCC'=>'required|digits:10|numeric',
        ],[
            'upNameNCC.required'=>'Tên khách hàng không được trống',
            'upEmailNCC.required'=>'Email không được trống',
            'upEmailNCC.email'=>'Đúng theo định dạng email',
            'upEmailNCC.unique'=>'Email đã tồn tại',
            'upAddressNCC.required'=>'Địa chỉ không được trống',
            'upPhoneNCC.required'=>'Số điện thoại không được trống',
            'upPhoneNCC.digits'=>'Tối đa 10 số',
            'upPhoneNCC.numeric'=>'Phải là số'
        ]);
        
        $supplier = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('users.id', $id)
                        ->first();
        $supplier->full_name    = request('upNameNCC');
        $supplier->email        = request('upEmailNCC');
        $supplier->address      = request('upAddressNCC');
        $supplier->phone        = request('upPhoneNCC');
        $supplier->id_user_type = request('uptypeNCC');

        $supplier->save();
        return redirect('dashboard/suppliers/')->with('success', 'Cập nhật thành công');

    }

    public function deleteSupplier($id){
        User::find($id)->delete();
    }

   
    // CONTROLER USER ACCOUNT
    public function indexAcc(){
        $data['bills'] = Bill_detail::join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                            ->join('products', 'bill_details.id_product', '=', 'products.id_product')
                            ->where('bills.user_id', Auth::id())
                            ->orderBy('bills.id_bill', 'desc')
                            ->select('*', 'bills.status as bill_status')
                            ->get();

        foreach($data['bills'] as $bills){
            $data['sizes'] = Size::where('id_size', $bills->id_size)->first();
            $data['colors'] = Color::where('id_color', $bills->id_color)->first();
        };
        
                            
        return view('FE.account', $data);
    }

    public function editAcc($id){ // TÌM ID ĐỂ UPDATE
        
        $data['user'] = User::where('id', $id)->get();
        echo json_encode($data);
    }

    public function upAcc(Request $request, $id){

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'address'=>'required',
            'phone'=>'required|digits:10|numeric'

        ],[
            'name.required'=>'Tên khách hàng không được trống',
            'email.required'=>'Email không được trống',
            'email.email'=>'Đúng theo định dạng email',
            'email.unique'=>'Email đã tồn tại',
            'address.required'=>'Địa chỉ không được trống',
            'phone.required'=>'Số điện thoại không được trống',
            'phone.digits'=>'Tối đa 10 số',
            'phone.numeric'=>'Phải là số'
        ]);
        
        $supplier = User::find($id);
        $supplier->full_name    = request('name');
        $supplier->email        = request('email');
        $supplier->address      = request('address');
        $supplier->phone        = request('phone');
        $supplier->provincial   = request('calc_shipping_provinces');
        $supplier->district     = request('calc_shipping_district');

        $supplier->save();
        return redirect('account')->with('success', 'Cập nhật thành công');
     
    }
}
