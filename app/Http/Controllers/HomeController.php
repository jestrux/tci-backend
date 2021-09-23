<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PierMigration;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $users = PierMigration::browse("User");
        return view('home.index', compact('users'));
    }

    public function addUser()
    {
        $hobbies = PierMigration::browse("Hobby");
        return view('add-user', compact('hobbies'));
    }
}
