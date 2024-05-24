<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

final class Controller
{
    public function __invoke(): JsonResponse
    {
        $user = DB::table('users')->where('name', 'Test User')->value('name');

        return new JsonResponse([
            'name' => $user,
        ]);
    }
}
