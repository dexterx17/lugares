@extends('layouts.app')

@section('title',trans('comun.categorias').' admin')

@section('content')
<div class="container body">
    <div class="main_container">
        <div class="right_col" role="main">
            <div class="">
                <div class="clearfix">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>
                                    {{ trans('comun.categorias') }}
                                    <small>
                                        {{ trans('comun.listado') }}
                                    </small>
                                </h2>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="x_content">
                                <!-- content starts here -->
                                <a class="btn btn-default btn-primary" href="{{ route('categorias.create') }}">
                                    {{ trans('comun.crear') }} {{ trans('comun.categoria') }}
                                </a>
                                <!-- start categorias list -->
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                {{ trans('comun.categoria') }}
                                            </th>
                                            <th>
                                                {{ trans('comun.lugares') }}
                                            </th>
                                            <th>
                                                {{ trans('comun.activo') }}

                                                <span class="badge"> </span>
                                            </th>
                                            <th class="text-right">
                                                {{ trans('comun.acciones') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorias_data as $index=>$categoria)
                                        <tr id="{{$categoria->categoria}}" data-categoria="{{$categoria->categoria}}">
                                            <td>
                                                <i class="fa fa-arrows movible">
                                                </i>
                                            </td>
                                            <td>
                                                <a>
                                                    <span class="badge">
                                                        {{ ($index+1) }}
                                                    </span>
                                                    {{ $categoria->nombre }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $categoria->lugares()->count() }}
                                            </td>
                                            <td>
                                                <input class="form-control col-md-7 col-xs-12 desactive-category" value="1" id="activa" name="activa" @if($categoria->activa) checked="checked" @endif type="checkbox">
                                                </input>
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-info btn-xs" href="{{ route('categorias.edit',$categoria->categoria)}}">
                                                    <i class="fa fa-pencil">
                                                    </i>
                                                    {{ trans('comun.editar') }}
                                                </a>
                                                <a class="btn btn-danger btn-xs delete-category" href="{{route('categorias.destroy',$categoria->categoria)}}">
                                                    <i class="fa fa-trash-o">
                                                    </i>
                                                    {{ trans('comun.eliminar') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- end categorias list -->
                                <!-- content ends here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/right-col-->
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){

        $('.desactive-category').on('click',function(e){
            //e.preventDefault();
            var id = $(this).parents('tr').data('categoria');
            var estado = $(this).is(':checked');
            var datos = {'_token': '{{ Session::token() }}'};
            if(estado)
                datos['activa']=estado;

            $.post("{{route('categorias.update','')}}/"+id,datos,function(response){

            },'json');
        });
        $('.delete-category').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            swal({
              title: "{{ trans('comun.estas_seguro') }}?",
              text: "{{ trans('comun.accion_no_se_deshace') }}",
              type: "warning",
              html:true,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{ trans('comun.eliminarlo') }}!",
              cancelButtonText: "{{ trans('comun.cancelar') }}",
              closeOnConfirm: false
            },
            function(){
                $.get(url,function(response){
                    if(response.categoria){
                        $('#'+response.categoria).fadeOut('slow');
                        swal("{{ trans('comun.eliminado') }}!", "{{ trans('comun.eliminado_ok') }}", "success");
                    }else{
                    }
                },'json');
            });
        });
        var orden = [];
        // Sortable rows
        var group = $('ul.to_do').sortable({
                group: 'nested',
                handle: 'i.fa-arrows',
                placeholder: '<tr class="placeholder"/>',
                serialize: function ($parent, $children, parentIsContainer) {
                    var result = $.extend({}, $parent.data());
                    if($parent.data('categoria'))
                        orden.push({'orden':($parent.index()+1),'categoria':$parent.data('categoria')});
                },
                onDrop: function ($item, container, _super) {
                    orden = [];
                    var data = group.sortable("serialize").get();
                    $.post('{{ route("categorias.reordenar") }}',{'info':orden,_token: '{{ Session::token() }}'},function(response){
                        console.log(response);
                        console.log('response');
                        if(!response.error){
                            new PNotify({
                                  title: '{{ trans("comun.accion_exitosa") }}',
                                  text: '{{ trans("comun.categorias_reordenadas") }}!',
                                  type: 'success',
                                  styling: 'bootstrap3'
                              });
                        }else{
                            new PNotify({
                                  title: 'Oh No!',
                                  text: '{{ trans("comun.ocurrio_error") }}',
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
                        }
                    });
                    _super($item, container);
                  }
            });
        });
</script>
@endsection
    