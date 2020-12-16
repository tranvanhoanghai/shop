<?php
 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/home',    'HomeController@index');
Route::get('/',        'HomeController@index');
Route::get('/about',   'HomeController@about' );
Route::get('/contact', 'HomeController@contact'); 
Route::post('/contact','HomeController@contactPost'); 

Route::prefix('/shop')->group(function(){
    Route::get('/', 'ShopController@index'); 
    Route::post('/get/size', 'ShopController@size');   
    Route::post('/get/num', 'ShopController@stock');   
    Route::post('/search/{key}', 'ShopController@search');   
    Route::get('/search/{key}', 'ShopController@search');  
    Route::post('/filter', 'ShopController@filter');   
    Route::get('/filter', 'ShopController@filter');   
    Route::post('/sortBy/{sort}', 'ShopController@sort');   
    Route::get('/sortBy/{sort}', 'ShopController@sort');   
    Route::get('/{slug_product}', 'ShopController@item');   
});

Route::prefix('/category')->group(function(){
    Route::get('/{category}', 'ShopController@indexCate'); 
    Route::get('/{category}/{item}', 'ShopController@itemCate');     
});

Route::prefix('/cart')->group(function(){
    Route::get('/', 'CartController@index');  
    Route::post('/get/size/', 'CartController@index');   
    Route::post('/add/{id}', 'CartController@addCart');
    Route::post('/update/', 'CartController@upCart');
    Route::get('/delete/{id}', 'CartController@deCart');   
    Route::get('/de', 'CheckoutController@checkout');   
});

Route::prefix('/account')->group(function(){
    Route::get('/', 'UserController@indexAcc');      
    Route::post('/edit/{id}', 'UserController@editAcc'); 
    Route::post('/update/{id}', 'UserController@upAcc');                     
});

Route::prefix('/checkout')->middleware('auth')->group(function(){           
    Route::get('/', 'CheckOutController@index')->middleware('verified');       
    Route::post('/', 'CheckOutController@checkout');                     
    Route::post('/coupon', 'CheckOutController@checkCoupon'); 
});

Route::prefix('/dashboard')->middleware('can:login-dashboard','auth')->group(function(){

    Route::get('/', 'DashBoardController@index');                               #INDEX ADMIN DASHBOARD
    Route::get('/revenue', 'DashBoardController@revenue');                      #INDEX ADMIN DASHBOARD
    Route::get('/best', 'DashBoardController@bestSeller');                      #INDEX ADMIN DASHBOARD
    Route::get('/report/overview/{year}', 'DashBoardController@report');        #INDEX BÁO CÁO TỔNG QUAN
    Route::post('/report/overview/{year}', 'DashBoardController@report');       #INDEX BÁO CÁO TỔNG QUAN

    Route::prefix('/sales')->middleware('can:sale')->group(function(){ 
        Route::get('/', 'SalesController@index');  
        Route::post('/discount', 'SalesController@discount');                            
        Route::get('/discount', 'SalesController@discount');                            
        Route::get('/list', 'SalesController@list');                               
        Route::post('/add/{id}', 'SalesController@addCart');                           
        Route::post('/update/{id}', 'SalesController@updateCart');  
        Route::post('/checkout/', 'SalesController@checkout');    
        Route::post('/suggestions/', 'SalesController@suggestions');
        Route::post('/search={key}', 'SalesController@search'); 

        Route::get('/delete/{id}', 'SalesController@deleteCart');                            
        Route::get('/search={key}', 'SalesController@search'); 
        Route::get('/sort/{key}', 'SalesController@sort');                            
    });

    Route::prefix('/profile')->group(function(){ 
        Route::get('/', 'DashBoardController@indexProfile');                     #INDEX PROFILE 
        Route::post('/update/{id}', 'DashBoardController@updateProfile');        #UPDATE PROFILE 
    });

    Route::prefix('/staffs')->middleware('can:view-user')->group(function(){ 
        Route::get('/', 'DashBoardController@indexStaff');                     #INDEX
        Route::post('/search={key}', 'DashBoardController@searchStaff');        #SEARCH
        Route::get('/search={key}', 'DashBoardController@searchStaff');         #SEARCH
    });

    Route::prefix('/staffs')->middleware('can:act-user')->group(function(){ 
        Route::post('/add', 'DashBoardController@addStaff');            #EDIT
        Route::post('/edit/{id}', 'DashBoardController@editStaff');            #EDIT
        Route::post('/update/{id}', 'DashBoardController@updateStaff');        #UPDATE
        Route::post('/delete/{id}', 'DashBoardController@deleteStaff');        #DELETE
    });

    Route::prefix('/roles')->middleware('can:act-role')->group(function(){ 
        Route::get('/', 'DashBoardController@indexRole');                     # INDEX
        Route::get('/add', 'DashBoardController@viewAddRole');                # INDEX ADD
        Route::post('/add', 'DashBoardController@addRole');                   # ADD
        Route::get('/edit/{id}', 'DashBoardController@editRole');             # EDIT
        Route::post('/update/{id}', 'DashBoardController@updateRole');        # UPDATE
        Route::post('/delete/{id}', 'DashBoardController@deleteRole');        # DELETE
    });

    Route::prefix('/orders')->middleware('can:view-bill-order')->group(function(){    
        Route::get('/', 'BillOrderController@index');                                 # INDEX BILL
        Route::get('/detail/{id}/{id_user}', 'BillOrderController@view');                    # INDEX DETAIL BILL
        Route::post('/search={key}', 'BillOrderController@search');            # TÌM KIẾM
        Route::get('/search={key}', 'BillOrderController@search');             # TÌM KIẾM
        Route::post('/filter={status}', 'BillOrderController@filter');         # LỌC
        Route::get('/filter={status}', 'BillOrderController@filter');          # LỌC
    });

    Route::prefix('/orders')->middleware('can:act-bill-order')->group(function(){    
        Route::get('/create/', 'BillOrderController@createBillOrder');         # THÊM ĐƠN HÀNG
        Route::post('/add/', 'BillOrderController@addBillOrder');              # THÊM ĐƠN HÀNG
        Route::post('/create/add/{id}', 'BillOrderController@addCart');                           
        Route::post('/create/update/{id}', 'BillOrderController@updateCart');                          
        Route::get('/create/delete/{id}', 'BillOrderController@deleteCart'); 
        Route::post('/create/discount', 'BillOrderController@discount');                          
        Route::get('/create/discount', 'BillOrderController@discount'); 

        Route::post('/confirm/{id}', 'BillOrderController@confirm');           # XÁC NHẬN ĐƠN HÀNG
        Route::post('/cod/{id}', 'BillOrderController@cod');                   # XÁC NHẬN GIAO HÀNG
        Route::post('/pay/{id}', 'BillOrderController@pay');                   # XÁC NHẬN THANH TOÁN 
        Route::post('/cancel/{id}', 'BillOrderController@cancelInvoice');      # HUỶ BILL ORDER
        Route::post('/detail/upnote/{id}', 'BillOrderController@upNote');      # UPDATE GHI CHÚ
        Route::post('/create/search={key}', 'BillOrderController@searchProduct');     # LỌC
        Route::get('/create/search={key}', 'BillOrderController@searchProduct');      # LỌC
        Route::get('/create/sort/{key}', 'BillOrderController@sort');                 # LỌC
    });

    Route::prefix('/imports')->middleware('can:view-bill-import')->group(function(){    
        Route::get('/', 'BillImportController@index');                         # INDEX BILL IMPORT
        Route::get('/detail/{id}/{idUser}', 'BillImportController@view');      # INDEX BILL IMPORT

        Route::post('/create/search={key}', 'BillImportController@search');            # TÌM KIẾM
        Route::get('/create/search={key}', 'BillImportController@search');             # TÌM KIẾM
        
        Route::post('/search={key}', 'BillImportController@searchBill');            # TÌM KIẾM
        Route::get('/search={key}', 'BillImportController@searchBill');             # TÌM KIẾM
        
        Route::get('/create/sort/{key}', 'BillImportController@sort');                 # LỌC
    });

    Route::prefix('/imports')->middleware('can:act-bill-import')->group(function(){    
        Route::get('/create', 'BillImportController@create');                   # CREATED BILL IMPORT
        Route::post('/create/discount', 'BillImportController@discount');                          
        Route::get('/create/discount', 'BillImportController@discount'); 
        Route::post('/import', 'BillImportController@import');                  # ADD BILL IMPORT
        Route::post('/suggestions', 'BillImportController@suggestions');        # GỢI Ý TÌM NCC
        Route::post('/select/{id}', 'BillImportController@select');             # CHỌN SẢN PHẨM 
        Route::post('/addProduct', 'BillImportController@addProduct');          # ADD PRODUCT
        Route::post('/update/{id}','BillImportController@updateQty');           # UPDATE QTY
        Route::get('/delete/{id}','BillImportController@deleteCart');           # DELETE CART
    });

    Route::prefix('/retails')->middleware('can:sale')->group(function(){    
        Route::get('/', 'BillRetailController@index');                          # INDEX BILL BÁN LẺ
        Route::post('/search={key}', 'BillRetailController@search');            # SEARCH BILL BÁN LẺ
        Route::get('/search={key}', 'BillRetailController@search');             # SEARCH BILL BÁN LẺ
        Route::get('/detail/{id}/{idUser}', 'BillRetailController@view');       # SEARCH BILL BÁN LẺ
    });
  
    Route::prefix('customers')->middleware('can:view-user')->group(function(){
        Route::get('/', 'UserController@indexCustomer');                  #INDEX
        Route::post('/search={key}', 'UserController@searchCustomer');   #SEARCH    
        Route::get('/search={key}',  'UserController@searchCustomer');   #SEARCH
        Route::post('/edit/{id}',    'UserController@editCustomer');     #FIND ID UPDATE
    });

    Route::prefix('customers')->middleware('can:act-user')->group(function(){ 
        Route::post('/add',    'UserController@addCustomer');            # ADD
        Route::post('/update/{id}',  'UserController@updateCustomer');   #UPDATE
        Route::post('/delete/{id}',  'UserController@deleteCustomer');   #DELETE
    });

    Route::prefix('suppliers')->middleware('can:view-suppliers')->group(function(){ 
        Route::get('/', 'UserController@indexSupplier');                  #INDEX
        Route::post('/search={key}', 'UserController@searchSupplier');   #SEARCH    
        Route::get('/search={key}',  'UserController@searchSupplier');   #SEARCH
        Route::post('/edit/{id}',    'UserController@editSupplier');     #FIND ID UPDATE
    });

    Route::prefix('suppliers')->middleware('can:act-suppliers')->group(function(){ 
        Route::post('/add/',          'UserController@addSupplier');     //ADD
        Route::post('/update/{id}',  'UserController@updateSupplier');   #UPDATE
        Route::post('/delete/{id}',  'UserController@deleteSupplier');   #DELETE
    });

    Route::prefix('products')->middleware('can:view-product')->group(function(){
        Route::get('/', 'ProductController@index');                                 #INDEX PRODUCTS

        Route::post('/filter/category={cate}', 'ProductController@filterByCate');   #FILTER BY CATEGORY 
        Route::get('/filter/category={cate}', 'ProductController@filterByCate');    #FILTER BY CATEGORY 

        Route::post('/filter/status={status}', 'ProductController@filterByStatus'); #FILTER BY STATUS 
        Route::get('/filter/status={status}', 'ProductController@filterByStatus');  #FILTER BY STATUS 

        Route::post('/search={key}', 'ProductController@search');                    #SEARCH
        Route::get('/search={key}', 'ProductController@search');                     #SEARCH   

        Route::get('/{id}/{slug}', 'ProductController@view');                       #INDEX  DETAIL PRODUCTS
    });

    Route::prefix('products')->middleware('can:act-product')->group(function(){
    
        Route::get('/create', 'ProductController@viewCreateProduct');               // VIEW ADD   PRODUCTS
        Route::post('/create', 'ProductController@createProduct');                  //ADD   PRODUCTS
        Route::post('/update/{id}', 'ProductController@updateProduct');             #UPDATE DETAIL PRODUCTS
        Route::post('/delete/{id}', 'ProductController@deleteProduct');             #DELETE PRODUCT

        Route::post('/add/property/{id}', 'ProductController@addProperty');                          //ADD SIZE COLOR QTY
        Route::post('/update/property/{id}/{id_s}/{id_c}', 'ProductController@upQty');               #UPDATE QTY 
        Route::post('/delete/property/{id}/{id_s}/{id_c}', 'ProductController@deleteProperty');      #DELETE SIZE COLOR QTY
        Route::get('/delete/img/{id}', 'ProductController@deleteImg');                               #DELETE IMAGE
    });

    Route::prefix('categorys')->group(function(){
        Route::get('/', 'ProductTypeController@category')->middleware('can:view-category'); 
        Route::middleware('can:act-category')->group(function(){
            Route::post('/add', 'ProductTypeController@addCategory');                     
            Route::post('/edit/{id}', 'ProductTypeController@editCategory');                
            Route::post('/update/{id}', 'ProductTypeController@updateCategory');           
            Route::post('/delete/{id}', 'ProductTypeController@deleteCategory');            
    
            Route::post('/filter/status={status}', 'ProductTypeController@filterByStatusCate');
            Route::get('/filter/status={status}', 'ProductTypeController@filterByStatusCate');  
    
            Route::post('/search={key}', 'ProductTypeController@searchCate');              
            Route::get('/search={key}', 'ProductTypeController@searchCate');              
    
            Route::post('/import', 'ProductTypeController@import');               
            Route::post('/export', 'ProductTypeController@export');               
        });
    });

    Route::prefix('coupon')->group(function(){
        Route::get('/', 'CouponController@index')->middleware('can:view-coupon');   
        Route::middleware('can:act-coupon')->group(function(){
            Route::post('/add', 'CouponController@add');                             
            Route::post('/edit/{id}', 'CouponController@edit');                             
            Route::post('/update/{id}', 'CouponController@update');                             
            Route::post('/delete/{id}', 'CouponController@delete');                             
        });
    });

    Route::prefix('sliders')->group(function(){
        Route::get('/', 'SliderController@index')->middleware('can:view-slide');  
        Route::middleware('can:act-slide')->group(function(){
            Route::post('/add', 'SliderController@add');                             
            Route::post('/update/{id}', 'SliderController@update');                 
            Route::post('/delete/{id}', 'SliderController@deleteSlider');            
        });
    });

    Route::prefix('prices')->middleware('can:act-prices')->group(function(){       # THIẾT LẬP GIÁ
        Route::get('/', 'PriceController@indexPrice');                             #INDEX 
        Route::post('/update/{id}', 'PriceController@updatePrice');                #UPDATE 

        Route::post('/filter/category={cate}', 'PriceController@filterByCate');   #FILTER BY CATEGORY 
        Route::get('/filter/category={cate}', 'PriceController@filterByCate');    #FILTER BY CATEGORY 

        Route::post('/filter/status={status}', 'PriceController@filterByStatus'); #FILTER BY STATUS 
        Route::get('/filter/status={status}', 'PriceController@filterByStatus');  #FILTER BY STATUS 

        Route::post('/search={key}', 'PriceController@search');                    #SEARCH
        Route::get('/search={key}', 'PriceController@search');                     #SEARCH
    });

    Route::prefix('contacts')->group(function(){
        Route::get('/', 'DashBoardController@indexContact')->middleware('can:view-contact');                            
        Route::post('/delete/{id}', 'DashBoardController@deleteContact')->middleware('can:act-contact');                 
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () { 
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

