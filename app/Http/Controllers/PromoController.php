<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $promoCodes = Promo::orderBy('id','desc')->get();
//dd($promoCodes->toArray());
        return view('admin.promo.index')
            ->with(['promoCodes' => $promoCodes]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());

        $msg = [
            'promo_value.required' => 'حقل قيمة الخصم مطلوب',
            'promo_value.numeric' => 'حقل قيمة الخصم رقمي',
        ];
        $rules = array(
            'promo_value' => 'required|numeric',

        );
        $validator = Validator::make($request->all(), $rules , $msg);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $new_promo = new Promo();
        $new_promo->code = rand(1000000,9999999);//str_random(8);
        $new_promo->value = $request->promo_value;

        if($new_promo->save())
            return redirect()->back()->with(['message' => 'تم اضافة كود الخصم']);
        else
            return redirect()->back()->with(['danger' => 'حدث خطأ في اضافة كود الخصم']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        //
        $promoCode = Promo::where('code' , $code)->where('status',1)->first(['code' , 'value']);

        if($promoCode)
            return response()->json(['promo' => $promoCode]);
        else
            return response()->json(['error'=> 'not found'],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id , $status)
    {
        //
        //dd($status);
        $promo = Promo::find($id);
//dd($promo->toArray());
        if($promo){
            $promo->status = $status;
            $promo->save();
        }

        return redirect('/admin/promo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
