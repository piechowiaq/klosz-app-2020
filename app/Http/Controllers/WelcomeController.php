<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;

use function view;

class WelcomeController extends Controller
{
    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        return view('welcome');
    }
}
