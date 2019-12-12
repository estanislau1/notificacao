<?php
$relatorio = '';
?>
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
                    <li><a href="#">Relatório mensal de Descumprimentos</a></li>
                </ol>
                <!-- Final Breadcrump -->

                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Relatório mensal de Descumprimentos</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Selecione o Contrato, a Coordenação e o mês para gerar o relatório</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form  id="relatoriomensal" name="" enctype="multipart/form-data" action='{{ url("relatorio/relatoriomensaldescumprimento")}}' method="post" class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="menu-mes">

                                            <?php
                                            if (isset($_POST['mes'])) {
                                                $mes = $_POST['mes'];
                                                $display = "none";
                                            } else {
                                                $mes = Carbon\Carbon::now()->month;
                                                $display = "none";
                                            }
                                            if (isset($_POST['ano'])) {
                                                $ano = $_POST['ano'];
                                            } else {
                                                $ano = Carbon\Carbon::now()->year;
                                            }
                                            //var_dump($All); 
                                            ?>
                                            <select class="select2" id="id_contrato" name="id_contrato" data-placeholder="Contrato" title="Selecione um contrato" required>
                                                <option value=""></option>

                                                <?php
                                                if (Session::get('ispreposto') == 1) {
                                                    $contrato_prep = DB::table('PREPOSTO')->where('ma_preposto', '=', session('matricula'))->value('id_contrato');
                                                }
                                                ?>
                                                @foreach ($Contratos as $Contrato)
                                                @if(Session::get('ispreposto') == 1 && Session::get('isrh') != 1)
                                                @if($Contrato->id_contrato == $contrato_prep)
                                                <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option>
                                                @endif
                                                @else
                                                <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option>
                                                @endif
                                                @endforeach

                                            </select>



                                            <select id="anorelmensal" name="ano" class="select2" data-placeholder="Ano" title="Selecione o ano para visualizar" >
                                                <option value="2017" <?php echo ($ano == '2017') ? "selected" : ""; ?>>2017</option>
                                                <option value="2018" <?php echo ($ano == '2018') ? "selected" : ""; ?>>2018</option>
                                                <option value="2019" <?php echo ($ano == '2019') ? "selected" : ""; ?>>2019</option>
                                                <option value="2020" <?php echo ($ano == '2020') ? "selected" : ""; ?>>2020</option>
                                                <option value="2021" <?php echo ($ano == '2021') ? "selected" : ""; ?>>2021</option>
                                                <option value="2022" <?php echo ($ano == '2022') ? "selected" : ""; ?>>2022</option>
                                                <option value="2023" <?php echo ($ano == '2023') ? "selected" : ""; ?>>2023</option>
                                                <option value="2024" <?php echo ($ano == '2024') ? "selected" : ""; ?>>2024</option>
                                            </select>

                                            <select id="mesrelmensal" name="mes" class="select2" data-placeholder="Mês" title="Selecione o mês para visualizar" >
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
                                            <a class="btn btn-blue btn-quirk" style="display: <?= $display; ?>" href="gerarpdf" target="_blank">Gerar PDF</a>



                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['mes'])) {
                                        switch ($_POST['mes']):
                                            case $mes = 1:
                                                $titulo_mes = 'Janeiro';
                                                break;
                                            case $mes = 2:
                                                $titulo_mes = 'Fevereiro';
                                                break;
                                            case $mes = 3:
                                                $titulo_mes = 'Março';
                                                break;
                                            case $mes = 4:
                                                $titulo_mes = 'Abril';
                                                break;
                                            case $mes = 5:
                                                $titulo_mes = 'Maio';
                                                break;
                                            case $mes = 6:
                                                $titulo_mes = 'Junho';
                                                break;
                                            case $mes = 7:
                                                $titulo_mes = 'Julho';
                                                break;
                                            case $mes = 8:
                                                $titulo_mes = 'Agosto';
                                                break;
                                            case $mes = 9:
                                                $titulo_mes = 'Setembro';
                                                break;
                                            case $mes = 10:
                                                $titulo_mes = 'Outubro';
                                                break;
                                            case $mes = 11:
                                                $titulo_mes = 'Novembro';
                                                break;
                                            case $mes = 12:
                                                $titulo_mes = 'Dezembro';
                                                break;
                                        endswitch;
                                    }
                                    ?>

                                    <?php
                                    if ($Display_table != 'none') {
                                        $titulo_contrato = \App\Models\Contrato::find($_POST['id_contrato']);
                                        $empresa = \App\Models\Empresa::find($titulo_contrato['id_empresa']);
                                        $empresa = $empresa['no_empresa'];
                                        ?>
                                        <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">Relatorio de Descumprimentos <?= $titulo_mes; ?>/<?= $ano; ?>: <?= $empresa; ?> - <?= $titulo_contrato['nu_contrato'] ?> </h1></center>
                                        <?php
                                        $title_contrato = $titulo_contrato['nu_contrato'];
                                        $relatorio .= "<center><h1 align='center' style='font-size: 1.5em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;'>Relatorio mês de $titulo_mes: $empresa - $title_contrato</h1></center>";
                                        ?>
                                        <div class="table-responsive">
                                            <table  class="table table-bordered table-striped-col dataTable1 tabelarelatorio">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>DATA</th>
                                                        <th>CONTRATO</th>
                                                        <th>TITULO</th>
                                                        <th>STATUS</th>
                                                        <th>CI</th>
                                                        <th>SICLG</th>
                                                        <th>OFÍCIO</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @foreach ($Descumprimento as $d)
                                                    <tr>
                                                        <td>
                                                            <a href="../descumprimento/ver/{{ Crypt::encrypt($d->id_descumprimento) }}">{{ $d->nu_descumprimento }}</a>
                                                        </td>
                                                        <td>{{ Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}</td>
                                                        <td><?= $empresa; ?> - {{ $d->nu_contrato }}</td>
                                                        <td>{{$d->ds_titulo}}</td>
                                                        <td>
                                                            @if($d->status == 1) 
                                                            Aguardando análise interna
                                                            @endif


                                                            @if($d->status == 2) 
                                                            Aguardando justificativa da empresa
                                                            @endif

                                                            @if($d->status == 3) 
                                                            Aguardando avaliação da justificativa da empresa
                                                            @endif
                                                            @if($d->status == 4) 
                                                            Descumprimento Acatado
                                                            @endif
                                                            @if($d->status == 5) 
                                                            Descumprimento não acatado
                                                            @endif
                                                            @if($d->status == 9) 
                                                            Descumprimento contratual desconsiderado por determinação da Coordenação
                                                            @endif
                                                            @if($d->status == 99) 
                                                            Descumprimento contratual desconsiderado por determinação da Gerência
                                                            @endif

                                                        </td>
                                                        <td>{{$d->ci}} @if($d->nome_anexo_ci) | <a href='{{ url('../storage/uploads') }}/{{ $d->nome_anexo_ci}}' target='_new'>Anexo CI</a>@endif</td>
                                                        <td>{{$d->siclg}}</td>
                                                        <td>{{$d->oficio}} @if($d->nome_anexo_parecer) | <a href='{{ url('../storage/uploads') }}/{{ $d->nome_anexo_parecer}}' target='_new'>Anexo parecer</a>@endif</td>

                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            <hr>

                                        </div>

                                    </div> <!-- panel-body -->
                                <?php } ?>
                            </div>
                            <a class="btn btn-blue btn-quirk" style="width: 100%; display: <?= $display; ?>" href="gerarpdf" target="_blank">Gerar PDF</a>
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

            $('.dataTable1').dataTable({
                "order": [[0, "desc"]],
                "pageLength": 25,
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
