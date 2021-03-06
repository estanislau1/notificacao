@include('Default.head')

<body>

    @include('Default.header')

    <section>
        @include('Default.leftpanel')


        <div class="mainpanel">

            <div class="contentpanel">

                <!-- Breadcrump -->
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="#"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="#">Descumprimento de nível de serviço</a></li>
                </ol>
                <!-- Final Breadcrump -->
                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Descumprimentos de nível de serviço registrados</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->

                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Verifique os descumprimentos de nível de serviço registrados</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form id="" name="" enctype="multipart/form-data" action='{{ url("buscarmes")}}' method="post" class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="menu-mes">

                                            <?php
                                            if (isset($_POST['mes'])) {
                                                $mes = $_POST['mes'];
                                            } else {
                                                $mes = Carbon\Carbon::now()->month;
                                            }
                                            if (isset($_POST['ano'])) {
                                                $ano = $_POST['ano'];
                                            } else {
                                                $ano = Carbon\Carbon::now()->year;
                                            }
                                            ?>
                                            <select id="anorelmensal" name="ano" class="select2" data-placeholder="Ano" title="Selecione o ano para visualizar" >
                                                <option value="2017" <?php echo ($ano == '2017') ? "selected" : ""; ?>>2017</option>
                                                <option value="2018" <?php echo ($ano == '2018') ? "selected" : ""; ?>>2018</option>
                                                <option value="2019" <?php echo ($ano == '2019') ? "selected" : ""; ?>>2019</option>
                                            </select>

                                            <select name="mes" class="select2" style="width: 9% !important;" title="Selecione o mês visualizar" >
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


                                            <button class="btn btn-blue btn-quirk">Enviar</button>
                                            <a href="{{ url("notificacao/buscarminhasnotificacoes")}}" class="btn btn-blue btn-quirk" style="margin-left: 10px;">Minhas notificações</a>

                                        </div>
                                    </form>


                                    <div class="table-responsive">

                                        <table id="dataTable1" class="table table-bordered table-striped-col">
                                            <thead>
                                                <tr>

                                                    <th>Nº</th>
                                                    <th>AÇÕES</th>
                                                    <th>DATA</th>
                                                    <th>CONTRATO</th>
                                                    <th>EQUIPE NOTIFICADORA</th>
                                                    <th>EQUIPE NOTIFICADA</th>
                                                    <th>OCORRÊNCIA</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>AÇÕES</th>
                                                    <th>DATA</th>
                                                    <th>CONTRATO</th>
                                                    <th>EQUIPE NOTIFICADORA</th>
                                                    <th>EQUIPE NOTIFICADA</th>
                                                    <th>OCORRÊNCIA</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>

                                                </tr>
                                            </tfoot>
                                            <tbody>

                                                @foreach ($Notificacoes as $n)

                                                <tr>

                                                    <td>
                                                        <a href="{{ url("notificacao/ver/".Crypt::encrypt($n->id_notificacao) )}}">{{ $n->nu_notificacao }}</a>

                                                    </td>

                                                    <td>
                                                        <!--  Verifica se a pessoa é gestor-->
                                                        <!--  Verifica se a pessoa é gestor-->
                                                        @if(Session::get('isgestor') == 1 || Session::get('issupervisor') == 1)
                                                        @if($n->dt_naoacatado == NULL && $n->bit_aceito == 1)
                                                        <a href="{{ url("notificacao/autorizar/".Crypt::encrypt($n->id_notificacao) )}}">Autorizar</a>

                                                        |
                                                        @endif
                                                        @endif


                                                        <!--  Verifica se a pessoa é preposto -->
                                                        @if(Session::get('ispreposto') == 1)
                                                        @if($n->bit_aceito == 2)
                                                        <a href="{{ url("notificacao/justificar/".Crypt::encrypt($n->id_notificacao) )}}">Justificar</a>


                                                        |
                                                        @endif
                                                        @endif

                                                        @if(Session::get('isgestor') == 1 || Session::get('issupervisor') == 1)
                                                        @if($n->bit_aceito == 3)
                                                        <a href="{{ url("notificacao/avaliar/".Crypt::encrypt($n->id_notificacao) )}}">Avaliar</a>

                                                        |
                                                        @endif
                                                        @endif

                                                        <!--  Verifica se a pessoa é agente de RH e Contratos || Session::get('isgestor') == 1-->
                                                        @if(Session::get('isrh') == 1 )
                                                        @if($n->bit_aceito == 99 || $n->bit_aceito == 9)
                                                        <a href="{{ url("notificacao/reabrir/".Crypt::encrypt($n->id_notificacao) )}}">Reabrir</a>

                                                        |
                                                        @endif
                                                        @endif
                                                        @if(Session::get('isrh') == 1 )
                                                        @if($n->bit_aceito == 4 || $n->bit_aceito == 44 || $n->bit_aceito == 5 || $n->bit_aceito == 55)
                                                        <a href="{{ url("notificacao/corrigir/".Crypt::encrypt($n->id_notificacao) )}}">Corrigir</a>

                                                        |
                                                        <a href="{{ url("notificacao/devolverpreposto/".Crypt::encrypt($n->id_notificacao) )}}">Devolver preposto</a>

                                                        |
                                                        @endif
                                                        @endif


                                                        <a href="{{ url("notificacao/ver/".Crypt::encrypt($n->id_notificacao) )}}">Informações</a>

                                                        @if(Session::get('matricula') == $n->ma_cadastro && $n->bit_aceito <= 2 )
                                                        |
                                                        <a href="{{ url("notificacao/editar/".$n->id_notificacao)}}">Editar</a>

                                                        @endif

                                                        <!--
                                    # COLOCAR ESSAS FUNCIONALIDADES NA PROXIMA VERSÃO
        
                                    | <a href="notificacao/acatamentoespecial/{{ $n->id_notificacao }}">Acatamento especial</a>
                                    | <a href="notificacao/historico/{{ $n->id_notificacao }}">Histórico</a>
                                                        -->

                                                    </td>
                                                    <td>{{ Carbon\Carbon::parse($n->created_at)->format('d/m/Y') }}</td>
                                                    <td>{{ $n->nu_contrato }} - <?php echo DB::table('EMPRESA')->where('id_empresa', $n->id_empresa)->value('no_empresa'); ?></td>


                                                    @foreach ($Coordenacoes as $Coordenacao)
                                                    @if ($n->id_notificadora === $Coordenacao->id_coordenacao)
                                                    <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($Coordenacoes as $Coordenacao)
                                                    @if ($n->id_impactada === $Coordenacao->id_coordenacao)
                                                    <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                    @endif
                                                    @endforeach
                                                    <td width="15%">{{$n->ds_ocorrencia }}</td>

                                                    <td>
                                                        @if($n->bit_aceito == 9)
                                                        Não autorizado
                                                        @endif

                                                        @if($n->bit_aceito == 99)
                                                        Não autorizado - Prazo excedido!
                                                        @endif

                                                        @if($n->bit_aceito == 55)
                                                        Justificativa não acatada - Prazo excedido!
                                                        @endif

                                                        @if($n->bit_aceito == 44)
                                                        Justificativa acatada - Prazo excedido!
                                                        @endif

                                                        @if($n->bit_aceito == 5)
                                                        Justificativa não acatada
                                                        @endif

                                                        @if($n->bit_aceito == 4)
                                                        Justificativa acatada
                                                        @endif


                                                        @if($n->bit_aceito == 3)
                                                        Aguardando avaliação
                                                        @endif


                                                        @if($n->bit_aceito == 2)
                                                        Aguardando justificativa
                                                        @endif



                                                        @if($n->bit_aceito == 1)
                                                        Aguardando autorização
                                                        @endif

                                                    </td>

                                                    @if($n->dt_fim_justificativa)
                                                    <td>{{ Carbon\Carbon::parse($n->dt_fim_justificativa)->format('d/m/Y H:i') }}</td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- panel-body -->
                            </div>
                        </div> <!-- panel -->
                    </div> <!-- Final do Primeiro panel (TAB:popular) -->

                </div>


            </div> <!-- contentpanel -->
        </div> <!-- mainpanel -->
    </section>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Tem certeza que deseja excluir esse preposto? </h4>
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
                "order": [[0, "desc"]],
                "pageLength": 100,
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

            $("#alerta").fadeOut(5200);


            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });


        });
    </script>


</body>
<html></html>
