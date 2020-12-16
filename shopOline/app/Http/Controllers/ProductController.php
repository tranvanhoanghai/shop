<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Product_type;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\Color;

use DB;


class ProductController extends Controller
{
    public function index()  # VIEW PRODUCT
    {
        $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                                    ->orderBy('products.id_product', 'desc')
                                    ->select('*','products.status')
                                    ->paginate(10);

        $data['stocks'] = DB::table('product_size_colors')
                            ->select('product_size_colors.id_product', DB::raw('SUM(product_size_colors.quantity) as stock'))
                            ->groupBy('product_size_colors.id_product')
                            ->get();

        $data['categorys'] = Product_type::All();
        return view('BE.products.product', $data);
    }

    public function view($id, $slug){ # VIEW DETAIL PRODUCT
        $data['products'] = Product::find($id);
        $data['images'] = DB::table('product_images')->get();
        $data['product_size_colors'] = DB::table('product_size_colors')
                                ->join('sizes', 'product_size_colors.id_size', '=', 'sizes.id_size')
                                ->join('colors', 'product_size_colors.id_color', '=', 'colors.id_color')
                                ->where('product_size_colors.id_product', $id)
                                ->orderBy('product_size_colors.id_size', 'asc')
                                ->get();
        $data['stocks'] = DB::table('product_size_colors')
                            ->select('product_size_colors.id_product', DB::raw('SUM(product_size_colors.quantity) as stock'))
                            ->where('id_product', $id)
                            ->groupBy('product_size_colors.id_product')
                            ->first();
        $data['sizes'] = Size::all();
        $data['colors'] = Color::all();
        $data['categorys'] = Product_type::all();
        
        return view('BE.products.detail_product' ,$data, compact('id', 'slug'));
    }
    public function viewCreateProduct()
    {
        $data['sizes'] = Size::all();
        $data['colors'] = Color::all();
        $data['categorys'] = Product_type::all();
        return view('BE.products.add_product', $data);
    }

    public function createProduct() # ADD PRODUCT
    {
        request()->validate([
            'createName'=>"unique:products,name_product",
            'filepath'=>"required"
        ],[
            'createName.unique'=>'Tên sản phẩm đã tồn tại',
            'filepath.required'=>'Ảnh sản phẩm không được trống và phải chọn 2 ảnh',
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
        $product->status   = request('status');

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
        return redirect('dashboard/products');
    }

    public function updateProduct($id)  # UPDATE PRODUCT
    { 
        request()->validate([
            'nameProduct'=>"unique:products,name_product,{$id},id_product",
        ],[
            'nameProduct.unique'=>'Tên sản phẩm đã tồn tại',
        ]);

        $product = Product::find($id);
        $product->name_product = request('nameProduct');
        $product->description = request('editor');
        $product->price0 = str_replace('.', '',request('price0'));
        $product->price1 = str_replace('.', '',request('price1'));
        $product->unit = request('unit'); 

        $image = explode(',',"".request('filepath')."");

        if(request('filepath') != null){
            if($product->img != null){
                request()->validate([
                    'filepath'=>'unique:product_images,image,'.$id,
                ],[
                    'filepath.unique'=>'Ảnh đã tồn tại',
                ]);
                
                foreach($image as $file)
                {
                    $product_image = new Product_image();
                    $product_image->id_product = $product->id_product;
                    $product_image->image = $file;
                    $product_image->save();
                };

            }else if($product->img == null){
                foreach($image as $file)
                {
                    $product_image = new Product_image();
                    $product_image->id_product = $product->id_product;
                    $product_image->image = $file;
                    $product_image->save();
                };
                $product->img = $image[0];
            };
        }

        if(request('size') !=null && request('color') !=null){ #size và color không trống
            DB::table('product_size_colors')->where('product_size_colors.id_product')->update(
                [
                    'id_product' => $id,
                    'id_size'    => request('size'),
                    'id_color'   => request('color'),
                    'quantity'   => request('addQty'),
                ]
            );
        }

        if(request('status') != null){
            $product->status = request('status');
        }

        if(request('type') != null){
            $product->id_product_type  = request('type');
        }

        $product->save();
        return back();
    }

    public function deleteProduct($id) # XOÁ SẢN PHẨM
    {
        Product::find($id)->delete();
        return redirect('dashboard/products');
    }

    // FILTER PRODUCT

    public function filterByCate($cate)
    {
        $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                ->where('product_types.name_product_type', $cate)
                ->orderBy('products.id_product', 'desc')
                ->paginate(10);

        $data['stocks'] = DB::table('product_size_colors')
                ->select('product_size_colors.id_product', DB::raw('SUM(product_size_colors.quantity) as stock'))
                ->groupBy('product_size_colors.id_product')
                ->get();

        $data['categorys'] = Product_type::All();
        
        return view('BE.products.product', $data, compact('cate'));
    }

    public function filterByStatus($status)
    {
        $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                ->where('products.status', $status)
                ->orderBy('products.id_product', 'desc')
                ->paginate(10);

        $data['stocks'] = DB::table('product_size_colors')
                ->select('product_size_colors.id_product', DB::raw('SUM(product_size_colors.quantity) as stock'))
                ->groupBy('product_size_colors.id_product')
                ->get();

        $data['categorys'] = Product_type::All();
        
        return view('BE.products.product', $data, compact('status'));
    }

    public function search($key) # SEARCH PRODUCT
    {
        $data['products'] = Product::join('product_types', 'products.id_product_type', '=', 'product_types.id_product_type')
                ->where('products.name_product', 'like', '%'.$key.'%')
                ->orWhere('products.id_product', 'like', '%'.$key.'%')
                ->orWhere('product_types.name_product_type', 'like', '%'.$key.'%')
                ->orderBy('products.id_product', 'desc')
                ->paginate(10);
        $data['stocks'] = DB::table('product_size_colors')
                ->select('product_size_colors.id_product', DB::raw('SUM(product_size_colors.quantity) as stock'))
                ->groupBy('product_size_colors.id_product')
                ->get();
        $data['categorys'] = Product_type::All();
        return view('BE.products.product', $data, compact('key'));
    } 


    public function deleteImg($id){ # XOÁ ẢNH PRODUCT
        DB::table('product_images')->where('id',$id)->delete();
        return back();
    }

    public function addProperty($id) # THÊM THUỘC TÍNH SẢN PHẨM SIZE-COLOR
    {
        $check = DB::table('product_size_colors')
                        ->where('id_product', $id)
                        ->where('id_size', request('size'))
                        ->where('id_color', request('color'))
                        ->first();
        if($check == null){
            DB::table('product_size_colors')->insert([
                [
                    'id_product' => $id,
                    'id_size'    => request('size'),
                    'id_color'   => request('color'),
                    'quantity'   => request('addQty'),
                ]
            ]);
            return back();
        }else{
            return back()->withErrors("Size và màu sắc đã có, bạn nên cập nhật lại số lượng");
        }
        
    }

    public function upQty($id, $id_s, $id_c)  # UPDATE SỐ LƯỢNG THEO ID PRODUCT SIZE COLOR
    {
        if($id != null && $id_s !=null && $id_c != null){
            DB::table('product_size_colors')->where('id_product', $id)->where('id_size', $id_s)->where('id_color', $id_c)->update([
                'quantity'   => request('upQty'),
            ]);
        }
        return back();
    }

    public function deleteProperty($id, $id_s, $id_c)  # XOÁ THUỘC TÍNH SẢN PHẨM
    {
        DB::table('product_size_colors')
                        ->where('id_product', $id)
                        ->where('id_size', $id_s)
                        ->where('id_color', $id_c)
                        ->delete();
        return back();

    }
}
