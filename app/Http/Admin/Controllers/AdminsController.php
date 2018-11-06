<?php

namespace App\Http\Admin\Controllers;

use App\Repositories\AdminsRepository;
use Illuminate\Http\Request;

class AdminsController extends Controller
{

    protected $adminsRepository;

    public function __construct( AdminsRepository $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }

    public function index()
    {
        $title = '管理员管理';

        $list = $this->adminsRepository->getAdminsList();
        return view('Admin.Admins.index',compact('title', 'list'));
    }

}
