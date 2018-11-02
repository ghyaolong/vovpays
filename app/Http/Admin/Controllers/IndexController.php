<?php

namespace App\Http\Admin\Controllers;

use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

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
