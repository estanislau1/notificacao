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
                    <li><a href="#">SLM</a></li>
                </ol>
                <!-- Final Breadcrump -->


                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab"
                                          aria-expanded="false">SLM</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Informações do SLM</h4>
                                    </div>
                                    <br>
                                    @if(count($errors) > 0)
                                    <div class="alert alert-danger" style="margin-top: 20px;">
                                        <ul>
                                            @foreach($errors->all() as $err)
                                            <li>{{$err}}</li>
                                            @endforeach
                                        </ul>

                                    </div>
                                    @endif
                                    <br>

                                    <form id='basicForm' name='basicForm' enctype="multipart/form-data" action='{{ url("slm/incluiravaliacao")}}' method="post" class='form-horizontal'>

                                        <input type="hidden" name="id_slm" value="{{ $Slm->id_slm }}"> 
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="error"></div>



                                        <div class="panel-body nopaddingtop">
                                            <hr>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Data de cadastro</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="created_at" id="created_at"  value="{{ $Slm->created_at->format('d/m/Y H:i') }}" class="form-control" disabled/>
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
                                                        @if ($Slm->id_contrato === $Contrato->id_contrato)
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
                                                <label class="col-sm-3 control-label">Coordenação</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_impactada"
                                                            name="id_impactada" style="width: 100%"
                                                            data-placeholder="Coordenação ainda não definida!"
                                                            title="Você precisa selecionar a coordenação impactada"
                                                            disabled>
                                                        <option value=""></option> @foreach ($Coordenacoes as $Coordenacao) 
                                                        @if ($Slm->id_coordenacao === $Coordenacao->id_coordenacao)
                                                        <option value="{{ $Coordenacao->id_coordenacao }}"
                                                                selected>{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @else
                                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{$Coordenacao->ds_coordenacao }}</option>
                                                        @endif
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Incidente</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_titulo" id="ds_titulo" value="{{$Slm->incidente }}" class="form-control" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">IC</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_titulo" id="ds_titulo" value="{{$Slm->ic }}" class="form-control" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Tempo decorrido</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_titulo" id="ds_titulo" value="{{$Slm->tempo }}" class="form-control" disabled />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Indicador Afetado</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="id_indicador" id="ds_titulo" value="<?php echo ($Slm->id_indicador == 8) ? 'IEPC005D - Resolver demais incidentes' : 'IEPC005P - Resolver incidentes prioritários'; ?>" class="form-control" disabled />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Sumário </label>
                                                <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                    <textarea style="width: 90.7%;" name="ds_slm"
                                                              id="ds_slm"
                                                              placeholder="Preencha esse campo com a descrição do slm contratual"
                                                              class="wtext" rows="4" disabled>{{ $Slm->sumario }}</textarea>
                                                </div>
                                            </div>
                                            <!-- form-group -->
                                            @if($Slm->status >= 2)
                                            <hr>
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Justificativa Preposto</h4>
                                                <br>
                                            </div>

                                            <br>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Equipe Alvo</b><span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select disabled class="select2" id="bit_acatamento" name="equipe" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                        <option  disabled></option>
                                                        <option value="1" <?php if ($Slm->equipe == 1) echo 'selected'; ?>>Equipe Dia</option>
                                                        <option value="2" <?php if ($Slm->equipe == 2) echo 'selected'; ?>>Equipe Noite</option>
                                                        <option value="3" <?php if ($Slm->equipe == 3) echo 'selected'; ?>>Equipe Madrugada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- form-group -->
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Justificativa</b><span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select disabled class="select2" id="bit_acatamento" name="bit_aceito_terceiro" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo Justificativa Obrigatório!! Favor preencher!" required>
                                                        <option  disabled></option>
                                                        <option value="1" <?php if ($Slm->bit_aceito_terceiro == 1) echo 'selected'; ?>>Concordo</option>
                                                        <option value="0" <?php if ($Slm->bit_aceito_terceiro == 0) echo 'selected'; ?>>Não Concordo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- form-group -->

                                            <div class="form-group" id="">
                                                <label class="col-sm-3 control-label"><b>Descrição da justificativa</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                    <textarea disabled style="width: 90.7%;" name="ds_terceiro" id="ds_avaliacao" placeholder="Informe sua justificativa" class="wtext" rows="12">{{$Slm->ds_terceiro}}</textarea>
                                                </div>
                                            </div>
                                            <!-- form-group -->
                                            @endif

                                            <hr>
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Justificativa Caixa</h4>
                                                <br>
                                            </div>

                                            <br>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Parecer</b><span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="bit_acatamento_c" name="bit_aceito_caixa" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo Justificativa Obrigatório!! Favor preencher!">

                                                        <option value=""></option>
                                                        <option value="1">Justificativa acatada</option>
                                                        <option value="0">Justificativa não acatada </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- form-group -->
                                            <div class="form-group" id="campo_texto_avaliacao_acat">
                                                <label class="col-sm-3 control-label"><b>Descrição da justificativa</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                    <textarea style="width: 90.7%;" name="ds_caixa" id="ds_avaliacao_obg" placeholder="Campo obrigatório! Em caso de acatamento, Preencher com 'Acatado.'" class="wtext" rows="12">{{old('ds_caixa')}}</textarea>
                                                </div>
                                            </div>


                                            <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-9 col-sm-offset-3">

                                                    <button type="submit"
                                                            class="btn btn-wide btn-primary btn-quirk mr5">Avaliar</button>


                                                    <button type="button" onClick="history.back();"
                                                            class="btn btn-wide btn-default btn-quirk">Cancelar</button>
                                                </div>
                                            </div>

                                    </form>
                                </div>	



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
