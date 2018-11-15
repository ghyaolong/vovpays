<?php

namespace App\Http\User\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $orders = $this->orderRepository->getList();
        return view('admin.user.order', compact('orders'));
    }

    public function index()
    {
        echo 12;
        exit;
        return view('home');
    }
}
