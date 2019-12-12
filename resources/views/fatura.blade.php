@include('Default.head')

<body>
    @include('Default.header')


    <section>
        @include('Default.leftpanel')



        <div class="mainpanel">

            <div class="contentpanel">

                <!-- Breadcrump --> 
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="index.html"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="buttons.html">Fatura</a></li>
                </ol>
                <!-- Final Breadcrump --> 


                <!-- ABAS DA TAB -->  
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Faturas registrados</a></li>
                    <li class="btn-blue"><a class="destaque" href="#recent" data-toggle="tab"
                                            aria-expanded="false">Adicionar nova Fatura</a></li>
                </ul>
                <!--Final da ABAS DA TAB --> 


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">
                            <div class="panel-heading">
                                <p>Verifique as Faturas registrados no sistema.</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="dataTable1" class="table table-bordered table-striped-col">
                                            <thead>
                                                <tr>
                                                    <th>Contrato</th>
                                                    <th>Ano/Mês</th>
                                                    <th>Ordem de serviço</th>
                                                    <th>Total Inc</th>
                                                    <th>Inc P</th>
                                                    <th>Inc D</th>
                                                    <th>Tarefas</th>
                                                    <th>Pend amostragem</th>
                                                    <th>Pend processos</th>
                                                    <th>Atributos em branco</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Contrato</th>
                                                    <th>Ano/Mês</th>
                                                    <th>Ordem de serviço</th>
                                                    <th>Total Inc</th>
                                                    <th>Inc P</th>
                                                    <th>Inc D</th>
                                                    <th>Tarefas</th>
                                                    <th>Pend amostragem</th>
                                                    <th>Pend processos</th>
                                                    <th>Atributos em branco</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php //var_dump($Fatura);?>
                                                @foreach ($Fatura as $fat)
                                                <tr>
                                                    <td><?php echo DB::table('EMPRESA')->where('id_empresa', $fat->id_empresa)->value('no_empresa');?> - {{ $fat->nu_contrato}}</td>
                                                    <td> {{$fat->ano}}/{{ $fat->mes }}</td>
                                                    <td>{{ $fat->ordem_servico }}</td>
                                                    <td>{{ $fat->incidentes }}</td>
                                                    <td>{{ $fat->incidentes_p }}</td>
                                                    <td>{{ $fat->incidentes_d }}</td>
                                                    <td>{{ $fat->tarefas }}</td>
                                                    <td>{{ $fat->pend_amostragem }}</td>
                                                    <th>{{ $fat->pend_processos }}</th>
                                                    <td>{{ $fat->atributos_branco }}</td>


                                                    <td>
                                                        <a href="fatura/editar/{{ $fat->id_fatura }}">Editar</a> 
                                                        | <a data-href="fatura/delete/{{ $fat->id_fatura }}" data-toggle="modal" data-target="#confirm-delete">Excluir</a>


                                                    </td>
                                                </tr>
                                                @endforeach


                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- panel-body --> 
                            </div>
                        </div> <!-- panel -->
                    </div> <!-- Final do Primeiro panel (TAB:popular) --> 

                    <div class="tab-pane" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                                    </div>
                                    <div class="panel-body nopaddingtop">

                                        <form id="basicForm" name="basicForm" method="post" action="{{ url("fatura/incluir") }}" class="form-horizontal">
                                            <input type="hidden" name="idfatura">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="error" display="block"></div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Contrato <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select class="select2" id="idcontrato" name="idcontrato" style="width: 25%" data-placeholder="Selecione um contrato" title="Você precisa selecionar um contrato!!" required>
                                                        <option value=""></option>
                                                        @foreach ($Contratos as $Contrato)
                                                        <option value="{{ $Contrato->id_contrato }}">{{$Contrato->no_empresa}} - {{ $Contrato->nu_contrato }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div><!-- form-group -->
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ano de refência: <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <?php
                                                    if (isset($_POST['ano'])) {
                                                        $ano = $_POST['ano'];
                                                    } else {
                                                        $ano = Carbon\Carbon::now()->year;
                                                    }
                                                    ?>
                                                    
                                                    <select name="ano" class="select2" style="width: 25%"title="Selecione o ano para visualizar" >
                                                        <option value="2017" <?php echo ($ano == '2017') ? "selected" : ""; ?>>2017</option>
                                                        <option value="2018" <?php echo ($ano == '2018') ? "selected" : ""; ?>>2018</option>
                                                        <option value="2019" <?php echo ($ano == '2019') ? "selected" : ""; ?>>2019</option>
                                                        <option value="2020" <?php echo ($ano == '2020') ? "selected" : ""; ?>>2020</option>
                                                        
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mês de refência: <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <?php
                                                    if (isset($_POST['mes'])) {
                                                        $mes = $_POST['mes'];
                                                    } else {
                                                        $mes = Carbon\Carbon::now()->month;
                                                    }
                                                    ?>


                                                    <select name="mes" class="select2" style="width: 25%"title="Selecione o mês visualizar" >
                                                        <option value="01" <?php echo ($mes == '01') ? "selected" : ""; ?>>Janeiro</option>
                                                        <option value="02" <?php echo ($mes == '02') ? "selected" : ""; ?>>Fevereiro</option>
                                                        <option value="03" <?php echo ($mes == '03') ? "selected" : ""; ?>>Março</option>
                                                        <option value="04" <?php echo ($mes == '04') ? "selected" : ""; ?>>Abril</option>
                                                        <option value="05" <?php echo ($mes == '05') ? "selected" : ""; ?>>Maio</option>
                                                        <option value="06" <?php echo ($mes == '06') ? "selected" : ""; ?>>Junho</option>
                                                        <option value="07" <?php echo ($mes == '07') ? "selected" : ""; ?>>Julho</option>
                                                        <option value="08" <?php echo ($mes == '08') ? "selected" : ""; ?>>Agosto</option>
                                                        <option value="09" <?php echo ($mes == '09') ? "selected" : ""; ?>>Setembro</option>
                                                        <option value="10" <?php echo ($mes == '10') ? "selected" : ""; ?>>Outubro</option>
                                                        <option value="11" <?php echo ($mes == '11') ? "selected" : ""; ?>>Novembro</option>
                                                        <option value="12" <?php echo ($mes == '12') ? "selected" : ""; ?>>Dezembro</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" >Total de Ordens de Serviços:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="ordem_servico" id="nopreposto" class="form-control" title="Informe o total de ordens de serviço" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de Incidentes:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="incidentes" id="nopreposto" class="form-control" title="Informe o total de incidentes" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de Incidentes Prioritários P:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="incidentes_p" id="nopreposto" class="form-control" title="Informe o total de incidentes prioritários" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de demais incidentes D:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="incidentes_d" id="nopreposto" class="form-control" title="Informe o total de demais incidentes" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de tarefas:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="tarefas" id="nopreposto" class="form-control" title="Informe o total tarefas" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de Ics auditados por amostragem (TIC):<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="pend_amostragem" id="nopreposto" class="form-control" title="Informe Total de Ics auditados por amostragem" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de Pendências dos Processos (TICNC):<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number"  style="width: 10%" name="pend_processos" id="nopreposto" class="form-control" title="Informe o total de incidentes" placeholder="" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Total de Atributos em Branco:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" style="width: 10%" name="atributos_branco" id="nopreposto" class="form-control" title="Informe total de atributos em branco" placeholder="" required />
                                                </div>
                                            </div>


                                    </div>


                                </div><!-- form-group -->

                                <hr>

                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">

                                        <button type="submit" class="btn btn-wide btn-primary btn-quirk mr5">Cadastrar</button>


                                        <button type="reset" class="btn btn-wide btn-default btn-quirk">Limpar</button>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Tem certeza que deseja excluir essa Fatura? </h4>
            </div>
            <div class="modal-body">
                Caso você exclua esse preposto, ele não poderá mais responder as notificações.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Não, desejo cancelar</button>
                <a class="btn btn-danger btn-ok">Sim, tenho certeza</a>
            </div>
        </div>
    </div>
</div>
    


@include('Default.endScripts')

<script>
    $(document).ready(function () {

        // Error Message In One Container
        $('#basicForm').validate({
            errorLabelContainer: jQuery('#basicForm div.error')
        });

        $('.select2').select2();

        // Input Masks
        //$("#mapreposto").mask("c0000000");


        //$('#dataTable1').DataTable();

        $('#dataTable1').dataTable({
            "oLanguage": {
                "sProcessing": "Aguarde enquanto os dados são carregados ...",
                "sLengthMenu": "Mostrar _MENU_ registros por pagina",
                "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
                "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
                "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                "sInfoFiltered": "",
                "sSearch": "Procurar",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            }
        });

        $("#alerta").fadeOut(3200);



        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });



    });
</script>


</body>
<html></html>
