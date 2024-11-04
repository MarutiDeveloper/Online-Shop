<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\ShippingCharge;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create()
    {
        $countries = Country::get();
        $data['countries'] = $countries;

        $states = States::get();
        $data['states'] = $states;

        $city = City::get();
        $data['city'] = $city;
        //dd($city)

        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'countries.name')
        ->leftJoin('countries','countries.id', 'shipping_charges.country_id')->get();

        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'states.name')
        ->leftJoin('states','states.id', 'shipping_charges.state_id')->get();

        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'city.name')
        ->leftJoin('city','city.id', 'shipping_charges.city_id')->get();


        $data['shippingCharges'] = $shippingCharges;
        return view('admin.shipping.create', $data);
    }
    public function store(Request $request)
    {

       
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->passes()) {


            $count = ShippingCharge::where('country_id', $request->country)->count();
            if ($count > 0) {
    
                session()->flash('error', 'You have a Already Inserted a Data..!');
                return response()->json([
                    'status' => true
                ]);
            }
            $count = ShippingCharge::where('state_id', $request->country)->count();
            if ($count > 0) {
    
                session()->flash('error', 'You have a Already Inserted a Data..!');
                return response()->json([
                    'status' => true
                ]);
            }
            $count = ShippingCharge::where('city_id', $request->country)->count();
            if ($count > 0) {
    
                session()->flash('error', 'You have a Already Inserted a Data..!');
                return response()->json([
                    'status' => true
                ]);
            }
    
            $shipping = new ShippingCharge();
            $shipping->country_id = $request->country;
            $shipping->state_id = $request->state;
            $shipping->city_id = $request->city;
            $shipping->amount = $request->amount;
            $shipping->save();

            session()->flash('success', 'You have a Successfully Inserted a Data..!');
            return response()->json([
                'status' => true
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit ($id) {

        $shippingCharge = ShippingCharge::find($id);

        $countries = Country::get();
        $states = States::get();
        $city = City::get();
        $data['countries'] = $countries;
        $data['states'] = $states;
        $data['city'] = $city;
        $data['shippingCharge'] = $shippingCharge;
        
        return view('admin.shipping.edit',$data);
    }
    public function update($id,Request $request)
    {
        $shipping = ShippingCharge::find($id);
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'states' => 'required',
            'city' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->passes()) {

            if ($shipping == null) {
                session()->flash('error', 'Data Not found..!');
                return response()->json([
                    'status' => true
                ]);
            }

           
            $shipping->country_id = $request->country;
            $shipping->state_id = $request->states;
            $shipping->city_id = $request->city;
            $shipping->amount = $request->amount;
            $shipping->save();

            session()->flash('success', 'You have a Successfully Updated a Data..!');
            return response()->json([
                'status' => true
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy ($id) {
        $shippingCharge = ShippingCharge::find($id);

        if ($shippingCharge == null) {
            session()->flash('error', 'Data Not found..!');
            return response()->json([
                'status' => true
            ]);
        }

        $shippingCharge->delete();

        session()->flash('success', 'You have a Successfully Deleted a Data..!');
        return response()->json([
            'status' => true
        ]);
    }

}
