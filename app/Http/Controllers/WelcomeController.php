<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use function view;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
