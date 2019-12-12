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
                    <li><a href="#">Notificação</a></li>
                    <li><a href="#">Informações</a></li>
                </ol>
                <!-- Final Breadcrump --> 


                <!-- ABAS DA TAB -->  
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab"
                                          aria-expanded="false">Verificar informações da Notificação</a></li>
                </ul>
                <!--Final da ABAS DA TAB --> 


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Notificação - {{ $Notificacao->nu_notificacao }}  </h4>
                                    </div>
                                    <br>
                                    <div class="panel-body nopaddingtop">
                                        <form id='basicForm' name='basicForm' action='{{ url("notificacao/incluiravaliacao/")}}' method="post" class='form-horizontal'>
                                            <input type="hidden" name="id_notificacao" value="{{ $Notificacao->id_notificacao }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="error"></div>




                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Coordenação Notificadora</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_notificadora" name="id_notificadora" style="width: 100%" data-placeholder="Selecione a coordenação notificadora" title="Você precisa selecionar a coordenação notificadora" disabled>
                                                        <option value=""></option>
                                                        @foreach ($Coordenacoes as $Coordenacao)
                                                        @if ($Notificacao->id_notificadora === $Coordenacao->id_coordenacao)
                                                        <option value="{{ $Coordenacao->id_coordenacao }}" selected>{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @else 
                                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @endif
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Coordenação impactada</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_impactada" name="id_impactada" style="width: 100%" data-placeholder="Selecione a coordenação impactada" title="Você precisa selecionar a coordenação impactada" disabled>
                                                        <option value=""></option>
                                                        @foreach ($Coordenacoes as $Coordenacao)
                                                        @if ($Notificacao->id_impactada === $Coordenacao->id_coordenacao)
                                                        <option value="{{ $Coordenacao->id_coordenacao }}" selected>{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @else 
                                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @endif
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->
                                             @if(Session::get('isgestor') == 1)
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" id="lb_ocorrencia">Matrícula do solicitante</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_cadastro" id="ds_ocorrencia"  value="{{ $Notificacao->ma_cadastro }}" class="form-control" title="Informe o nome do contexto" disabled/>

                                                </div>
                                            </div>
                                             @endif


                                            <hr>




                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Contrato</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_contrato" name="id_contrato" style="width: 100%" disabled>
                                                        <option value=""></option>
                                                        @foreach ($Contratos as $Contrato)
                                                        @if ($Notificacao->id_contrato === $Contrato->id_contrato)
                                                        <option value="{{ $Contrato->id_contrato }}" selected>{{ $Contrato->nu_contrato }}</option>
                                                        @else 
                                                        <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option>
                                                        @endif
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Indicador afetado</label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_indicador" name="id_indicador" style="width: 100%" disabled>
                                                        <option value=""></option>

                                                        @foreach ($Indicadores as $indicador)
                                                        @if ($Notificacao->id_indicador === $indicador->id_indicador)
                                                        <option value="{{ $indicador->id_indicador }}" selected>{{ $indicador->no_indicador }}</option>
                                                        @else 
                                                        <option value="{{ $indicador->id_indicador }}">{{ $indicador->no_indicador }}</option>
                                                        @endif
                                                        @endforeach    
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" id="lb_ocorrencia">Nº da ocorrência</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_ocorrencia" id="ds_ocorrencia"  value="{{ $Notificacao->ds_ocorrencia }}" class="form-control" title="Informe o nome do contexto" disabled/>

                                                </div>
                                            </div>




                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Descrição da ocorrência </label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" class="wtext" name="ds_ticket" id="ds_ticket" placeholder="descrição do ticket..." class="form-control" rows="10" disabled>{{ $Notificacao->ds_ticket }}</textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <hr>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Motivos da notificação</label>
                                                <div class="col-sm-8">
                                                    @foreach ($Motivos as $motivo)
                                                    <input name="id_motivo[]" type="radio" value="{{ $motivo->id_motivo }}"

                                                           @if ($motivo->id_motivo === $NotificacaoMotivo[0]->id_motivo) 
                                                           checked
                                                           @endif
                                                           disabled> {{ $motivo->no_motivo }} <br>
                                                    @endforeach
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Descrição da notificação</label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" id="ds_notificacao" name="ds_notificacao" class="wtext" placeholder="descrição da notificação..." class="form-control" rows="18" disabled>{{ $Notificacao->ds_notificacao }}</textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <hr>








                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" id="lb_duracao">Duração da inconformidade (em horas):</label>
                                                <div class="col-sm-1">
                                                    <input type="text" name="nu_horas" id="nu_horas" value="{{ $Notificacao->nu_horas }}" class="form-control" disabled />
                                                </div>
                                            </div>


                                            <hr>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Arquivo anexo:</label>
                                                <div class="col-sm-4" style='padding-top:12px;'>
                                                    @if($Notificacao->nome_anexo)
                                                    <a href='{{ url('../storage/uploads') }}/{{ $Notificacao->nome_anexo}}' target='_new'>{{ $Notificacao->nome_anexo}}</a>
                                                    @else 
                                                    Não existe arquivo anexado
                                                    @endif 
                                                </div>
                                            </div>


                                            <hr>


                                            <div class="panel-heading nopaddingbottom">
                                                <h4 class="panel-title">Autorização da notificação</h4>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Negativa da autorização</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" name="ds_naoautorizado" id="ds_naoautorizado"  class="wtext"  placeholder="descrição da negativa de autorização..." class="form-control" rows="9" disabled>{{ $Notificacao->ds_naoautorizado }}</textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Data da autorização</label>
                                                <div class="col-sm-8">
                                                    @if($Notificacao->dt_autorizacao)
                                                    <input type="text" name="dt_autorizacao" id="dt_autorizacao"  value="{{ Carbon\Carbon::parse($Notificacao->dt_autorizacao)->format('d/m/Y H:i') }}" class="form-control" disabled/>
                                                    @else 
                                                    <input type="text" name="dt_autorizacao" id="dt_autorizacao"  value="" class="form-control" disabled/>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Responsável pela autorização</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_autorizador" id="ma_autorizador"  value="{{ $Notificacao->ma_autorizador }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                                </div>
                                            </div>



                                            @if($Notificacao->bit_aceito <> 9 )



                                            <hr>




                                            <div class="panel-heading nopaddingbottom">
                                                <h4 class="panel-title">Verifique a justificativa informada</h4>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Justificativa</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" name="ds_justificativa" id="ds_justificativa"  class="wtext"  placeholder="descrição da justificativa..." class="form-control" rows="9" disabled>{{ $Notificacao->ds_justificativa }}</textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Data da justificativa</label>
                                                <div class="col-sm-8">
                                                    @if($Notificacao->dt_justificativa)
                                                    <input type="text" name="dt_justificativa" id="dt_justificativa"  value="{{ Carbon\Carbon::parse($Notificacao->dt_justificativa)->format('d/m/Y H:i') }}" class="form-control" disabled/>
                                                    @else 
                                                    <input type="text" name="dt_justificativa" id="dt_justificativa"  value="" class="form-control" disabled/>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Responsável pela justificativa</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_justificativa" id="ma_justificativa"  value="{{ $Notificacao->ma_justificativa }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                                </div>
                                            </div>





                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Arquivo anexo:</label>
                                                <div class="col-sm-4" style='padding-top:12px;'>
                                                    @if($Notificacao->justificativa_anexo)
                                                    <a href='{{ url('../storage/uploads') }}/{{ $Notificacao->justificativa_anexo}}' target='_new'>{{ $Notificacao->justificativa_anexo}}</a>
                                                    @else 
                                                    Não existe arquivo anexado
                                                    @endif 
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="panel-heading nopaddingbottom">
                                                <h4 class="panel-title">Verifique a avaliação informada</h4>
                                                <br>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Avaliação - Não acatada</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" name="ds_naoacatado" id="ds_naoacatado"  class="wtext"  rows="9" disabled>{{ $Notificacao->ds_naoacatado }}</textarea>
                                                </div>
                                            </div><!-- form-group -->
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><b>Avaliação - Acatada</b></label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" name="ds_naoacatado" id="ds_naoacatado"  class="wtext"  rows="9" disabled>{{ $Notificacao->ds_acatado }}</textarea>
                                                </div>
                                            </div><!-- form-group -->


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Parecer </label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="bit_aceito" name="bit_aceito" style="width: 100%" disabled>
                                                        <option value=""></option>
                                                        @if ($Notificacao->bit_aceito == 4) 
                                                        <option value="4" selected>Justificativa acatada</option>
                                                        @elseif ($Notificacao->bit_aceito == 5)
                                                        <option value="5" selected>Justificativa não acatada</option>
                                                        @else 
                                                        <option value="#" selected>Informação ainda não disponível</option>
                                                        @endif
                                                    </select>

                                                </div>
                                            </div><!-- form-group -->

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Data da avaliação</label>
                                                <div class="col-sm-8">
                                                    @if ($Notificacao->dt_naoacatado == '')
                                                    <input type="text" name="dt_naoacatado" id="dt_naoacatado"  value="" class="form-control" disabled/>
                                                    @else 
                                                    <input type="text" name="dt_naoacatado" id="dt_naoacatado"  value="{{ Carbon\Carbon::parse($Notificacao->dt_naoacatado)->format('d/m/Y H:i') }}" class="form-control" disabled/>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Responsável pela avaliação</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ma_justificativa" id="ma_justificativa"  value="{{ $Notificacao->ma_avaliador }}" class="form-control" title="Informe o nome do contexto" disabled/>
                                                </div>
                                            </div>

                                    </div>



                                    @endif



                                </div><!-- form-group -->




                                </form>


                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->
                </div>
            </div> <!-- Final da tab -->
        </div>





    </div> <!-- contentpanel -->
</div> <!-- mainpanel -->
</section>




@include('Default.endScripts')

<script src="{{ asset("theme/lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js") }}"></script>
<script src="{{ asset("theme/lib/wysihtml5x/wysihtml5x.js") }}"></script>
<script src="{{ asset("theme/lib/wysihtml5x/wysihtml5x-toolbar.js") }}"></script>


<script>

function copyToClipboard(element) {
    var elemento = document.querySelector(element);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(elemento.value).select();
    document.execCommand("copy");
    $temp.remove();
}
var cp1 = document.querySelector("#lb_ocorrencia");
cp1.addEventListener("click", function () {
    copyToClipboard("#ds_ocorrencia");
    alert('texto copiado!');
});
var cp2 = document.querySelector("#lb_duracao");
cp2.addEventListener("click", function () {
    copyToClipboard("#nu_horas");
    alert('texto copiado!');
});
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

    // Input Masks
    //$("#mapreposto").mask("99999/9999");

    // Error Message In One Container
    $('#basicForm').validate({
        errorLabelContainer: jQuery('#basicForm div.error')
    });



});
</script>



</body>
<html></html>
