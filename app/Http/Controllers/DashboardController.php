<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // print_r(auth()->user()->role);die;
        return match (auth()->user()->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'member' => redirect()->route('member.dashboard'),

            default => abort(403),
        };
    }
}