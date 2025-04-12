<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'داشبورد',
            'user' => $user,
            'counts' => [
                'persons' => 0, // فعلاً صفر می‌ذاریم تا مدل‌ها رو بسازیم
                'products' => 0,
                'sales' => 0,
                'purchases' => 0
            ]
        ];
        
        return view('home', $data);
    }
}