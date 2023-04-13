<?php

namespace App\Http\Controllers\Backend\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeesPaymentController extends Controller
{
    //
    public function FeesPayments()
    {
        return view('backend.payments.mpesa.mpesa_view');
    } //End
}
