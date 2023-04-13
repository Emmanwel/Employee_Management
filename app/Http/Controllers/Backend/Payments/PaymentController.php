<?php

namespace App\Http\Controllers\Backend\Payments;

use Throwable;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\C2BMpesaRequests;
use App\Models\MpesaStkRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{


    //Payments fee view
    public function FeesPayments()
    {
        return view('backend.payments.mpesa.mpesa_view');
    } //End

    public function token()
    {

        //Guzzle autopopulates the headers
        // $client = new Client();
        // $response = $client->request('GET', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
        //     'auth' => [env('MPESA_CONSUMER_KEY'), env('MPESA_CONSUMER_SECRET')],
        // ]);

        // $body = json_decode($response->getBody());

        // return $body->access_token;

        $MPESA_CONSUMER_KEY = 'Hkq7uBM9TAK9GpIobIe4sCQBs7Fnz2gZ';
        $MPESA_CONSUMER_SECRET = 's9hpcVcf6B1ZO3l6';
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        // $response = Http::withBasicAuth([env('MPESA_CONSUMER_KEY'), env('MPESA_CONSUMER_SECRET')])->get($url);
        $response = Http::withBasicAuth($MPESA_CONSUMER_KEY, $MPESA_CONSUMER_SECRET)->get($url);

        $body = json_decode($response->getBody());

        return $body->access_token;

        // return $response;
    } // end

    public function initiateStkPush(Request $request)
    {

        //Mpesa Express

        if (isset($_POST['submit']))
            $accessToken = $this->token();
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $MPESA_PASSKEY = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $BusinessShortCode = '174379';
        $Timestamp = Carbon::now()->format('YmdHis');
        //$password = base64_encode(env('MPESA_SHORT_CODE') . env('MPESA_PASSKEY') . $timestamp);
        $password = base64_encode($BusinessShortCode . $MPESA_PASSKEY . $Timestamp);
        $TransactionType = 'CustomerPayBillOnline';
        // $Amount = 1;
        // $PartyA = 254704576324;
        $PartyA =  $_POST['phone_number'];
        $Amount = $_POST['amount'];
        $PartyB = 174379;

        // $phone =  $request->phone_number;
        // $formatedPhone = substr($phone, 1); //704576324
        // $code = "254";
        // $PhoneNumber = $code . $formatedPhone; //254704576324

        $PhoneNumber = '254704576324';
        $CallBackURL = 'https://224b-41-90-64-144.in.ngrok.io/payments/stkCallback';
        $AccountReference = 'Mukhebi';
        $TransactionDesc = 'School Fees Payment';
        $Remarks = "Thank you for paying!";



        try {
            // if (isset($_POST['submit']))

            $response = Http::withToken($accessToken)->post($url, [
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $password,
                'Timestamp' => $Timestamp,
                'TransactionType' => $TransactionType,
                'Amount' => $Amount,
                'PartyA' => $PartyA,
                'PartyB' => $PartyB,
                // 'PhoneNumber' => $PhoneNumber,
                'PhoneNumber' => $PartyA,
                'CallBackURL' => $CallBackURL,
                'AccountReference' => $AccountReference,
                'TransactionDesc' => $TransactionDesc,
                'Remarks' => $Remarks,
            ]);
        } catch (Throwable $e) {
            return $e->getMessage();
        }

        // return $response;

        $res = json_decode($response);
        $ResponseCode = $res->ResponseCode;


        if ($ResponseCode == 0) {
            $MerchantRequestID = $res->MerchantRequestID;
            $CheckoutRequestID = $res->CheckoutRequestID;
            $CustomerMessage = $res->CustomerMessage;

            //Custom Response
            $transactionDetails = $res->CustomerMessage;


            // SAVE RESPONSE TO DB - safaricom rqst has been sent from the server.

            $payment = new MpesaStkRequests();
            $payment->phone_number = $PartyA;
            $payment->amount = $Amount;
            $payment->reference = $AccountReference;
            $payment->description = $TransactionDesc;
            $payment->MerchantRequestID = $MerchantRequestID;
            $payment->CheckoutRequestID = $CheckoutRequestID;
            $payment->status = 'Requested';
            $payment->save();

            // return $response;


            // return $CustomerMessage;
            // return $Remarks;

            $notification = array(
                'message' => 'Payment Made Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('profile.view')->with($notification);
        } //End IF
    } //End

    public function stkCallback()
    {
        $data = file_get_contents('php://input');
        Storage::disk('local')->put('stk.txt', $data);

        $response = json_decode($data);

        // $TransactionID = $response->Body->stkCallback->TransactionID;
        $ResultCode = $response->Body->stkCallback->ResultCode;




        if ($ResultCode == 0) {
            $MerchantRequestID = $response->Body->stkCallBack->MerchantRequestID;
            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $TransactionDesc = $response->Body->stkCallback->TransactionDesc;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $Amount = $response->Body->stkCallback->CallbackMetadata->Item[0]->value;
            $MpesaReceiptNumber = $response->Body->stkCallback->CallbackMetadata->Item[1]->value;
            // $Balance = $request->Body->stkCallback->CallbackMetadata->Item[2]->value;
            $TransactionDate = $response->Body->stkCallback->CallbackMetadata->Item[3]->value;
            $PhoneNumber = $response->Body->stkCallback->CallbackMetadata->Item[4]->value;


            $payment = MpesaStkRequests::where('CheckoutRequestID', $CheckoutRequestID)->firstOrfail();

            $payment->status = 'Paid';
            $payment->TransactionDate = $TransactionDate;
            $payment->MpesaReceiptNumber = $MpesaReceiptNumber;
            $payment->ResultDesc = $ResultDesc;
            $payment->save();
        } else {
            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $payment = MpesaStkRequests::where('CheckoutRequestID', $CheckoutRequestID)->firstOrfail();

            $payment->ResultDesc = $ResultDesc;
            $payment->status = 'Failed';
            $payment->save();
        }
    } //End

    //STK QUERY METHOD

    public function stkQuery()
    {
        $accessToken = $this->token();
        $BusinessShortCode = 174379;
        $MPESA_PASSKEY = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $Timestamp = Carbon::now()->format('YmdHis');
        $Password = base64_encode($BusinessShortCode . $MPESA_PASSKEY . $Timestamp);

        $CheckoutRequestID = 'ws_CO_04042023144432994704576324';

        $response = Http::withToken($accessToken)->post($url, [

            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'CheckoutRequestID' => $CheckoutRequestID,

        ]);

        return $response;
    } // END

    //C2B Implementation

    public function registerUrl()
    {
        $accessToken = $this->token();
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $ShortCode = 600992;
        $ResponseType = 'Completed'; //Cancelled
        $ConfirmationURL = ' https://224b-41-90-64-144.in.ngrok.io/payments/confirmation';
        $ValidationURL = ' https://224b-41-90-64-144.in.ngrok.io/payments/validation';



        $response = Http::withToken($accessToken)->post($url, [

            'ShortCode' => $ShortCode,
            'ResponseType' => $ResponseType,
            'ConfirmationURL' => $ConfirmationURL,
            'ValidationURL' => $ValidationURL,

        ]);

        return $response;
    } //


    public function Simulate()

    
    {

        $accessToken = $this->token();
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
        $ShortCode = 600992;
        $CommandID = 'CustomerPayBillOnline'; //CustomerBuyGoodsOnline
        $Amount = 1;
        $Msisdn = 254708374149;
        $BillRefNumber = '00000';


        // Use Guzzle auth to autopoulate the headers
        $response = Http::withToken($accessToken)->post($url, [

            'ShortCode' => $ShortCode,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'Msisdn' => $Msisdn,
            'BillRefNumber' => $BillRefNumber,


        ]);

        return $response;
    }

    public function Validation()
    {
        $data = file_get_contents('php://input');
        Storage::disk('local')->put('validation.txt', $data);


        //Validation Logic
        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted'
        ]);

        // return response()->json([
        //     'ResultCode' => "C2B00011",
        //     'ResultDesc' => 'Rejected',
        // ]);
    } //End

    public function Confirmation()
    {
        $data = file_get_contents('php://input');
        Storage::disk('local')->put('confirmation.txt', $data);


        // Save transaction data to database)
        $response = json_decode($data);

        $TransactionType = $response->TransactionType;
        $TransID     = $response->TransID;
        $TransTime =  $response->TransTime;
        $TransAmount =        $response->TransAmount;
        $BusinessShortCode = $response->BusinessShortCode;
        $BillRefNumber =        $response->BillRefNumber;
        $InvoiceNumber =  $response->InvoiceNumber;
        $OrgAccountBalance =        $response->OrgAccountBalance;
        $ThirdPartyTransID = $response->ThirdPartyTransID;
        $MSISDN = $response->MSISDN;
        $FirstName =       $response->FirstName;
        $MiddleName = $response->MiddleName;
        $LastName =     $response->LastName;

        // Save transaction data to database

        $c2b = new C2BMpesaRequests;
        $c2b->TransactionType = $TransactionType;
        $c2b->TransID = $TransID;
        $c2b->TransTime = $TransTime;
        $c2b->TransAmount = $TransAmount;
        $c2b->BusinessShortCode = $BusinessShortCode;
        $c2b->BillRefNumber = $BillRefNumber;
        $c2b->InvoiceNumber = $InvoiceNumber;
        $c2b->OrgAccountBalance = $OrgAccountBalance;
        $c2b->ThirdPartyTransID = $ThirdPartyTransID;
        $c2b->MSISDN = $MSISDN;
        $c2b->FirstName = $FirstName;
        $c2b->MiddleName = $MiddleName;
        $c2b->LastName = $LastName;
        $c2b->save();
    } //End

    //Dynamics  QR Code - testing
    // public function QRCode()
    // {
    //     $consumerKey = \config('safaricom.consumer_key');
    //     $consumerSecret = \config('safaricom.consumer_secret');
    //     $authUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    //     //$authUrl= 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';


    //     //Use Guzzle to HTTP
    //     $request = Http::withBasicAuth($consumerKey, $consumerSecret)->get($authUrl);

    //     $accessToken = $request['access_token'];
    //     $MerchantName = 'Mahjing';
    //     $RefNo = 'ygg';
    //     $Amount = 1;
    //     $TrxCode = 'PB'; //BG-buy goods, WA-mpesa Agent, SM-send money, SB- send to business
    //     $CPI = 63737;

    //     $url = 'https://sandbox.safaricom.co.ke/mpesa/qrcode/v1/generate';


    //     $response = Http::withToken($accessToken)->post($url, [
    //         'MerchantName' => $MerchantName,
    //         'RefNo' => $RefNo,
    //         'Amount' => $Amount,
    //         'TrxCode' => $TrxCode,
    //         'CPI' => $CPI,

    //     ]);

    //     $data = $response['QRCode'];
    //     return view('backend.payments.view_qrcode')->with('QRCode', $data);
    // } //END METHOD


    //B2C Implementation
    //Method to initialize the transaction
    public function b2c()
    {

        $accessToken = $this->token();
        $initiatorName = 'testapi';
        $initiatorPassword = 'Safaricom999!*!';
        $path = Storage::disk('local')->get('SandboxCertificate.cer');
        $pk = openssl_pkey_get_public($path);

        openssl_public_encrypt(
            $initiatorPassword,
            $encrypted,
            $pk,
            $padding = OPENSSL_PKCS1_PADDING
        );


        //$encrypted
        $SecurityCredentials = base64_encode($encrypted);
        $CommandID = 'SalaryPayment'; ///BusinessPayment PromotionalPayment
        $Amount = 3000;
        $PartyA = 600997;
        $PartyB = 254708374149;
        $Remarks = 'remarks';
        $QueueTimeOutURL = ' https://224b-41-90-64-144.in.ngrok.io//payments/b2ctimeout';
        $ResultURL = ' https://224b-41-90-64-144.in.ngrok.io/payments/b2cresult';
        $Occassion = 'occassion';
        $url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

        //Use Guzzle to HTTP
        $response = Http::withToken($accessToken)->get($url, [
            'InitiatorName' => $initiatorName,
            'SecurityCredentials' => $SecurityCredentials,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB ' => $PartyB,
            'Remarks' =>  $Remarks,
            ' QueueTimeOutURL' => $QueueTimeOutURL,
            ' ResultURL' => $ResultURL,
            'Occassion' => $Occassion,

        ]);
        return $response;
    }

    //method to validate the requests check if the transactions is complete or not
    public function b2cResult()
    {

        $data = file_get_contents('php://input');
        Storage::disk('local')->put('b2cresponse.txt', $data);
    }

    //method to check timeout
    public function b2cTimeout()
    {
        $data = file_get_contents('php://input');
        Storage::disk('local')->put('b2ctimeout.txt', $data);
    }
}