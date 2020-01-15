<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\method_payment;
use DB;

class PaymentMethodController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function getPaymentByCustomerId($customer_id) {

        $paymethod_list = method_payment::where("customer_id",$customer_id)
                            ->select('id','payment_name','expense_moving','monthly_fees','living_room_type','area','details','deposit','other_use','rent','admin_expense',
                            'food_expense','nurse_care_surcharge','other_monthly_cost','refund_system','depreciation_period','initial_deprecration','other_message_refund')
                            ->get()
                            ->toArray();
        return $paymethod_list;
    }
}
