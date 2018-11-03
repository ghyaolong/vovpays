<?php

namespace App\Http\Admin\Controllers;

use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{

    public function index()
    {
        $title = '主页';
        $description = '';
        return view('Admin.Index.index', compact('title', 'description'));
    }

}
