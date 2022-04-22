<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function login()
    {
        return view('user.login');
    }

    public function register()
    {

    }

    public function auth()
    {
        $events = Event::all();

        return view('index', [
            'events' => $events,
        ]);
    }

}
