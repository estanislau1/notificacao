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
                </ol>
                <!-- Final Breadcrump --> 


                <!-- ABAS DA TAB -->  
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab"
                                          aria-expanded="false">Nova notificação</a></li>
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
                                    <div class="panel-body nopaddingtop">
                                        <form id='basicForm' name='basicForm'  enctype="multipart/form-data" action='{{ url("notificacao/incluir/")}}' method="post" class='form-horizontal'>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="error"></div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Coordenação Notificadora <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_notificadora" name="id_notificadora" style="width: 100%" data-placeholder="Selecione a coordenação notificadora" title="Campo Coordenação Notificadora Obrigatório!! Favor preencher!" required>
                                                        <option value=""></option>
                                                        @foreach ($Coordenacoes as $Coordenacao)
                                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Coordenação impactada <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_impactada" name="id_impactada" style="width: 100%" data-placeholder="Selecione a coordenação impactada" title="Campo Coordenação Impactada Obrigatório!! Favor preencher!" required>
                                                        <option value=""></option>
                                                        @foreach ($Coordenacoes as $Coordenacao)
                                                        <option id="{{$Coordenacao->nu_coordenacao}}" value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->

                                            <hr>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Contrato <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select  class="select2 bloqueia" id="id_contrato" name="id_contrato" style="width: 100%" data-placeholder="Selecione o contrato" title="Campo Contrato Obrigatório!! Favor preencher!" required>
                                                        <option value=""></option>

                                                        @foreach ($Contratos as $Contrato)
                                                        <option id="{{$Contrato->no_empresa}}" value="{{ $Contrato->id_contrato }}">{{$Contrato->no_empresa}} - {{ $Contrato->nu_contrato }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Indicador afetado <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="select2" id="id_indicador" name="id_indicador" style="width: 100%" data-placeholder="Selecione o indicador afetado" title="Campo Indicador afetado Obrigatório!! Favor preencher!" required>
                                                        <option value=""></option>
                                                        @foreach ($Indicadores as $indicador)
                                                        <option value="{{ $indicador->id_indicador }}">{{ $indicador->sg_indicador }} - {{$indicador->no_indicador}}</option>
                                                        @endforeach      
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Nº da ocorrência</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="ds_ocorrencia" id="ds_ocorrencia"  value="" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Descrição da ocorrência </label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" name="ds_ticket" id="ds_ticket" placeholder="Preencha esse campo com a descrição da ocorrência" class="wtext"></textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <hr>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Motivos da notificação <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    @foreach ($Motivos as $motivo)
                                                    <input name="id_motivo[]" type="radio" value="{{ $motivo->id_motivo }}" title="Campo Motivo Obrigatório!! Favor preencher!" required> {{ $motivo->no_motivo }} <br>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Descrição da notificação <span class="text-danger">*</span></label>
                                                <div class="panel-body col-sm-9" style="margin-left:-10px">
                                                    <textarea style="width:90.7%;" id="ds_notificacao" name="ds_notificacao" class="wtext" placeholder="Preencha este campo com a descrição da notificação" rows="18" title="Campo Descrição da notificação Obrigatório!! Favor preencher!" required></textarea>
                                                </div>
                                            </div><!-- form-group -->

                                            <hr>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Duração da inconformidade (em horas): </label>
                                                <div class="col-sm-1">
                                                    <input type="number" name="nu_horas" id="nu_horas" value="0" class="form-control" title="Informe o número de horas" placeholder="numérico" onblur="validaDuracao()"required/>
                                                </div>
                                                <span style="color: red; font-weight: bold;" id="spanDuracao"> </span>
                                            </div>


                                            <hr>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Arquivo anexo: </label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="nome_anexo" id="nome_anexo" value="" class="form-control" placeholder=""/>
                                                </div>
                                            </div>

                                    </div>


                                </div><!-- form-group -->

                                <hr>

                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">

                                        <a class="btn btn-wide btn-primary btn-quirk mr5" data-toggle="modal" data-target="#confirm-anexo">Gerar notificação</a>


                                        <button type="button" onClick="history.back();" class="btn btn-wide btn-default btn-quirk">Cancelar</button>
                                    </div>
                                </div>
                                <div class="modal fade" id="confirm-anexo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4> Tem certeza que deseja GERAR a notificação?</h4>
                                            </div>
                                            <div class="modal-body">
                                                Favor <strong>NÃO</strong> esquecer de <strong>anexar as evidências</strong>, caso elas existem.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Não, desejo reavaliar a notificação.</button>
                                                <button type="submit" class="btn btn-wide btn-primary btn-quirk mr5 btn-ok">Sim, tenho certeza</button>
                                                <!--<a class="btn btn-danger btn-ok">Sim, tenho certeza.</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            function validaDuracao() {
                                                var duracao = document.querySelector("#nu_horas").value;
                                                var msg = document.querySelector("#spanDuracao");
                                                if (duracao < 0) {
                                                    msg.textContent = "A Duração da inconformidade não pode ser negativa!";
                                                    document.querySelector("#nu_horas").value = "0";
                                                } else {
                                                    msg.textContent = "";
                                                }
                                            }


</script>
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

        $('#confirm-anexo').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });





    });
</script>



</body>
<html></html>
