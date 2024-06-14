<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('messages_debug.message', [
            'chatPreviews' => app('App\Http\Controllers\ChatController')->getChats($request),
            'messages' => app('App\Http\Controllers\ChatController')->getMessagesByUserID($request, 3),
        ]);
    }

//    /**
//     * Show the application dashboard.
//     *
//     * @return \Illuminate\Contracts\Support\Renderable
//     */
//    public function index()
//    {
//        return view('home');
//    }
}
