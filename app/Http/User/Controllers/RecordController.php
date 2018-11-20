<?php

namespace App\Http\User\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $orders = Order::all();
        return view('Admin.User.record', compact('orders'));
    }

    public function index()
    {
        echo 12;
        exit;
        return view('home');
    }
}
