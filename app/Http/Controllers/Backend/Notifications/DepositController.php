<?php

namespace App\Http\Controllers\Backend\Notifications;

use App\Models\User;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DepositSuccessful;
use Illuminate\Support\Facades\Notification;

class DepositController extends Controller
{
    //
    //Only Authenticated users to make a deposit
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deposit(Request $request)
    {
        $deposit = Deposit::create([
            'user_id' => Auth::user()->id,
            'amount'  => $request->amount
        ]);
        User::find(Auth::user()->id)->notify(new DepositSuccessful($deposit->amount));

        //Notify facade
        // $users = User::all();

        // Notification::send($users, new DepositSuccessful($deposit->amount));

        return redirect()->back()->with('status', 'Your deposit was successful!');
    } // End

    //Mark as Read Method
    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
