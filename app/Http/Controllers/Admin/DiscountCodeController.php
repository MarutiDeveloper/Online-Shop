<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function index(Request $request)
    {
        $discountCoupons = DiscountCoupon::latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            // Check keyword in 'name', 'code', and 'discount_amount'
            $discountCoupons = $discountCoupons->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('code', 'like', '%' . $keyword . '%')
                    ->orWhere('discount_amount', 'like', '%' . $keyword . '%');
            });
        }

        $discountCoupons = $discountCoupons->paginate(10);
        return view('admin.coupon.list', compact('discountCoupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->passes()) {

            // Starting date must be greator than current date
            if (!empty($request->starts_at)) {
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if ($startAt->lte($now) == true) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at' => 'Start date can not be less than current date time']
                    ]);
                }
            }

            // Expiry date must be greator than start date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if ($expiresAt->gt($startAt) == false) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expiry date must be greator than start date and time']
                    ]);
                }
            }


            $discountCode = new DiscountCoupon();
            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->starts_at = $request->starts_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            $message = 'Discount Coupon addes Successfully';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $coupon = DiscountCoupon::findOrFail($id);

        if ($coupon == null) {
            session()->flash('error', 'Record not found....!');
           return redirect()->route('coupons.index');
        }

        $data['coupon'] = $coupon;
        return view('admin.coupon.edit', $data);
    }
    

    public function update(Request $request, $id)
    {
        
        $coupon = DiscountCoupon::findOrFail($id);

        if ($coupon == null) {
            $message = 'Record not found...!';
            session()->flash('error', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->passes()) {

            // Starting date must be greator than current date
            // if (!empty($request->starts_at)) {
            //     $now = Carbon::now();
            //     $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

            //     if ($startAt->lte($now) == true) {
            //         return response()->json([
            //             'status' => false,
            //             'errors' => ['starts_at' => 'Start date can not be less than current date time']
            //         ]);
            //     }
            // }

            // Expiry date must be greator than start date
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if ($expiresAt->gt($startAt) == false) {
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'Expiry date must be greator than start date and time']
                    ]);
                }
            }


            
            $coupon->code = $request->code;
            $coupon->name = $request->name;
            $coupon->description = $request->description;
            $coupon->max_uses = $request->max_uses;
            $coupon->max_uses_user = $request->max_uses_user;
            $coupon->type = $request->type;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->min_amount = $request->min_amount;
            $coupon->status = $request->status;
            $coupon->starts_at = $request->starts_at;
            $coupon->expires_at = $request->expires_at;
            $coupon->save();

            $message = 'Discount Coupon Updated Successfully';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request,$id)
    {
        $coupon = DiscountCoupon::findOrFail($id);

        if ($coupon == null) {
            $message = 'Record not found...!';
            session()->flash('error', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
        $coupon->delete();
        $message = 'Record Deleted Successfully...!';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
