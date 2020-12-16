<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Product_type;
use App\Models\Bill;
use App\Models\Bill_detail;
use DB;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.theme', function($view){
            $categorys = Product_type::where('status', 1)->get();
            $view->with('categorys',$categorys);
        });

        view()->composer('layouts.theme', function($view){
            if (Auth::check()) {
                $data['roles'] = DB::table('users')->where('id', Auth::user()->id)->first();
                $view->with($data);
            }else {
                $data['roles'] = DB::table('users')->first();
                $view->with($data);
            }
        });

        view()->composer('layouts.theme', function($view){
            $count_cart = Bill_detail::selectRaw('sum(qty) as count')
                                    ->join('bills', 'bill_details.id_bill', '=', 'bills.id_bill')
                                    ->where('bills.user_id', Auth::id())
                                    ->where('bills.type_bill', 0)
                                    ->first();
            $view->with('count_cart', $count_cart);
        });

        view()->composer('layouts.themeAdmin', function($view){
            $bill = Bill::select(Bill::raw('COUNT(status) as total_bill'))
                        ->where('status', 1)
                        ->first();
            $view->with('bill', $bill);
        });

        
        
        
    }
}
