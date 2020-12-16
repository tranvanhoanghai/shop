<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use App\Models\User_type;
use App\Models\Bill;
use App\Models\Bill_detail;
use App\Models\Contact;
use App\Models\Notice;
use DB;
use Auth;



class DashBoardController extends Controller
{ 
    public function index()
    {
        $data['product']= Product::select(Product::raw('COUNT(id_product) as total_product'))
                                ->first();

        $data['customer']= User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                            ->select(User_type::raw('COUNT(users.id_user_type) as total_customer'))
                            ->where('users.id_user_type', 3)
                            ->orWhere('users.id_user_type', 4)
                            ->first();

        $data['bill_order']= Bill::select(Bill::raw('COUNT(status) as total_bill'))
                            ->where('type_bill', 1)
                            ->where('status', 1)
                            ->first();

        $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                            ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                            ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                            ->where('type_bill', '<>', 3)
                                            ->where('bills.status', 4)
                                            ->whereRaw('bills.date = curdate()')
                                            ->groupBy('bill_details.id_product', 'products.name_product')
                                            ->orderBy('total_qty', 'desc')
                                            ->limit(10)->get();

        $data['bills'] = Bill::where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('date = curdate()')
                                ->count();

        $data['bill_cancel'] = Bill::where('type_bill','<>', 3)
                                ->where('status', '=', 5)
                                ->whereRaw('date = curdate()')
                                ->count();
        
        $data['revenues'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('date = curdate()')
                                ->groupBy('date','status')
                                ->get();
         
        $data['notices'] = Notice::orderBy('id_notice', 'desc')->get();
        return view('BE.home', $data);
    }

    public function revenue()
    {
        switch (request('date')) {
            case 'today':
                $data['revenue'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('date = curdate()')
                                ->groupBy('date','status')
                                ->get();
                echo json_encode($data);
                break;

            case 'yesterday':
                $data['revenue'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('date = curdate()-1')
                                ->groupBy('date','status')
                                ->get();
                echo json_encode($data);
                break;

            case 'lastWeek':
                $data['revenue'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereBetween('date', [DB::raw('curdate() - INTERVAL 1 WEEK'),DB::raw('curdate()')])
                                ->groupBy('date','status')
                                ->get();
                echo json_encode($data);
                break;

            case 'thisMonth':
                $data['revenue'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('MONTH(date) = MONTH(curdate())')
                                ->groupBy('date','status')
                                ->get();
                echo json_encode($data);
                break;

            case 'lastMonth':
                $data['revenue'] = Bill::select(Bill::raw('DAY(date) as dates') , Bill::raw('MONTH(date) as month'), Bill::raw('SUM(price_total) as total'))
                                ->where('type_bill','<>', 3)
                                ->where('status', '=', 4)
                                ->whereRaw('MONTH(date) = MONTH(curdate() - INTERVAL 1 MONTH)')
                                ->groupBy('date','status')
                                ->get();
                echo json_encode($data);
                break;

            default:
                # code...
                break;
        }
    }

    public function bestSeller()
    {
        switch (request('date')) {
            case 'today':
                $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                                ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                                ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                                ->where('type_bill', '<>', 3)
                                                ->where('bills.status', 4)
                                                ->whereRaw('bills.date = curdate()')
                                                ->groupBy('bill_details.id_product', 'products.name_product')
                                                ->orderBy('total_qty', 'desc')
                                                ->limit(10)->get();
                echo json_encode($data);
                break;

            case 'yesterday':
                $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                                ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                                ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                                ->where('type_bill', '<>', 3)
                                                ->where('bills.status', 4)
                                                ->whereRaw('bills.date = curdate()-1')
                                                ->groupBy('bill_details.id_product', 'products.name_product')
                                                ->orderBy('total_qty', 'desc')
                                                ->limit(10)->get();
                echo json_encode($data);
                break;

            case 'lastWeek':
                $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                                ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                                ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                                ->where('type_bill', '<>', 3)
                                                ->where('bills.status', 4)
                                                ->whereBetween('date', [DB::raw('curdate()-INTERVAL 1 WEEK'),DB::raw('curdate()')])
                                                ->groupBy('bill_details.id_product', 'products.name_product')
                                                ->orderBy('total_qty', 'desc')
                                                ->limit(10)->get();
                echo json_encode($data);
                break;

            case 'thisMonth':
                $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                                ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                                ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                                ->where('type_bill', '<>', 3)
                                                ->where('bills.status', 4)
                                                ->whereRaw('MONTH(date) = MONTH(curdate())')
                                                ->groupBy('bill_details.id_product', 'products.name_product')
                                                ->orderBy('total_qty', 'desc')
                                                ->limit(10)->get();
                echo json_encode($data);
                break;

            case 'lastMonth':
                $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                                                ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                                ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                                                ->where('type_bill', '<>', 3)
                                                ->where('bills.status', 4)
                                                ->whereRaw('MONTH(date) = MONTH(curdate()-INTERVAL 1 MONTH)')
                                                ->groupBy('bill_details.id_product', 'products.name_product')
                                                ->orderBy('total_qty', 'desc')
                                                ->limit(10)->get();
                echo json_encode($data);
                break;

            default:
                # code...
                break;
        }
    }

    public function indexProfile()
    {
        $data['profiles'] = DB::table('role_users')
        ->join('users', 'role_users.user_id', '=', 'users.id')
        ->join('roles', 'role_users.role_id', '=', 'roles.id')
        ->where('users.id', Auth::user()->id)
        ->first();

        $data['sells'] = Bill::select(Bill::raw('COUNT(id_bill) as total_sell'))
        ->where('seller', Auth::user()->id)
        ->where('type_bill', '<>', 3)
        ->whereBetween('status', [2,4])
        ->first();

        $data['cancels'] = Bill::select(Bill::raw('COUNT(id_bill) as total_cancel'))
        ->where('seller', Auth::user()->id)
        ->where('type_bill', '<>', 3)
        ->where('status', 5)
        ->first();
        return view('BE.profile', $data);
    }

    public function updateProfile($id)
    {
        request()->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'address'=>'required',
            'phone'=>'required|digits:10|numeric'
        ],[
            'name.required'=>'Tên không được trống',
            'email.required'=>'Email không được trống',
            'email.email'=>'Đúng theo định dạng email',
            'email.unique'=>'Email đã tồn tại',
            'address.required'=>'Địa chỉ không được trống',
            'phone.required'=>'Số điện thoại không được trống',
            'phone.digits'=>'Tối đa 10 số',
            'phone.numeric'=>'Phải là số'
        ]);
        
        $profile = User::find($id);
        $profile->full_name    = request('name');
        $profile->email        = request('email');
        $profile->address      = request('address');
        $profile->phone        = request('phone');
        $profile->save();
        return back();
    }

    // CONTACT
    public function indexContact()
    {
        $data['contacts'] = Contact::orderBy('id','desc')->paginate(10);
        return view('BE.web.contact', $data);
    }
     
    public function deleteContact($id)
    {
        Contact::find($id)->delete();
        return back()->with('success','Xoá thành công');
    }

    // NHÂN VIÊN
    public function indexStaff()
    {
        $data['staffs'] = User::where('users.id_user_type', 2)
                                ->orderBy('id','desc')
                                ->paginate(15);
        $data['roles'] = Role::All();
        $data['user_roles'] = DB::table('role_users')->get();
        return view('BE.staff', $data);
    }

    public function addStaff()
    {
        request()->validate([
            'email'=>"unique:users,email",
        ],[
            'email.unique'=>'Email đã tồn tại',
        ]);

        $staff = new User();
        $staff->full_name = request('name');
        $staff->email = request('email');
        $staff->phone = request('phone');
        $staff->address = request('address');
        $staff->id_user_type = 2;
        $staff->save();
        DB::table('role_users')->insert([
            'user_id' => $staff->id,
            'role_id' => request('role')
        ]);

        $notice = new Notice();
        $notice->name = Auth::user()->full_name;
        $notice->content = 'vừa thêm mới nhân viên';
        $notice->value = request('name');
        $notice->icon = 'far fa-user';
        $notice->save();
        return back();
    }

    public function editStaff($id)
    {
        request()->validate([
            'email'=>"unique:users,email,{$id},",
        ],[
            'email.unique'=>'Email đã tồn tại',
        ]);

        $data['staffs'] = User::find($id);
        $data['roles'] = Role::All();
        $data['role_user'] = DB::table('role_users')->where('user_id', $id)->first();

        $data['sell'] =Bill::select(Bill::raw('COUNT(id_bill) as total_sell'))
                        ->where('seller', $id)
                        ->where('status', 4)
                        ->first();
        echo json_encode($data);
    }

    public function updateStaff($id)
    {
        $staff = User::find($id);
        $staff->full_name = request('name');
        $staff->email = request('email');
        $staff->phone = request('phone');
        $staff->address = request('address');
        DB::table('role_users')->where('user_id', $id)->update([ 'role_id' => request('role') ]);
        $staff->save();

        $notice = new Notice();
        $notice->name = Auth::user()->full_name;
        $notice->content = 'vừa sửa thông tin nhân viên ';
        $notice->value = request('name');
        $notice->icon = 'far fa-user';
        $notice->save();
        return back();
    }

    public function deleteStaff($id)
    {
        User::find($id)->delete();
        return back();
    }

    public function searchStaff($key)
    {
        $data['staffs'] = User::where('users.full_name','like', '%'.$key.'%')
                                ->where('users.id_user_type', 2)
                                ->orderBy('id','desc')
                                ->paginate(15);
        $data['roles'] = Role::All();
        return view('BE.staff', $data, compact('key'));
    }

    // PHÂN QUYỀN
    public function indexRole()
    {
        $data['roles'] = Role::All();
        return view('BE.roles.roles', $data);
    }

    public function viewAddRole()
    {
        return view('BE.roles.add_role');
    }

    public function addRole()
    {
        $role = new Role();
        $roles= implode(',',request('role')); // Tách mảng thành chuỗi
        $role->permissions = '{'.$roles.'}'; // tạo chuỗi JSON
        $role->name = request('name');
        $role->slug = Str::slug(request('name'), '-');
        $role->save();
         return redirect('dashboard/roles');
    }
    
    public function editRole($id)
    {
        $data['roles'] = Role::where('id',$id)->first();
        return view('BE.roles.edit_role', $data, compact('id'));
    }

    public function updateRole($id)
    {   
        $roles= implode(',',request('role')); // Tách mảng thành chuỗi
            
        $role= Role::find($id);
        $role->permissions = '{'.$roles.'}'; // tạo chuỗi JSON
        $role->name = request('name');
        $role->slug = Str::slug(request('name'), '-');
        $role->save();
        return back();
    }

    public function deleteRole($id)
    {
        Role::find($id)->delete();
        return back();
    }

    // BÁO CÁO
    public function report($year)
    {
        if($year == 'thisYear'){
            $data['total_import'] = Bill::selectRaw('SUM(price_total) as total_import') # TỔNG NHẬP 
                        ->where('type_bill', 3)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->first();

            $data['total_sell'] = Bill::selectRaw('SUM(price_total) as total_sell') # DOANH THU BÁN HÀNG
                        ->where('type_bill', 2)
                        ->where('status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')

                        ->first();

            $data['total_ship'] = Bill::selectRaw('SUM(price_total) as total_ship, COUNT(price_total) as count') # TIỀN DAONH THU ĐẶT HÀNG = TỔNG - TiỀN SHIP
                        ->where('type_bill', 1)
                        ->where('status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->first();

            $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                        ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                        ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                        ->where('type_bill', '<>', 3)
                        ->where('bills.status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->groupBy('bill_details.id_product', 'products.name_product')
                        ->orderBy('total_qty', 'desc')
                        ->limit(10)->get();

            $data['top_customers'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                        ->join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                        ->select('full_name','phone', DB::raw('SUM(qty) as total_qty'))
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->where('bills.status', '<>', 5)
                        ->where(function ($query) {
                            $query->where('id_user_type', 3)
                            ->orWhere('id_user_type', 4);
                        })
                        ->groupBy( 'full_name', 'phone')
                        ->orderBy('total_qty', 'desc')
                        ->limit(10)->get();

            $data['top_staffs'] = Bill::select('seller', DB::raw('SUM(price_total) as total_price'))
                        ->where('type_bill',2)
                        ->where('status', '=', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->groupBy('seller')
                        ->orderBy('total_price', 'desc')
                        ->limit(10)->get();

            $data['top_qtys'] = Bill::join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                        ->select('seller', DB::raw('SUM(qty) as total_qty'))
                        ->where('type_bill', '<>', 3)
                        ->where('status', '=', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())')
                        ->groupBy('seller')
                        ->get();

            $data['users'] = User::All();
            return view('BE.report.overview', $data, compact('year'));
        }else{

            $data['total_import'] = Bill::selectRaw('SUM(price_total) as total_import') # TỔNG NHẬP 
                        ->where('type_bill', 3)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->first();

            $data['total_sell'] = Bill::selectRaw('SUM(price_total) as total_sell') # DOANH THU BÁN HÀNG
                        ->where('type_bill', 2)
                        ->where('status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')

                        ->first();

            $data['total_ship'] = Bill::selectRaw('SUM(price_total) as total_ship, COUNT(price_total) as count') # TIỀN DAONH THU ĐẶT HÀNG = TỔNG - TiỀN SHIP
                        ->where('type_bill', 1)
                        ->where('status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->first();

            $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
                        ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                        ->select('products.name_product', Product::raw('SUM(qty) as total_qty'))
                        ->where('type_bill', '<>', 3)
                        ->where('bills.status', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->groupBy('bill_details.id_product', 'products.name_product')
                        ->orderBy('total_qty', 'desc')
                        ->limit(10)->get();

            $data['top_customers'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                        ->join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                        ->select('full_name','phone', DB::raw('SUM(qty) as total_qty'))
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->where(function ($query) {
                            $query->where('id_user_type', 3)
                            ->orWhere('id_user_type', 4);
                        })
                        ->groupBy( 'full_name', 'phone')
                        ->orderBy('total_qty', 'desc')
                        ->limit(10)->get();

            $data['top_staffs'] = Bill::select('seller', DB::raw('SUM(price_total) as total_price'))
                        ->where('type_bill',2)
                        ->where('status', '=', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->groupBy('seller')
                        ->orderBy('total_price', 'desc')
                        ->limit(10)->get();

            $data['top_qtys'] = Bill::join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                        ->select('seller', DB::raw('SUM(qty) as total_qty'))
                        ->where('type_bill', '<>', 3)
                        ->where('status', '=', 4)
                        ->whereRaw('YEAR(date) = YEAR(curdate())-1')
                        ->groupBy('seller')
                        ->get();

            $data['users'] = User::All();
            return view('BE.report.overview', $data, compact('year'));
        }
    }
}
