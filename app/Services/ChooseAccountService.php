<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class ChooseAccountService{

    public function __construct($select)
    {
        Redis::select($select);
    }

    public function getAccount()
    {

    }
}