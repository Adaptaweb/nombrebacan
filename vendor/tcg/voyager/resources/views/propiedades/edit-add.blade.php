@extends('voyager::master')

@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('voyager.propiedades.update', $dataTypeContent->id) }}@else{{ route('voyager.propiedades.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Detalles de la Propiedad

                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <label for="direccion">Descripción Breve:</label>
                            <input type="text" class="form-control" id="Breve" name="Breve" placeholder="Hasta 30 Carácteres" value="@if(isset($dataTypeContent->Breve)){{ $dataTypeContent->Breve }}@endif">
                        </div>
                            <div class="panel-body">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Opcional" value="@if(isset($dataTypeContent->direccion)){{ $dataTypeContent->direccion }}@endif">

                            </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Descripción</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>

                        <textarea class="form-control richTextBox" id="descrip" name="descrip" style="border:0px;">@if(isset($dataTypeContent->descrip)){{ $dataTypeContent->descrip }}@endif</textarea>
                    </div><!-- .panel -->



                </div>
                <div class="col-md-4">
                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Imagen Principal</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body ">
                            @if(isset($dataTypeContent->imgPrincipal))
                                <img class="img-thumbnail" src="{{ filter_var($dataTypeContent->imgPrincipal, FILTER_VALIDATE_URL) ? $dataTypeContent->imgPrincipal : Voyager::image( $dataTypeContent->imgPrincipal ) }}" style="width:40%; " />
                            @endif
                                <input type="file" name="imgPrincipal">

                        </div>
                    </div>

                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Características</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">

                                <div class="form-group ">
                                    <label for="name">Servicio</label>
                                    <select class="form-control" name="servicio">
                                        <option value="1" @if(isset($dataTypeContent->servicio) && $dataTypeContent->servicio == '1'){{ 'selected="selected"' }}@endif>Arriendo</option>
                                        <option value="2" @if(isset($dataTypeContent->servicio) && $dataTypeContent->servicio == '2'){{ 'selected="selected"' }}@endif>Venta</option>
                                        <option value="3" @if(isset($dataTypeContent->servicio) && $dataTypeContent->servicio == '3'){{ 'selected="selected"' }}@endif>Ambos</option>
                                    </select>
                                </div>
                                <div class="form-group ">

                                    <label for="name">Ciudad</label>
                                    <select class="form-control select2 select2-hidden-accessible" name="idCiudad" tabindex="-1" aria-hidden="true">
                                        @foreach(App\Ciudade::all() as $ciudad)
                                            <option value="{{ $ciudad->id}}" @if(isset($dataTypeContent->idCiudad) && $dataTypeContent->idCiudad ){{ 'selected="selected"' }}@endif>{{ $ciudad->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="venta">Valor Venta:</label>
                                    <input type="text" class="form-control" id="valorVenta" name="valorVenta" placeholder="Ejemplo :$300.000" value="@if(isset($dataTypeContent->valorVenta)){{ $dataTypeContent->valorVenta }}@endif">
                                </div>
                                <div class="form-group ">
                                    <label for="arriendo">Valor Arriendo:</label>
                                    <input type="text" class="form-control" id="valorArriendo" name="valorArriendo" placeholder="Ejemplo :$300.000" value="@if(isset($dataTypeContent->valorArriendo)){{ $dataTypeContent->valorArriendo }}@endif">
                                </div>
                                <div class="form-group ">
                                    <label for="pisos">Pisos</label>
                                    <select class="form-control" name="pisos">
                                        <option value="1" @if(isset($dataTypeContent->pisos) && $dataTypeContent->pisos == '1'){{ 'selected="selected"' }}@endif>1</option>
                                        <option value="2" @if(isset($dataTypeContent->pisos) && $dataTypeContent->pisos == '2'){{ 'selected="selected"' }}@endif>2</option>
                                        <option value="3" @if(isset($dataTypeContent->pisos) && $dataTypeContent->pisos == '3'){{ 'selected="selected"' }}@endif>3</option>
                                        <option value="4" @if(isset($dataTypeContent->pisos) && $dataTypeContent->pisos == '4'){{ 'selected="selected"' }}@endif>4</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="visible">Visible</label>
                                    <input type="checkbox" name="visible" @if(isset($dataTypeContent->visible) && $dataTypeContent->visible){{ 'checked="checked"' }}@endif>
                                </div>
                                <div class="form-group">
                                    <label for="destacada">destacada</label>
                                    <input class="toggleswitch" type="checkbox" name="destacada" @if(isset($dataTypeContent->destacada) && $dataTypeContent->destacada){{ 'checked="checked"' }}@endif>
                                </div>

                                <div class="form-group">
                                    <label for="gastosComunes">Gastos Comunes</label>
                                    <input type="checkbox" name="gastosComunes" @if(isset($dataTypeContent->gastosComunes) && $dataTypeContent->gastosComunes){{ 'checked="checked"' }}@endif>
                                </div>
                                <div class="form-group">
                                    <label for="negociable">Negociable</label>
                                    <input type="checkbox" name="negociable" @if(isset($dataTypeContent->negociable) && $dataTypeContent->negociable){{ 'checked="checked"' }}@endif>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <!-- ### Fotografias ### -->
            <div class="panel panel panel-bordered panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="icon wb-book"></i> Fotografías</h3>
                    <div class="panel-actions">
                        <a class="panel-action" ></a>
                    </div>
                </div>
                <div class="panel-body ">
                    <input type="file" name="fotos" multiple>

                </div>


            </div><!-- .panel -->

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id))Modificar @else <i class="icon wb-plus-circle"></i> Grabar @endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

        @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
        @endif
        });
    </script>
@stop
