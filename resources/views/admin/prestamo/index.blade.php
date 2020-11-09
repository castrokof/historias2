@extends("theme.$theme.layout")

@section('titulo')
    Cliente
@endsection
@section("styles")
<link href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}" rel="stylesheet" type="text/css"/>

<style>
/* .dt-button {
  padding: 2px;
  border: true;
} */
</style>
@endsection


@section('scripts')
<!--<script src="{{asset("assets/pages/scripts/admin/prestamo/crear.js")}}" type="text/javascript"></script> -->   
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.form-error')
        @include('includes.form-mensaje')
     <br>   
    <div class="card card-success">
        <div class="card-header with-border">
          <h3 class="card-title">Prestamo</h3>
          <div class="card-tools pull-right">
            <button type="button" name="create_prestamo" id="create_prestamo" class="btn btn-default" data-toggle="modal" data-target="#modal-p"><i class="fa fa-fw fa-plus-circle"></i>Crear prestamo</button>
            </button>
          </div>
        </div>
      <div class="card-body table-responsive p-2">
        
      <table id="prestamo" class="table table-hover  text-nowrap">
        {{-- <table id="cliente" class="table table-striped table-bordered"> --}}
        <thead>
        <tr>  
              <th>Acciones</th>
              <th>id</th>
              <th>Monto</th>
              <th>Monto Pendiente</th>
              <th>Tipo de Pago</th>
              <th>Cuotas</th>
              <th>Cuotas Pendientes</th>
              <th>Interes</th>
              <th>Monto Total </th>
              <th>Valor Cuotas</th>
              <th>Fecha Inicial </th>
              <th>fecha Final</th>
              <th>Observación</th>
              <th>Estado</th>
              <th>Usuadio</th>
              <th>Cliente</th>
              <th>Fecha de Prestamo</th>
              
                           
        </tr>
        </thead>
        <tbody>
           
        </tbody>
      </table>
    </div>
  </form>
    <!-- /.card-body -->
</div>
</div>
</div>




  
<!-- /.Modal crear prestamo -->



<div class="modal fade" tabindex="-1" id ="modal-p"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
     
  <div class="row">
      <div class="col-lg-12">
        @include('includes.form-error')
        @include('includes.form-mensaje')
         <div class="card card-danger">
          <div class="card-header">
               <h6 class="modal-title-p"></h6>
            <div class="card-tools pull-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
                
              </div>   
                <span id="form_result"></span>
            </div>

        <form id="form-general" name="form-general" class="form-horizontal" method="post">
          @csrf
          <div class="card-body">
                        @include('admin.prestamo.form')
          </div>
          <!-- /.card-body -->
                       <div class="card-footer">
                          
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                            @include('includes.boton-form-crear-empresa-empleado-usuario')    
                        </div>
                         </div>
          <!-- /.card-footer -->
        </form>
                   
      
         
    </div>
  </div>
</div>
</div>
</div>



  


</div>



@endsection



@section("scriptsPlugins")
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}" type="text/javascript"></script>



<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script>
 
 $(document).ready(function(){

   //Calculo de monto total diario, semanal, quincenal y mensual al realizar cualqiuier cambio en los input

function monto(){
  
  if( $('#tipo_pago').val() == "Diario"){

    $('#monto_total').val(parseFloat($("#monto").val()) +
     parseFloat((($("#monto").val() * $("#interes").val()) * ($("#cuotas").val()/30))));

     $('#valor_cuota').val(Math.round( $('#monto_total').val()/$("#cuotas").val()));

    }else if( $('#tipo_pago').val() == "Mensual"){

      $('#monto_total').val(parseFloat($("#monto").val()) +
      parseFloat((($("#monto").val() * $("#interes").val()) * $("#cuotas").val())));

      $('#valor_cuota').val(Math.round( $('#monto_total').val()/$("#cuotas").val()));


    }else if( $('#tipo_pago').val() == "Quincenal"){

    $('#monto_total').val(parseFloat($("#monto").val()) +
    parseFloat((($("#monto").val() * $("#interes").val()) * ($("#cuotas").val()/2))));

    $('#valor_cuota').val(Math.round( $('#monto_total').val()/$("#cuotas").val()));


    }else if( $('#tipo_pago').val() == "Semanal"){

    $('#monto_total').val(parseFloat($("#monto").val()) +
    parseFloat((($("#monto").val() * $("#interes").val()) * ($("#cuotas").val()/4))));

    $('#valor_cuota').val(Math.round( $('#monto_total').val()/$("#cuotas").val()));


    }

    
}

 $("#cuotas").change(monto);
 $("#interes").change(monto); 
 $("#monto").change(monto);
 $("#tipo_pago").change(monto);

// funcion Cuota------------------------------------------------------------------------

function cuota(){

 if( $('#monto_total').val() > 0){

  }   
}

$("#interes").change(cuota);

//---------------------------------------------------
        //initiate dataTables plugin
      var datatable = 
        $('#prestamo')
        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
        .DataTable({
        language: idioma_espanol,
        processing: true,
        lengthMenu: [ [25, 50, 100, 500, -1 ], [25, 50, 100, 500, "Mostrar Todo"] ],
        processing: true,
        serverSide: true,
        aaSorting: [[ 1, "asc" ]],
        ajax:{
          url:"{{ route('prestamo')}}",
              },
        columns: [
          {data:'action',
           name:'action',
           orderable: false
          },
          {data:'id',
          name:'id'
          },
          {data:'monto',
          name:'monto'}
          ,
          {data:'monto_pendiente',
           name:'monto_pendiente'
          },
          {data:'tipo_pago',
          name:'tipo_pago'
          },
          {data:'cuotas',
          name:'cuotas'
          },
          {data:'cuotas_pendientes',
          name:'cuotas_pendientes'
          },
          {data:'interes',
          name:'interes'
          },
          {data:'monto_total',
          name:'monto_total'
          },
          {data:'valor_cuota',
          name:'valor_cuota'
          },
          {data:'fecha_inicial',
          name:'fecha_inicial'
          },
          {data:'fecha_final',
          name:'fecha_final'
          },
          {data:'observacion',
          name:'observacion'
          },
          {data:'activo',
          name:'activo'
          },
         
          {data:'usuario_id',
          name:'usuario_id'
          },
          {data:'cliente_id',
          name:'cliente_id'
          },
          {data:'created_at',
          name:'created_at'
          },
                   
        ],

         //Botones----------------------------------------------------------------------
         
         "dom":'<"row"<"col-xs-1 form-inline"><"col-md-4 form-inline"l><"col-md-5 form-inline"f><"col-md-3 form-inline"B>>rt<"row"<"col-md-8 form-inline"i> <"col-md-4 form-inline"p>>',
         

                   buttons: [
                      {
    
                   extend:'copyHtml5',
                   titleAttr: 'Copiar Registros',
                   title:"seguimiento",
                   className: "btn  btn-outline-primary btn-sm"
    
    
                      },
                      {
    
                   extend:'excelHtml5',
                   titleAttr: 'Exportar Excel',
                   title:"seguimiento",
                   className: "btn  btn-outline-success btn-sm"
    
    
                      },
                       {
    
                   extend:'csvHtml5',
                   titleAttr: 'Exportar csv',
                   className: "btn  btn-outline-warning btn-sm"
                   //text: '<i class="fas fa-file-excel"></i>'
                   
                      },
                      {
    
                   extend:'pdfHtml5',
                   titleAttr: 'Exportar pdf',
                   className: "btn  btn-outline-secondary btn-sm"
    
    
                      }
                   ],


        
    
        });



 //Crear prestamos

$(document).on('click', '.prestamo', function(){
    var id = $(this).attr('id');
    $('#cliente_id').val(id);
    $('.modal-title-p').text('Agregar prestamo');
    $('#action_button').val('Add');
    $('#action').val('Add');
    $('#modal-p').modal('show');
    

  $('#form-general').on('submit', function(event){
    event.preventDefault(); 
   
    if($('#action').val() == 'Add')
  {
    urlp = "{{route('guardar_prestamo')}}";
    methodp = 'post';
  }


    $.ajax({  
           url:urlp,
           method:methodp,
           data:$(this).serialize(),
           dataType:"json",
           success:function(data){
            if(data.success == 'ok') {
                      $('#form-general')[0].reset();
                      $('#modal-p').modal('hide');
                      $('#cliente').DataTable().ajax.reload();
                      Manteliviano.notificaciones('prestamo agregado correctamente', 'Sistema Ventas', 'success');
                      
                    }
  
     
     }

  });

  });

});


 

});


    
       

   var idioma_espanol =
                 {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
                }   
       
  </script>
   

@endsection

