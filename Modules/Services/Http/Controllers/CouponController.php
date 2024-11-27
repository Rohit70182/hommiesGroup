<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\Coupon;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coupons = Coupon::get();
        return view('services::coupon.index', compact('coupons'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('services::coupon.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $validator = validator($request->all(), [
            'name' => 'required|unique:coupons,name',
            'desc' => 'required',
            'amount' => 'required|numeric|max:10000000|gt:0',
            'state_id' => 'required|integer',

        ]);
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $coupon = new Coupon();
        $coupon->name = $request->input('name');
        $coupon->desc = $request->input('desc');
        $coupon->amount = round($request->input('amount'), 2);
        $coupon->state_id = $request->input('state_id');

        if ($coupon->save()) {

            return redirect('services/coupon')->with('success', 'Coupon created succesfully');
        } else {
            return redirect('services/coupon')->with('error', 'Coupon not saved');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        return view('services::coupon.view', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        return view('services::coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::where('id', $id)->first();
        $validator = validator($request->all(), [
            "name" => 'required|unique:coupons,name,'.$id,
            'desc' => 'required',
            'amount' => 'required|numeric|max:10000000|gt:0',
            'state_id' => 'required|integer',               

        ]);
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        
        $coupon->name = $request->input('name');
        $coupon->desc = $request->input('desc');
        $coupon->amount = round($request->input('amount'), 2);
        $coupon->state_id = $request->input('state_id');
        if ($coupon->update()) {

            return redirect('services/coupon')->with('success', 'Coupon updated succesfully');
        } else {
            return redirect('services/coupon')->with('error', 'Coupon not saved');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        if (!empty($coupon)) {
            $coupon->delete();
            return redirect('services/coupon')->with('success', 'Coupon Deleted Successfully');
        }
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = Coupon::where('id', $id)->first();
            
            if($user->state_id == Coupon::STATE_INACTIVE)
            {
                $user->state_id = Coupon::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = Coupon::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with($e->getMessage());
        }
    }
    
    public function stateupdate($id, $st)
    {
        $coupon = Coupon::where('id', $id)->first();
        $coupon->state_id=$st;
        $coupon->update();
        return redirect()->back();
    }
    
    
}
