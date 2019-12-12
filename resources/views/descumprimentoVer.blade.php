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
                </ol>
                <!-- Final Breadcrump -->


                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab"
                                          aria-expanded="false">Descumprimento contratual</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Informações do descumprimento</h4>
                                    </div>
                                    <br>


                                    <form id='basicForm' name='basicForm' enctype="multipart/form-data" action='#' method="post" class='form-horizontal'>

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

                                            @if(session('isgestor') == 1 || session('isrh') == 1 )
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Responsável pelo cadastro</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_cadastro" id="ma_cadastro"  value="{{ $Descumprimento->ma_cadastro }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                                </div>
                                            </div>
                                            @endif

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
                                                        <option value=""></option> @foreach ($Coordenacoes as $Coordenacao) 
                                                        @if ($Descumprimento->id_impactada === $Coordenacao->id_coordenacao)
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

                                            <hr>

                                        </div>
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Análise interna - Minuta</h4>
                                            <br>
                                        </div>

                                        <br>
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
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Anexo da minuta: </label>
                                            <div class="col-sm-8" style='padding-top:12px;'>
                                                @if($Descumprimento->nome_anexo_rh)
                                                <a href='{{ url('../storage/uploads') }}/{{ $Descumprimento->nome_anexo_rh}}' target='_new'>{{ $Descumprimento->nome_anexo_rh}}</a>
                                                @else 
                                                Não existe arquivo anexado
                                                @endif 

                                            </div>
                                        </div>
                                        <hr>

                                        <div class="panel-heading">
                                            <h4 class="panel-title">Análise interna - Coordenação</h4>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Avaliação <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select disabled class="select2" id="bit_favoravel" name="bit_coordenacao" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo avaliação obrigatório!! Favor preencher!" required>
                                                    <option disabled></option>
                                                    <option value="1" <?php if ($Descumprimento->bit_favoravel == 1) echo 'selected'; ?>>Favorável prosseguir com o descumprimento</option>
                                                    <option value="0" <?php if ($Descumprimento->bit_favoravel == 0) echo 'selected'; ?>>Solicitar retificação da minuta</option>
                                                    <option value="2" <?php if ($Descumprimento->bit_favoravel == 2) echo 'selected'; ?>>Cancelar por determinação da Coordenação</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <!-- form-group -->
                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Informe sua avaliação</b></label>
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <textarea style="width: 90.7%;" name="ds_avacoordenacao"
                                                          id="ds_naoacatado" placeholder="Informe sua avaliação...Campo Obrigatório!!"
                                                          class="wtext" rows="9" disabled>{{ $Descumprimento->ds_avacoordenacao}}

                                                </textarea>
                                            </div>
                                        </div>
                                        <!-- form-group -->
                                        <hr>

                                        <div class="panel-heading">
                                            <h4 class="panel-title">Análise interna - Gerente</h4>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Avaliação <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select disabled class="select2" id="bit_favoravel" name="bit_gerente" style="width: 100%" data-placeholder="Informe sua decisão"  title="Campo avaliação obrigatório!! Favor preencher!" required>
                                                    <option disabled></option>
                                                    <option value="1" <?php if ($Descumprimento->bit_favoravel == 1) echo 'selected'; ?>>Favorável prosseguir com o descumprimento</option>
                                                    <option value="0" <?php if ($Descumprimento->bit_favoravel == 0) echo 'selected'; ?>>Solicitar retificação da minuta</option>
                                                    <option value="2" <?php if ($Descumprimento->bit_favoravel == 2) echo 'selected'; ?>>Cancelar por determinação da Coordenação</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <!-- form-group -->
                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Informe sua avaliação</b></label>
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <textarea style="width: 90.7%;" name="ds_avacoordenacao"
                                                          id="ds_naoacatado" placeholder="Informe sua avaliação...Campo Obrigatório!!"
                                                          class="wtext" rows="9" disabled>{{ $Descumprimento->ds_avagerente}}

                                                </textarea>
                                            </div>
                                        </div>
                                        <!-- form-group -->
                                        <hr>
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Análise interna - Ofício Final</h4>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Anexo Ofício: </label>
                                            <div class="col-sm-8" style='padding-top:12px;'>
                                                @if($Descumprimento->nome_anexo_rh)
                                                <a href='{{ url('../storage/uploads') }}/{{ $Descumprimento->nome_anexo_rh_oficio}}' target='_new'>{{ $Descumprimento->nome_anexo_rh_oficio}}</a>
                                                @else 
                                                Não existe arquivo anexado
                                                @endif 

                                            </div>
                                        </div>

                                        <hr>
                                        <!--Justificativa da terceirizada-->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Justificativa fornecida pelo prestador</h4>
                                            <br>
                                        </div>
                                        <!-- form-group 
                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Justificativa do descumprimento</b></label>
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <textarea style="width: 90.7%;" name="ds_justificativa" id="ds_justificativa" placeholder="Informe sua avaliação..." class="wtext" rows="12" disabled>{{ $Descumprimento->ds_justificativa }}</textarea>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Prestador</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="ma_justificativa" id="ma_justificativa"  value="{{ $Descumprimento->ma_justificativa }}" class="form-control" disabled/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Data da justificativa</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="dt_justificativa" id="dt_justificativa"  value="{{ $Descumprimento->dt_justificativa }}" class="form-control" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Anexo do ofício(Prestador): </label>
                                            <div class="col-sm-8" style='padding-top:12px;'>
                                                @if($Descumprimento->nome_anexo_empresa)
                                                <a href='{{ url('../storage/uploads') }}/{{ $Descumprimento->nome_anexo_empresa}}' target='_new'>{{ $Descumprimento->nome_anexo_empresa}}</a>
                                                @else 
                                                Não existe arquivo anexado
                                                @endif 

                                            </div>
                                        </div>

                                        <hr>

                                        <!--Justificativa da CAIXA!-->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Justificativa fornecida pela Caixa</h4>
                                            <br>
                                        </div>
                                        <!-- form-group -->
                                        <div class="form-group" id="campo_texto_avaliacao">
                                            <label class="col-sm-3 control-label"><b>Justificativa final da ocorrência: </b></label>                                           
                                            <div class="panel-body col-sm-9" style="margin-left: -10px">
                                                <span style="color:red; font-weight: bold; "><?php if($Descumprimento->status == 4 || $Descumprimento->status == 44) echo 'Descumprimento acatado'; if($Descumprimento->status == 5 || $Descumprimento->status == 55) echo 'Descumprimento não acatado';?></span>
                                                <br><br>
                                                <textarea style="width: 90.7%;" name="ds_reavaliacao" id="ds_justificativa" placeholder="Informe sua avaliação..." class="wtext" rows="12" disabled>{{ $Descumprimento->ds_reavaliacao }}</textarea>
                                            </div>
                                        </div>
                                        <!-- form-group -->

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Avaliador</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="ma_reavaliador" id="ma_justificativa"  value="{{ $Descumprimento->ma_reavaliador }}" class="form-control" disabled/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Data da justificativa</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="dt_reavaliacao" id="dt_justificativa"  value="{{ $Descumprimento->dt_reavaliacao }}" class="form-control" disabled/>
                                            </div>
                                        </div>

                                        <br><br>
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
