<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth; // se agrega para asociar a auth que almacena los datos de session

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

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $user = Auth::user();//->toArray();rescatar varialbles d session almacenadas en auth

      //dd($user->apellidos); o return $user para testear los valores;
//  return view('empleadoss.index');  //cambiar la ruta de inicio despues de loguearte
        return view('home');
    }
}
