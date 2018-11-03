<?php

namespace App\Http\Admin\Controllers;

use App\Services\MenuService;

class RulesController extends Controller
{

    protected $menuService;

    public function __construct( MenuService $menuService )
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $title = '权限管理';
        $description = '权限列表';

        $list = $this->menuService->getMenuList();
        return view('Admin.Rule.index',compact('title','description', 'list'));
    }
}
