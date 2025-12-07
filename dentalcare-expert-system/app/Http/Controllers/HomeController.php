<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Jika user sudah login, redirect berdasarkan role
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect('/admin/dashboard');
            }
            return redirect('/diagnosis');
        }

        // Jika belum login, redirect ke halaman utama
        return redirect('/');
    }
}