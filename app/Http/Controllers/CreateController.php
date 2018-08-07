<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Product;
use DB;
use Auth;
use App\Images;
use App\Free_time;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Cookie\CookieJar;
class CreateController extends Controller
{
    public function __construct(CookieJar $cookieJar, Request $request)
    {
        $this->middleware('auth');
        $id = \Request::segment(6);
        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer, 45000));
        }

    }

    public function add_new_product(Request $request)
    {
        $product_images = [];

        $product = new Product();
        $product->id = input::get('id');
        $product->name = input::get('name');
        $product->cat_id = input::get('cat_id');
        $product->user_id = Auth::User()->id;
        $product->desc = input::get('desc');
        $product->gender = input::get('gender');
        if (Input::hasfile('pic')) {
            $extension = Input::file('pic')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $destinationPath = 'Product/';
            $url = asset('');
            $pic = input::file('pic')->move($destinationPath, $fileName);
            $product->img = $url . $pic;
        }
        $files = $request->file('img');
        foreach($files as $file){
                $extension_pic_pro = $file->getClientOriginalName();
                $fileName_pic_pro = rand(11111, 99999) . '.' . $extension_pic_pro;
                $destinationPath_pic_pro = 'Product/';
                $pic_pro = $file->move($destinationPath_pic_pro, $fileName_pic_pro);
                $url = asset('');

                $product_images[] = $url . $pic_pro;
            }
            $product->price = input::get('price');
            $product->prepration_time = input::get('prepration_time');
            $product->requirement = input::get('requirement');
            $product->max_num = input::get('max_num');
            if($product->save()){
                foreach ($product_images as $product_image ){
                    $product_image_model = new Images();
                    $product_image_model->product_id = $product->id;
                    $product_image_model->pic = $product_image;
                    $product_image_model->save();
                }

            }

            return Redirect::to("/product/view")
                ->with('message', "تم إضافة $product->name بنجاح");

    }

    public function product_edit($id)
    {
        $pro_dic = Product::find($id);

        $success = Input::get('success');

        if ($pro_dic ) {
            return view('admin.products.edit')
                ->with('success', $success)
                ->with('pro_dic', $pro_dic);
        } else {
            return View('admin.products.edit',['Product' => Product::findOrFail($id)])
                ->with('title', 'Error Page Not Found');
        }
    }

    protected function product_update(Request $request)
    {

        $ports = Product::find(Input::get('id'));
        if (Input::has('name')) {
            $ports->name = input::get('name');
        }
        if (Input::has('cat_id')) {
            $ports->cat_id = input::get('cat_id');
        }
      //  $ports->user_id = Auth::User()->id;
        if (Input::has('desc')) {
            $ports->desc = input::get('desc');
        }
        if (Input::has('pic')) {
            $extension = Input::file('pic')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $destinationPath = 'Product/';
            $url = asset('');
            $pic = input::file('pic')->move($destinationPath, $fileName);
            $ports->img = $url . $pic;
        }
        $filer = $request->file('img');
        if (Input::hasfile('img')) {
            foreach($filer as $file){
                $extension_pic_pro = $file->getClientOriginalName();
                $fileName_pic_pro = rand(11111, 99999) . '.' . $extension_pic_pro;
                $destinationPath_pic_pro = 'Product/';
                $pic_pros = $file->move($destinationPath_pic_pro, $fileName_pic_pro);
                $urls = asset('');
                $ports[] = $urls.$pic_pros;
            }
        }
        if (Input::has('price')) {
            $ports->price = input::get('price');
        }
        if (Input::has('is_product')) {
            $ports->is_product = input::get('is_product');
        }
        if (Input::has('prepration_time')) {
            $ports->prepration_time = input::get('prepration_time');
        }
        if (Input::has('gender')) {
            $ports->gender = input::get('gender');
        }
        if (Input::has('max_num')) {
            $ports->max_num = input::get('max_num');
        }

        if (Input::has('requirement')) {
            $ports->requirement = input::get('requirement');
        }
       $ports->save();
        return Redirect::to("product/view?success=$ports->id")
            ->with('message', "تم تعديل $ports->name بنجاح");

    }

    public function Del_Product($id) {

        $Product = Product::find($id);

        if ($Product) {
            Product::where('id', $id)->delete();
            return Redirect::to("/product/view?success=$Product->id")
                ->with('message', "تم حذف $Product->name بنجاح");

        } else {
            return view('notfound')->with('title', 'Error Page Not Found')->with('page', 'Error Page Not Found');
        }

    }



}
