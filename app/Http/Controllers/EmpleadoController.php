<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado; /* importar el modelo */

use DB; /* PARA usar query builder */
use PhpParser\Node\Stmt\TryCatch;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */



    public function __construct()
    {
        $this->middleware('auth');  /*  validar sesion */
    }

    public function index(Request $request)
    {
       //consulta con eloquen
        /* if ($request->ajax() ) {

              $result = array( 'data'=>Empleado::all() );

             return $result;



        } */
// consulta con query builder
  try {

    if ($request->ajax() ) {

    $result = Empleado::select(DB::raw("

    id,nombre,posicion,oficio,edad,estado,DATE_FORMAT(fecha_inicio,'%d/%m/%Y')fecha_inicio,salario

    "))->get();

    return  array('data' => $result );

 }

return view("empleadoss.index");

  } catch (\Throwable $th) {
     return $th->getMessage();
  }




       /*   return view("empleadoss.index"); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) /* <- agregar estos valores "Request $request" */
    {
        // recuperar y ver datos recibidos "dd()"
        // dd($request->all()); ejemplo



       // Empleado::create([
       //  'nombre'=>$request->nombres,  /* <- izquierdo campos de la tabla, derecho de los inputs */
       //  "posicion" =>$request->posicion,
       //  "oficio" => $request->oficio,
       //  "edad" => $request->edad,
       //  "fecha_inicio" =>$request->fecha_inicio,
       //  "salario" => $request->salario
       // ]);
   try {

    Empleado::updateOrCreate(

        ['id'=>$request->id],//campo de verificacion si existe, el updateOrCreate crea o actualiza

        [
          'nombre'=>$request->nombres,  /* <- izquierdo campos de la tabla, derecho de los inputs */
          "posicion" =>$request->posicion,
          "oficio" => $request->oficio,
          "edad" => $request->edad,
          "fecha_inicio" =>$request->fecha_inicio,
          "salario" => $request->salario
         ]);


         $text = ( isset($request->id)) ? 'Registro Actualizado' : 'Registro agregado';

        return array(
           'title' => "Buen trabajo",
           'text' => $text,
           'icon' => "success"

        );



   } catch (\Throwable $th) {
    // return $th->getMessage();
     return array(

      'title' => 'Error',
      //'text'  => $th->getCode(),
      'text'  => $th->getMessage(),// para mostrar todo el error
      'icon' => 'error'

     );


   }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      $result = Empleado::where('id',$id)->first();
       return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Empleado::where('id',$id)->delete();

        return array(
            'title' => "Buen trabajo",
            'text' => "Registro eliminado",
            'icon' => "success"

         );
    }
}
