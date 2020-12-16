<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bill;
use App\Models\Bill_detail;
use App\Models\User;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;

use DB;
use Auth;
use Cart;

class BillRetailController extends Controller
{
    public function index()
    {
        $data['retails'] = Bill:: where('type_bill',2)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        $data['users'] = User::All();
        return view('BE.bills.retails.bill_retail', $data);
    }

    public function view($id, $id_user)
    {
        $data['retail_details'] = Bill::join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                                ->where('bills.id_bill', $id)
                                ->get();

        $data['retails'] = Bill::where('bills.id_bill', $id)
                                ->where('type_bill', 2)
                                ->get();

        $data['bill_count'] = Bill::where('user_id', $id_user)
                                ->where('type_bill', 2)
                                ->select(Bill::raw('COUNT(id_bill) as count_bill'))
                                ->get();

        $data['users'] = User::join('bills', 'users.id', '=', 'bills.user_id')
                                ->where('bills.user_id',  $id_user)
                                ->first();

        $data['products'] = Product::All();
        $data['sizes'] = Size::All();
        $data['colors'] = Color::All();

        return view('BE.bills.retails.detail_bill_retail', $data, compact('id')); 
    }

    public function search($key) #TÌM KIẾM
    {
        $data['retails'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->where('bills.type_bill',2)
                            ->where(function ($query) use ($key) {
                                $query->where('bills.id_bill', 'like', '%'.$key.'%')
                                      ->orWhere('users.full_name', 'like', '%'.$key.'%');
                            })
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        $data['users'] = User::All();

        return view('BE.bills.retails.bill_retail',$data, compact('key'));
    }
}
 