<?php

namespace App\Http\Court\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\SystemsService;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addAccount(SystemsService $systemsService)
    {
        $type = $systemsService->findId(1);
        $type = json_decode($type);
        Cache::put($type->name, $type->value, 30);
    }
}
