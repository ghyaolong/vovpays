<?php

namespace App\Http\Admin\Controllers;

class RulesController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.Index.index');
    }
}
