<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Bill;
use App\Models\Bill_detail;
use App\Models\Product;
use App\Models\Product_type;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\Color;
use App\Models\Shipping_unit;
use App\Models\Notice;


use DB;
use Auth;
use Cart;


class BillImportController extends Controller
{
    public function index()
    {
        $data['imports'] = Bill::where('type_bill', 3)
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        $data['users'] = User::All();

        return view('BE.bills.import.bill_import',$data); 
    }

    public function view($id, $id_user)
    {
        $data['retail_details'] = Bill::join('bill_details', 'bills.id_bill', '=', 'bill_details.id_bill')
                                ->where('bills.id_bill', $id)
                                ->get();

        $data['imports'] = Bill::where('bills.id_bill', $id)
                                ->where('type_bill', 3)
                                ->get();

        $data['bill_count'] = Bill::where('user_id', $id_user)
                                ->where('type_bill', 3)
                                ->select(Bill::raw('COUNT(id_bill) as count_bill'))
                                ->get();

        $data['users'] = User::join('bills', 'users.id', '=', 'bills.user_id')
                                ->where('bills.user_id',  $id_user)
                                ->first();

        $data['products'] = Product::All();
        $data['sizes'] = Size::All();
        $data['colors'] = Color::All();

        return view('BE.bills.import.detail_bill_import', $data, compact('id')); 
    }

    public function create()
    {
        $data['product_s_c'] = DB::table('product_size_colors')
                                ->join('products', 'product_size_colors.id_product', '=', 'products.id_product')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->orderBy('products.id_product','desc')
                                ->paginate(12);
        $data['carts'] = Cart::instance('imports')->content();

        $data['sizes'] = Size::all();
        $data['colors'] = Color::all();
        $data['categorys'] = Product_type::all();

        return view('BE.bills.import.add_bill_import',$data); 
    }

    public function import()
    {
        try {

            $bill = new Bill();
            $bill->name_bill = "HOÁ ĐƠN NHẬP HÀNG";
            $bill->date = date("Y-m-d");

            if(request('name') == null){
                $user = new User();
                $user->full_name = request('fullName');
                $user->email = request('email');
                $user->phone = request('phone');
                $user->address = request('address');
                $user->id_user_type = 5; // 5 NCC
                $user->save();

                $bill->user_id = $user->id;
            }else{
                $bill->user_id = request('name');
            }

            $bill->price_total =  request('total');
            $bill->type_bill = 3; // 3 Nhập hàng
            $bill->sale = request('sale');
            $bill->seller = Auth::user()->id;
            $bill->note = request('note');
            $bill->status = 4;  // 4 Đã thanh toán
            $bill->save();

            $data['cart'] = Cart::instance('imports')->content();
            
            foreach($data['cart'] as $key => $value){
                
                DB::table('bill_details')->insert([
                    [ 
                        'id_bill' => $bill->id_bill,
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

                $p_size_color= DB::table('product_size_colors')  # SỐ LƯỢNG SAU CÙNG = SỐ LƯỢNG HIỆN CÓ + ĐÃ NHẬP
                ->where('product_size_colors.id_product', $value->id)
                ->where('id_size',$value->options->id_size)
                ->where('id_color',$value->options->id_color)
                ->update(['quantity' => ($stock->quantity + $value->qty)]);
            }

            Cart::instance('imports')->destroy();

            $notice = new Notice();
            $notice->name = Auth::user()->full_name;
            $notice->content = 'vừa nhập đơn hàng với giá trị : ';
            $notice->value = $bill->price_total;
            $notice->icon = 'fa fa-share-square';
            $notice->save();
            return redirect('dashboard/imports'); 
        } catch (\Throwable $th) {
            return back()->withErrors('Chọn hoặc thêm mới nhà cung cấp');
        } 
    }

    public function updateQty($id)
    {
        Cart::instance('imports')->update($id, request('qty'));
        return back();
    }

    // public function updatePrice($id)
    // {
    //     Cart::instance('imports')->update($id, ['price' => request('price')]);
    //     return back();
    // }

    public function deleteCart($id)
    {
        Cart::instance('imports')->remove($id);
        return back();
    }

    public function addProduct()
    {
        request()->validate([
            'createName'=>"unique:products,name_product",
            'filepath'=>"required"
        ],[
            'createName.unique'=>'Tên sản phẩm đã tồn tại',
            'filepath.required'=>'Ảnh sản phẩm không được trống và phải chọn 2 ảnh trở lên',
        ]);

        $product = new Product();
        $product->name_product = strtoupper(request('createName'));
        $product->slug_product = Str::slug(request('createName'), '-');
        $product->id_product_type = request('type');

        $image = explode(',',"".request('filepath')."");
        $product->img = $image[0];

        $product->price0 = request('price0');
        $product->price1 = request('price1');

        $product->unit  = request('unit');
        $product->description   = request('createDescription');
        $product->status   = 'true';

        $product->save();

        foreach($image as $file)
        {
            $product_image = new Product_image();
            $product_image->id_product = $product->id_product;
            $product_image->image = $file;
            $product_image->save();
        };

        for($count = 0; $count < count(request('size')); $count++)
        {
            $data = array(
                'size'   => request('size')[$count],
                'color'  => request('color')[$count],
                'qty' => request('qty')[$count]
            ); 

            DB::table('product_size_colors')->insert([
                [
                    'id_product' => $product->id_product,
                    'id_size'    => $data['size'],
                    'id_color'   => $data['color'],
                    'quantity'   => $data['qty'],
                ]
            ]);
        }
        return back();
    }

    public function select($id)
    {
        $product = Product::join('product_size_colors', 'products.id_product', '=', 'product_size_colors.id_product')
                            ->find($id);
        Cart::instance('imports')->add(['id' => $id, 'name' => $product->name_product, 'qty' => 1, 'price' => $product->price0,'weight' => 0, 'options' => ['id_size' => request('id_size'), 'id_color'=> request('id_color'), 'size' => request('size') , 'color' => request('color')]]);
        $data['carts'] = Cart::content();
        return back ();
    }

    public function suggestions()
    {
        $key = request('key');
        $data['user'] = User::join('user_types', 'users.id_user_type', '=', 'user_types.id_user_type')
                        ->where('user_types.type', 3)
                        ->where('users.full_name', 'like', '%'.$key.'%')
                        ->get();
                        
        echo json_encode($data);
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
        $data['carts'] = Cart::instance('imports')->content();

        $data['sizes'] = Size::all();
        $data['colors'] = Color::all();
        $data['categorys'] = Product_type::all();

        return view('BE.bills.import.add_bill_import',$data, compact('option','value'));
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
        $data['carts'] = Cart::instance('imports')->content();

        $data['sizes'] = Size::all();
        $data['colors'] = Color::all();
        $data['categorys'] = Product_type::all();

        return view('BE.bills.import.add_bill_import', $data, compact('key')); 
    }

    public function searchBill($key)
    {
        $data['imports'] = Bill::join('users', 'bills.user_id', '=', 'users.id')
                            ->where('type_bill', 3)
                            ->where(function ($query) use ($key) {
                                $query->where('bills.id_bill', 'like', '%'.$key.'%')
                                    ->orWhere('users.full_name', 'like', '%'.$key.'%');
                            })
                            ->orderBy('bills.id_bill', 'desc')
                            ->get();
        $data['users'] = User::All();

        return view('BE.bills.import.bill_import', $data, compact('key')); 
    }
}
