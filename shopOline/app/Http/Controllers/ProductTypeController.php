<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Product_type;

use App\Imports\CategoryImport;
use App\Exports\CategoryExport;
use Excel;

class ProductTypeController extends Controller
{
    public function category()  # INDEX DANG MỤC SẢN PHẨM
    {
        $data['categorys'] = Product_type::get();
        return view('BE.products.category', $data);
    }

    public function addCategory()
    {
        request()->validate([
            'nameCate'=>"unique:product_types,name_product_type",
        ],[
            'nameCate.unique'=>'Tên danh mục đã tồn tại',
        ]);

        $cate = new Product_type;
        $cate->name_product_type = request('nameCate');
        $cate->status = request('statusCate');
        $cate->save();

        return back();
    }

    public function updateCategory($id)
    {
        request()->validate([
            'upNameCate'=>"unique:product_types,name_product_type,{$id},id_product_type",
        ],[
            'upNameCate.unique'=>'Tên danh mục đã tồn tại',
        ]);

        $cate =  Product_type::find($id);
        $cate->name_product_type = request('upNameCate');
        $cate->status = request('upStatusCate');
        $cate->save();
        return back();
    }

    public function deleteCategory($id)
    {
        try {
            Product_type::find($id)->delete();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Không thể xoá danh mục khi còn sản phẩm nằm trong danh mục đó. Bạn có thể ẩn danh mục đó đi');

        }
    }

    public function filterByStatusCate($status)
    {
        $data['categorys'] = Product_type::where('status', $status)->get();
        return view('BE.products.category', $data , compact('status'));
    }

    public function searchCate($key)
    {
        $data['categorys'] = Product_type::where('name_product_type','like', '%'.$key.'%')->orWhere('id_product_type','like', '%'.$key.'%')->get();
        return view('BE.products.category', $data , compact('key'));
    }

    public function import(Request $req)
    {
        $path = $req->file('file')->getRealPath();
        Excel::import(new CategoryImport, $path);
        return back();
    }

    public function export()
    {
        return Excel::download(new CategoryExport, 'category.xlsx');
    }
}
