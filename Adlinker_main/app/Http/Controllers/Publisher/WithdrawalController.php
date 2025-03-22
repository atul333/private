<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
   

    public function create()
    {
        return view('publisher.withdrawals.create', [
            'message' => 'Withdraw Now'
        ]);
    }

  

    }
