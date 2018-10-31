<?php

namespace App\Http\Admin\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.Index.index');
    }

    public function main()
    {

        return view('admin.Index.main');
    }

    public function getMenu()
    {
        $id = Auth::guard('admin')->id();
        $res = (new Admin())->getMenu($id);
        return $res;
    }
}
