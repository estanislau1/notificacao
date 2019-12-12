<?php
use App\Models\Empresa as Empresa;
?>
@include('Default.head')
<style type="text/css">

#isexpanded:checked ~ #expand-btn, #isexpanded:checked ~ * #expand-btn {
    background: #B5B5B5;
    -moz-box-shadow: inset rgba(0, 0, 0, 0.4) 0 -5px 12px, inset rgba(0, 0, 0, 1) 0 1px 3px, rgba(255, 255, 255, 0.4) 0 1px;
    -webkit-box-shadow: inset rgba(0, 0, 0, 0.4) 0 -5px 12px, inset rgba(0, 0, 0, 1) 0 1px 3px, rgba(255, 255, 255, 0.4) 0 1px;
    box-shadow: inset rgba(0, 0, 0, 0.4) 0 -5px 12px, inset rgba(0, 0, 0, 1) 0 1px 3px, rgba(255, 255, 255, 0.4) 0 1px;
}

#isexpanded, .expandable {
    display: none;
}

#isexpanded:checked ~ * tr.expandable {
    display: table-row;
    background: #cccccc;
}

#isexpanded:checked ~ div.expandable, #isexpanded:checked ~ * div.expandable {
    display: block;
    background: #cccccc;
}
</style>

<body>
    @include('Default.header')


    <section>
        @include('Default.leftpanel')


        <div class="mainpanel">


            <div class="contentpanel">

                <!-- Breadcrump -->
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="#"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="#">Relatório mensal de SLM</a></li>
                </ol>
                <!-- Final Breadcrump -->

                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Relatório mensal de SLM</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Selecione o ano e mês para gerar o relatório</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form  id="relatoriomensal" name="" enctype="multipart/form-data" action='{{ url("relatorio/relatoriomensalslm")}}' method="post" class="">
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
                                                <option value="1" <?php echo ($mes == '1') ? "selected" : ""; ?>>Janeiro</option>
                                                <option value="2" <?php echo ($mes == '2') ? "selected" : ""; ?>>Fevereiro</option>
                                                <option value="3" <?php echo ($mes == '3') ? "selected" : ""; ?>>Março</option>
                                                <option value="4" <?php echo ($mes == '4') ? "selected" : ""; ?>>Abril</option>
                                                <option value="5" <?php echo ($mes == '5') ? "selected" : ""; ?>>Maio</option>
                                                <option value="6" <?php echo ($mes == '6') ? "selected" : ""; ?>>Junho</option>
                                                <option value="7" <?php echo ($mes == '7') ? "selected" : ""; ?>>Julho</option>
                                                <option value="8" <?php echo ($mes == '8') ? "selected" : ""; ?>>Agosto</option>
                                                <option value="9" <?php echo ($mes == '9') ? "selected" : ""; ?>>Setembro</option>
                                                <option value="10" <?php echo ($mes == '10') ? "selected" : ""; ?>>Outubro</option>
                                                <option value="11" <?php echo ($mes == '11') ? "selected" : ""; ?>>Novembro</option>
                                                <option value="12" <?php echo ($mes == '12') ? "selected" : ""; ?>>Dezembro</option>
                                            </select>


                                            <button class="btn btn-blue btn-quirk">Enviar</button>
                                            <!--<a class="btn btn-blue btn-quirk" style="display: <?= $display; ?>" href="gerarpdf" target="_blank">Gerar PDF</a>-->



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
                                        $tam = count($Slm);

                                        //dd($Contratos);
                                        //var_dump($Slm[0]);
                                        //die;
                                        ?>
					<input type="checkbox" id="isexpanded" />

                                        @foreach($Contratos as $c)
                                        <?php
                                        $totalacat05D = 0;
                                        $totalnacat05D = 0;
                                        $totalacat05P = 0;
                                        $totalnacat05P = 0;
                                        $empresa = Empresa::find($c->id_empresa);    
					     $i1 = 0;
                                        $i2 = 0;
                                        $ids = [];
                                        $ids2 = [];                                    
                                        ?>
                                        
                                        <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">{{$empresa['no_empresa']}}</h1></center>
                                        <div class="table-responsive">
                                            <table  class="table table-bordered dataTable1 tabelarelatorio">
                                                <tr>
                                                    <th colspan="2"><b>IEPC05D</b></th>
                                                    <th colspan="2"><b>IEPC05P</b></th>
                                                </tr>
                                                <tr>                                                    
                                                    <td style="color:green;font-weight: bold;">Acatado</td>
                                                    @foreach($Slm as $s)                                                    
                                                    @if(($c->nu_contrato == $s->nu_contrato) && ($s->id_indicador == 8) && ($s->status == 3 || $s->status == 33))
                                                    <?php $totalacat05D = $totalacat05D + $s->total; ?> <!--05D-->
                                                    @endif
                                                    @endforeach
                                                    <td><?= $totalacat05D; ?></td> <!--05D-->
                                                    <td style="color:green;font-weight: bold;">Acatado</td>
                                                    @foreach($Slm as $s)                                                    
                                                    @if(($c->nu_contrato == $s->nu_contrato) && ($s->id_indicador == 11) && ($s->status == 3 || $s->status == 33))
                                                    <?php $totalacat05P = $totalacat05P + $s->total; ?> <!--05P-->
                                                    @endif
                                                    @endforeach
                                                    <td><?= $totalacat05P; ?></td><!--05P-->
                                                </tr>
                                                <tr>
                                                    <td style="color:red;font-weight: bold;"><label for="isexpanded">Não acatado</label></td>
                                                    @foreach($Slm as $s)                                                    
                                                    @if(($c->nu_contrato == $s->nu_contrato) && ($s->id_indicador == 8) && ($s->status == 4 || $s->status == 44))
								<?php $ids[$i1] = $s->nu_slm; $i1++; ?>
                                                    <?php $totalnacat05D = $totalnacat05D + $s->total; ?> <!--05D-->
                                                    @endif
                                                    @endforeach
                                                    <td><?= $totalnacat05D ?><br><br><div class="expandable" id="id1"><?php echo implode(",", $ids); ?></div></td><!--05D-->
                                                    <td style="color:red;font-weight: bold;"><label for="isexpanded">Não acatado</label></td>
                                                    @foreach($Slm as $s)                                                    
                                                    @if(($c->nu_contrato == $s->nu_contrato) && ($s->id_indicador == 11) && ($s->status == 4 || $s->status == 44))
								<?php $ids2[$i2] = $s->nu_slm;$i2++; ?>
                                                    <?php $totalnacat05P = $totalnacat05P + $s->total;?> <!--05D-->
                                                    @endif
                                                    @endforeach
                                                    <td><?= $totalnacat05P ?> <br><br><div class="expandable" id="id2"><?php echo implode(",", $ids2); ?></div></td><!--05D--><!--05P-->
                                                </tr>
                                                <tr>
                                                    <td>total</td>
                                                    <td><?php echo $totalacat05D + $totalnacat05D?></td>
                                                    <td>total</td>
                                                    <td><?php echo $totalacat05P + $totalnacat05P?></td>                                                    
                                                </tr>
                                                
                                            </table>
                                            <b>Total Incidentes em atraso:</b> <?php echo $totalacat05D + $totalnacat05D +  $totalacat05P + $totalnacat05P?>

                                            <hr>

                                        </div>
                                        @endforeach

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
