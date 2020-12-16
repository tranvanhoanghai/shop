<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $data['sliders'] = Slider::orderBy('id_slider', 'desc')
                        ->get();
        return view('BE.web.slider', $data);
    }

 
    public function add()
    {
        request()->validate([
            'filepath'=>'unique:sliders,img',
        ],[
            'filepath.unique'=>'Ảnh đã tồn tại',
        ]);

        $image = explode(',',"".request('filepath')."");

        foreach($image as $img){
            $slider = new Slider();
            $slider->img = $img;
            $slider->status = 'true';
            $slider->save();
        }
        return back();
    }

    public function update($id)
    {
        request()->validate([
            'filepath1'=>"unique:sliders,img,{$id},id_slider",
        ],[
            'filepath1.unique'=>'Ảnh đã tồn tại',
        ]);
        $index = strpos(request('filepath1'), 'storage');
        
        if(request('filepath1') != null){
            $slider = Slider::find($id);
            $slider->img = substr(request('filepath1'),$index);
            $slider->link = request('link');
            $slider->content = request('content');
            $slider->status = request('status');
            $slider->save();
            return back();
        }else{
            $slider = Slider::find($id);
            $slider->link = request('link');
            $slider->content = request('content');
            $slider->status = request('status');
            $slider->save();
            return back();
        }
        
    }

    public function deleteSlider($id)
    {
        Slider::find($id)->delete(); 
        return back();
    }
}
