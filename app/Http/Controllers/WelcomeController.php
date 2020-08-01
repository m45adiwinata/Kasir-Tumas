<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stok;
use Auth;
use App\User;

class WelcomeController extends Controller
{
    public function index()
    {
    	if (!Auth::check()) {
    		return redirect('login');
    	}
        // $data['stoks'] = Stok::orderBy('nama_barang')->get();
        
        // return view('welcome', $data);
        return view('welcome');
    }

    public function login(Request $request)
    {
    	$user = User::where('username', $request->username)->first();
    	if ($user->password == md5($request->password)) {
    		Auth::login($user);

    		return redirect('/');
    	} else {
    		return redirect('login')->with('fail', 'Username dan Password tidak cocok.');
    	}
    	
    }
}
