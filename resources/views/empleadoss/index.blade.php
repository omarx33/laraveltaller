@extends('layouts.app') <!-- llama la carpeta "layouts" al archivo app.blade.php que trae el nav -->

@section('content')  <!-- se asocia a "yield('content')" -->



<div class="container-fluid">
<div class="row">
<div class="col-md-12">



    <button type="button" class="btn btn-primary btn-agregar"><i class="fa fa-plus"></i> Agregar</button>
    <br>  <br>
    <div class="table-responsive-md">
          <table class="table" id="consulta">
              <thead>
                    <th>Nombre</th>
                    <th>Posicion</th>
                    <th>oficio</th>
                    <th>edad</th>
                    <th>fecha</th>
                    <th>salario</th>
            <th>opciones</th>

              </thead>

          </table>

    </div>

</div>
</div>
</div>

{{-- modal agregar --}}
<form id="agregar" method="POST" autocomplete="off">

<div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="modal-body">
          {{--inicio del modal  --}}
          @csrf   {{-- <<---- token de seguridad debe contener para que funcione el ajax--}}

          <input type="hidden" name="id" class="id">
          <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" name="nombres" id="nombre" class="nombre form-control" required>

          </div>
          <div class="form-group">
            <label for="">Pocision</label>
            <input type="text" name="posicion" id="posicion" class="posicion form-control" required>

          </div>
          <div class="form-group">
            <label for="">Oficina</label>
            <input type="text" name="oficio" id="oficio" class="oficio form-control" required>

          </div>
          <div class="form-group">
            <label for="">Edad</label>
            <input type="number" name="edad" id="edad" class="edad form-control" required min="18">

          </div>

          <div class="form-group">
            <label for="">Fecha</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="fecha_inicio form-control" required>

          </div>
          <div class="form-group">
            <label for="">Salario</label>
            <input type="number" name="salario" id="salario" step="any" class="salario form-control" required>

          </div>

           {{-- fin modal --}}
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-submit"> Guardar</button>
        </div>
      </div>
    </div>
  </div>
</form>


{{--  --}}

<script>



function loadData(){

// funcion cargar data

    $(document).ready(function(){

     $('#consulta').DataTable({


        "language":{

            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"

},
iDisplayLength: 25, //cambiar la cantidad de filas a mostrar
        deferRender:true,
        bProcessing: true,//para que carge en paralelo se aga mas rapida
        bAutoWidth: false, //para que funcione el responsive
        destroy:true,
        ajax:{
            url:'{{ route('empleados.index')}}',
            type:'GET'
        },
        columns:[
         {data:'nombre'},
         {data:'posicion'},
         {data:'oficio'},
         {data:'edad'},
         {data:'fecha_inicio'},
         {data:'salario'},


       {data:null,render:function(data){


         return `

   			  <button
   			  data-id="${data.id}"
   			  class="btn btn-primary btn-sm btn-actualizar">
   			  <i class="fa fa-pencil"></i>
   			  </button>
   			  <button
   			   data-id="${data.id}"
   			  class="btn btn-danger btn-sm btn-eliminar">
   			  <i class="fa fa-trash"></i>
   			  </button>

   	 	  	 `;
          }}

        ]

    });

});

};

loadData();


//Cargar modal agregar
$(document).on('click','.btn-agregar',function(){

    $('.id').val('0');
    $('.btn-submit').html('Agregar');
    $('#agregar')[0].reset();
    $('.modal-title').html('Agregar');
    $('#modal-agregar').modal('show');

});

//agregar
$(document).on('submit','#agregar',function(e){


    parametros = $(this).serialize();



  $.ajax({

    url:'{{route('empleados.store')}}',
    type:'POST',
    data:parametros,
    dataType:'JSON',
    beforeSend:function(){


        Swal.fire({
title : "Cargando ... !",
text : "Espere",
showConfirmButton : false


             })


    },
    success:function(data){
        $('#modal-agregar').modal('hide');
        loadData();
             Swal.fire({
title : data.title,
text : data.text,
icon : data.icon,
timer : 3000,
showConfirmButton : false


             });






    }

  });

 e.preventDefault();


});



/* editar */

$(document).on('click','.btn-actualizar',function(){
    $('#agregar')[0].reset();
    $('.id').val('0');
    $('.btn-submit').html('Editar');
    id= $(this).data('id');
    url = '{{ route('empleados.edit',':id')}}';
    url = url.replace(':id',id); // reemplazando el id


     $.ajax({
        url:url,
        type:'GET',
        data:{},// ya no se pasa se manda por el route
        dataType:'JSON',
        success:function(e){
       $('.id').val(e.id);
       $('.nombre').val(e.nombre);
       $('.posicion').val(e.posicion);
       $('.oficio').val(e.oficio);
       $('.edad').val(e.edad);
       $('.fecha_inicio').val(e.fecha_inicio);
       $('.salario').val(e.salario);

        }

     });
 $('.modal-title').html('Actualizar');
 $('#modal-agregar').modal('show');

});

/* eliminar */
$(document).on('click','.btn-eliminar',function(){

    id= $(this).data('id');



    Swal.fire({
  title: '¿Estas seguro?',
  text: "Se eliminara el registro!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Sí, estoy seguro!',
  cancelButtonText : 'Cancelar'
}).then((result) => {
  if (result.isConfirmed) {

    url = '{{ route('empleados.destroy',':id')}}';
    url = url.replace(':id',id); // reemplazando el id



    $.ajax({

url:url,
type:'DELETE', //delete por el formulario de laravel pide para que valla al destroy
data:{'_token':'{{ csrf_token() }}'},
dataType:'JSON',
        beforeSend:function(){

            Swal.fire({
title : "Cargando ... !",
text : "Espere",
showConfirmButton : false


             });


        },


        success(data){
            loadData();

            Swal.fire({
title : data.title,
text : data.text,
icon : data.icon,
timer : 3000,
showConfirmButton : false


             });

        }



    })


  }
})






});

</script>

@endsection
