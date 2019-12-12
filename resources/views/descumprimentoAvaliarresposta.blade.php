@include('Default.head')

<body>
    @include('Default.header')
    <link rel="stylesheet" href="{{ asset("theme/lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.css") }}">


    <section>
        @include('Default.leftpanel')



        <div class="mainpanel">

            <div class="contentpanel">

                <!-- Breadcrump -->
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="#"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="#">Descumprimento contratual</a></li>
                    <li><a href="#">Avaliar resposta da empresa contratada</a></li>
                </ol>
                <!-- Final Breadcrump -->


                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab"
                                          aria-expanded="false">Avaliar resposta da empresa contratada</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                                    </div>
                                    <br>


                                    <form id='basicForm' name='basicForm' enctype="multipart/form-data" action='{{ url("descumprimento/incluirreavaliacao")}}' method="post" class='form-horizontal'>
                                        <input type="hidden" name="id_descumprimento" value="{{ $Descumprimento->id_descumprimento }}"> 
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                        <div class="error"></div>



                                        <div class="panel-body nopaddingtop">
                                            <hr>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Data de cadastro</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="created_at" id="created_at"  value="{{ $Descumprimento->created_at->format('d/m/Y H:i') }}" class="form-control" disabled/>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Responsável pelo cadastro</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_cadastro" id="ma_cadastro"  value="{{ $Descumprimento->ma_cadastro }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Contrato </label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_contrato" name="id_contrato" 
                                                            style="width: 100%"
                                                            data-placeholder="Selecione o contrato"
                                                            title="Você precisa selecionar um contrato" disabled>
                                                        @foreach ($Contratos as $Contrato)
                                                        @if ($Descumprimento->id_contrato === $Contrato->id_contrato)
                                                        <option value="{{ $Contrato->id_contrato }}" selected>{{ $Contrato->nu_contrato }}</option> 
                                                        @else
                                                        <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option> 
                                                        @endif
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <!-- form-group -->
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Coordenação impactada</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_impactada"
                                                            name="id_impactada" style="width: 100%"
                                                            data-placeholder="Selecione a coordenação impactada"
                                                            title="Você precisa selecionar a coordenação impactada"
                                                            disabled>
                                                        <option value=""></option> @foreach ($Coordenacoes as
                                                        $Coordenacao) @if ($Descumprimento->id_impactada === $Coordenacao->id_coordenacao)
                                                        <option value="{{ $Coordenacao->id_coordenacao }}"
                                                                selected>{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @else
                                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{$Coordenacao->ds_coordenacao }}</option> @endif
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 30px;">
                                                <label class="col-sm-3 control-label">Tipo</label>
                                                <label class="radio-inline " style="margin-left: 20px !important;">
                                                    @if($Descumprimento->tipo === 1)
                                                    <input type="radio" name="tipo" value="1" checked="checked" disabled>Advertência
                                                    @else
                                                    <input type="radio" name="tipo" value="1" disabled>Advertência
                                                    @endif
                                                </label>
                                                <label class="radio-inline">
                                                    @if($Descumprimento->tipo === 2)
                                                    <input type="radio" name="tipo" value="2" checked="checked" disabled>Multa
                                                    @else
                                                    <input type="radio" name="tipo" value="2" disabled>Multa
                                                    @endif
                                                </label>
                                            </div>

                                            <hr>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Título</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_titulo" id="ds_titulo" value="{{$Descumprimento->ds_titulo }}"
                                                           class="form-control"
                                                           title="Você precisa informar um resumo do ocorrido"
                                                           disabled />
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Descrição do
                                                    descumprimento </label>
                                                <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                    <textarea style="width: 90.7%;" name="ds_descumprimento"
                                                              id="ds_descumprimento"
                                                              placeholder="Preencha esse campo com a descrição do descumprimento contratual"
                                                              class="wtext" rows="22" disabled>{{ $Descumprimento->ds_descumprimento }}</textarea>
                                                </div>
                                            </div>
                                            <!-- form-group -->

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Arquivo anexo: </label>
                                                <div class="col-sm-8" style='padding-top:12px;'>
                                                    @if($Descumprimento->nome_anexo)
                                                    <a href='{{ url('../storage/uploads') }}/{{ $Descumprimento->nome_anexo}}' target='_new'>{{ $Descumprimento->nome_anexo}}</a>
                                                    @else 
                                                    Não existe arquivo anexado
                                                    @endif 

                                                </div>
                                            </div>
                                            <hr>

                                        </div>

                                        <div class="panel-heading">
                                            <h4 class="panel-title">Justificativa redigida pela empresa</h4>
                                            <br>
                                        </div>


                                        <br>

                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Justificativa</b></label>
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <textarea disabled style="width: 90.7%;" name="ds_avaliacao" id="ds_avaliacao" placeholder="Informe sua avaliação..." class="wtext" rows="12">{{ $Descumprimento->ds_justificativa }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Data de cadastro da justificativa</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="created_at" id="created_at"  value="{{ $Descumprimento->dt_justificativa }}" class="form-control" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Responsável pelo cadastro</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="ma_cadastro" id="ma_cadastro"  value="{{ $Descumprimento->ma_justificativa }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Arquivo anexo empresa: </label>
                                            <div class="col-sm-8" style='padding-top:12px;'>
                                                @if($Descumprimento->nome_anexo_empresa)
                                                <a href='{{ url('../storage/uploads') }}/{{ $Descumprimento->nome_anexo_empresa}}' target='_new'>{{ $Descumprimento->nome_anexo_empresa}}</a>
                                                @else 
                                                Não existe arquivo anexado
                                                @endif 

                                            </div>
                                        </div>
                                        <!-- form-group -->
                                        <br><br>
                                        <hr>



                                        <div class="panel-heading">
                                            <h4 class="panel-title">Por favor avalie a justificativa enviada pela empresa</h4>
                                            <br>
                                        </div>


                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Avaliação final<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="select2" id="bit_acatamento" name="bit_acatamento" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo Avaliação final Obrigatório!! Favor preencher!" required>
                                                    <option  disabled></option>
                                                    <option value="1">Acato a justificativa da empresa notificada</option>
                                                    <option value="0">Não Acato a justificativa da empresa notificada</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Justificativa</b></label>
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <textarea style="width: 90.7%;" name="ds_reavaliacao" id="ds_avaliacao" placeholder="Informe sua justificativa (opcional em casos de acatamento)..." class="wtext" rows="12"></textarea>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <br><br>

                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">

                                                <button type="submit"
                                                        class="btn btn-wide btn-primary btn-quirk mr5">Avaliar</button>


                                                <button type="button" onClick="history.back();"
                                                        class="btn btn-wide btn-default btn-quirk">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- panel-body -->
                            </div>
                            <!-- panel -->
                        </div>
                        <!-- col-md-6 -->
                    </div>
                </div>
                <!-- Final da tab -->
            </div>



        </div>
        <!-- contentpanel -->
    </div>
    <!-- mainpanel -->
</section>


@include('Default.endScripts')

<script src="{{ asset("theme/lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js") }}"></script>
<script src="{{ asset("theme/lib/wysihtml5x/wysihtml5x.js") }}"></script>
<script src="{{ asset("theme/lib/wysihtml5x/wysihtml5x-toolbar.js") }}"></script>


<script>
                                                    $(document).ready(function () {
                                                        'use strict';


// HTML5 WYSIWYG Editor
                                                        $('.wtext').wysihtml5({
                                                            toolbar: {
                                                                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                                                                "emphasis": true, //Italics, bold, etc. Default true
                                                                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                                                                "html": false, //Button which allows you to edit the generated HTML. Default false
                                                                "link": true, //Button to insert a link. Default true
                                                                "image": false, //Button to insert an image. Default true,
                                                                "color": false, //Button to change color of font  
                                                                "blockquote": true, //Blockquote  

                                                            }
                                                        });


                                                        $('.select2').select2();

// Error Message In One Container
                                                        $('#basicForm').validate({
                                                            errorLabelContainer: jQuery('#basicForm div.error')
                                                        });

                                                    });
</script>


</body>
<html></html>
