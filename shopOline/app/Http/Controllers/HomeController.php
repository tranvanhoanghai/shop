<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\User_type;
use App\Models\Product;
use App\Models\Product_type;
use App\Models\Product_image;
use App\Models\Bill;
use App\Models\Bill_detail;
use App\Models\Slider;
use App\Models\Contact;
 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 
    public function index(){

        $data['sliders']=Slider::where('status','true')->orderBy('id_slider', 'desc')->get();;

        $data['best_sellers'] = Bill_detail::join('products', 'bill_details.id_product', '=', 'products.id_product')
        ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
        ->select('bill_details.id_product', 'products.name_product', 'products.price1', 'products.slug_product',Product::raw('SUM(qty) as total_qty'))
        ->where('type_bill', '<>', 3)
        ->where('bills.status', 4)
        ->groupBy('bill_details.id_product', 'products.name_product','products.price1', 'products.slug_product')
        ->orderBy('total_qty', 'desc')
        ->limit(10)->get();

        $data['image'] = Product_image::All();
        $data['new_product'] = Product::where('status', 'true')->orderBy('id_product', 'desc')->take(10)->get();


        visits('App\Models\Slider')->increment();

        return view('FE.index', $data);

    }

    public function about()
    {
        return view('FE.about');
    }

    public function contact()
    {
        return view('FE.contact');
    }

    public function contactPost()
    {
        request()->validate([
            'contactEmail'=>"unique:contacts,email",
        ],[
            'contactEmail.unique'=>'Bạn đã gửi ý kiến rồi, hiện không gửi lại được',
        ]);

        $contact = new Contact();
        $contact->name = request('contactName');
        $contact->email = request('contactEmail'); 
        $contact->phone = request('contactPhone'); 
        $contact->content = request('contactContent'); 
        $contact->save();
        return back()->with('success', 'Gửi thành công , cảm ơn bạn đã đóng góp ý kiến');
    }

}
