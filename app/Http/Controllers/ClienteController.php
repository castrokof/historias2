<?php

namespace App\Http\Controllers;

use App\Models\Admin\Cliente;
use App\Models\Admin\Empleado;
use App\Models\Seguridad\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
         $id_usuario = Session()->get('usuario_id');
         
         $usuarios = Usuario::orderBy('id')->where('id', '=', $id_usuario)->pluck('usuario', 'id')->toArray();
         
    
        if($request->ajax()){

            $datas = Cliente::where('usuario_id', '=', $id_usuario)->orderBy('usuario_id')->orderBy('consecutivo')->get();
            return  DataTables()->of($datas)
            // ->addColumn('editar', '<a href="{{url("cliente/$id/editar")}}" class="btn-accion-tabla tooltipsC" title="Editar este cliente">
            //       <i class="fa fa-fw fa-pencil-alt"></i>
            //     </a>')
            ->addColumn('action', function($datas){
          $button = '<button type="button" name="edit" id="'.$datas->id.'"
          class = "edit btn-float  bg-gradient-primary btn-sm tooltipsC"  title="Editar Cliente"><i class="far fa-edit"></i></button>';
          $button .='&nbsp;<button type="button" name="prestamo" id="'.$datas->id.'"
          class = "prestamo btn-float  bg-gradient-warning btn-sm tooltipsC" title="Agregar Prestamo"><i class="fa fa-fw fa-plus-circle"></i><i class="fas fa-money-bill-alt"></i></button>';
          $button .='&nbsp;<button type="button" name="detalle" id="'.$datas->id.'"
          class = "detalle btn-float  bg-gradient-success btn-sm tooltipsC" title="Detalle de Prestamos"><i class="fas fa-atlas"></i></i></button>';
          return $button;

            }) 
            ->rawColumns(['action'])
            ->make(true);
            }
        return view('admin.cliente.index', compact('usuarios', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $rules = array(
            'nombres'  => 'required|max:100',
            'apellidos'  => 'required|max:100',
            'documento' => 'numeric|required|min:10000|max:9999999999',
            'celular' => 'numeric|required|min:10000|max:9999999999',
            'tipo_documento' => 'required',
            'usuario_id' => 'required',
            'ciudad' => 'required',
            'pais' => 'required',
            'estado' => 'required',
            'direccion' => 'required',
            'consecutivo' => 'numeric|required|min:1|max:9999999999',
            'activo' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        Cliente::create($request->all());
            return response()->json(['success' => 'ok']);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    // public function editar($id)
    // {
    //         $id_usuario = Session()->get('usuario_id');
         
    //         $usuarios = Usuario::orderBy('id')->where('id', '=', $id_usuario)->pluck('usuario', 'id')->toArray();
            
    //         $data = Cliente::findOrFail($id);
      
       
    //     return view('admin.cliente.editar', compact('data','usuarios'));
    // }

    public function editar($id)
    {
        $id_usuario = Session()->get('usuario_id');
         
       $usuarios = Usuario::orderBy('id')->where('id', '=', $id_usuario)->pluck('usuario', 'id')->toArray();

        if(request()->ajax()){
        $data = Cliente::findOrFail($id);
            return response()->json(['result'=>$data]);

        }
        return view('admin.cliente.index', compact('usuarios'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        $rules = array(
            'nombres'  => 'required|max:100',
            'apellidos'  => 'required|max:100',
            'documento' => 'numeric|required|min:10000|max:9999999999',
            'celular' => 'numeric|required|min:10000|max:9999999999',
            'tipo_documento' => 'required',
            'usuario_id' => 'required',
            'ciudad' => 'required',
            'pais' => 'required',
            'estado' => 'required',
            'direccion' => 'required',
            'consecutivo' => 'numeric|required|min:1|max:9999999999',
            'activo' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return response()->json(['success' => 'ok1']);
            
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
    }
}
