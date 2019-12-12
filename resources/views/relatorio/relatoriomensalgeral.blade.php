<?php
$relatorios = "<html> <head>"
        . "<meta charset='UTF-8'>"
        . "<style>"
        . "tr:nth-child(even) {background-color: #dddddd;}"
        . "* {background:transparent !important;color:#000 !important;text-shadow:none !important;filter:none !important;-ms-filter:none !important;}"
        . "body {margin:0;padding:0;line-height: 1.4em;font: 12pt Georgia, 'Times New Roman', Times, serif;}"
        . "margin: 0.5cm;"
        . ".headerpanel {width: 100%; background-color: #1c60ab;}"
        . "th {background-color: rgba(29,150,178,1);font-weight: normal;text-align: center;color: white;&:first-of-type {text-align: left; }}"
        . "@page {header: page-header;footer: page-footer;}"
        . ".page-break {page-break-after: always;}"
        . "</style>"
        . "</head>"
        . "<body>"
        . "<img style='vertical-align: middle; margin-top: 3%; margin-left: 40%;' src='http://localhost/notifica/public/theme/images/logorelatorio.jpg'>";
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
                    <li><a href="#">Relatório mensal geral de Notificações</a></li>
                </ol>
                <!-- Final Breadcrump -->

                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Relatório mensal geral de Notificações</a></li>
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

                                    <form  id="relatoriomensal" name="" enctype="multipart/form-data" action='{{ url("relatorio/relatoriomensalgeral")}}' method="post" class="">
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

                                            <select class="select2" id="id_coordenacao" name="id_coordenacao"  data-placeholder="Selecione uma Coordenação ou nenhuma para todas!">
                                                <option value="999">Selecione uma Coordenação ou nenhuma para todas!</option>
                                                @foreach ($Coordenacoes as $Coordenacao)
                                                <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
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
                                             

                                            <button class="btn btn-blue btn-quirk">Postar</button>
                                            <a class="btn btn-blue btn-quirk"  href="gerarpdf2" >Gerar PDF</a>



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
                                        if ($_POST['id_coordenacao'] != 999) {
                                            $i = $_POST['id_coordenacao'];
                                            $tam = $_POST['id_coordenacao'];
                                        } else {
                                            $i = 1;
                                            $tam = 19;
                                        }
                                        
                                        ?>
                                    <span style="color:red; font-weight: bold;">Total de registros: <?php echo session('total');?></span>
                                        <?php
                                        $i = 1;
                                        $t = 0;
                                                                          
                                        foreach ($TotalContrato as $cont):
                                            $empresa = \App\Models\Empresa::find($cont->id_empresa);
                                            $empresa = $empresa['no_empresa'];
                                            
                                            ?>

                                            <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">Relatorio Geral de notificações <?= $titulo_mes; ?>/<?= $ano; ?>: <?= $empresa; ?> </h1></center>
                                            
                                            <br>
                                            <div class="table-responsive">
                                                
                                                <table  class="table table-bordered table-striped-col dataTable1 tabelarelatorio" id="tabela">

                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>DATA</th>
                                                            <th>EQUIPE NOTIFICADORA</th>
                                                            <th>EQUIPE NOTIFICADA</th>
                                                            <th>Indicador</th>
                                                            <th>Descrição</th>
                                                            <th>Ocorrência</th>
                                                            <th>motivo</th>
                                                            <th>STATUS</th>
                                                            <th>Prazo</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>


                                                        @foreach ($Notificacoes as $n)

                                                        <?php if ($n->nu_contrato == $cont->nu_contrato) { 
                                                            $t++;
                                                            ?>

                                                            <?php $motivo = DB::table('MOTIVO')->where('id_motivo', '=', $n->id_motivo)->value('no_motivo'); ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="../notificacao/ver/{{ Crypt::encrypt($n->id_notificacao) }}">{{ $n->nu_notificacao }}</a>
                                                                </td>
                                                                <?php  $relatorios .= "$n->nu_notificacao <br>"?>
                                                                <td>{{ Carbon\Carbon::parse($n->data)->format('d/m/Y') }}</td>

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

                                                                <td>{{$n->sg_indicador}}</td>

                                                                <td>{{strip_tags($n->ds_notificacao)}}</td>
                                                                <td>{{$n->ds_ocorrencia}}</td>
                                                                <td>{{$motivo}}</td>
                                                                <td>
                                                                    @if($n->bit_aceito == 9)
                                                                    Não autorizado
                                                                    @endif

                                                                    @if($n->bit_aceito == 99)
                                                                    Não autorizado - Prazo excedido!
                                                                    @endif

                                                                    @if($n->bit_aceito == 55)
                                                                    <span style="font-weight: bold; color: darkred;">Justificativa não acatada - Prazo excedido!</span>
                                                                    @endif

                                                                    @if($n->bit_aceito == 44)
                                                                    <span style="font-weight: bold; color: darkgreen;">Justificativa acatada - Prazo excedido!</span>
                                                                    @endif

                                                                    @if($n->bit_aceito == 5)
                                                                    <span style="font-weight: bold; color: red;">Justificativa não acatada</span>
                                                                    @endif

                                                                    @if($n->bit_aceito == 4)
                                                                    <span style="font-weight: bold; color: green;">Justificativa acatada</span>
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
                                                                <td>{{Carbon\Carbon::parse($n->dt_fim_justificativa)->format('d/m/Y')}}</td>

                                                            </tr>
                                                            <?php
                                                                                                                          
                                                            
                                                        }
                                                        ?>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                               
                                                <hr>

                                            </div>                                            

                                        <?php $i++;  session()->put('total', $t); endforeach; ?>

                                    </div> <!-- panel-body -->

                         <!-- */*********************************************/-->

                                              <!-- panel-body-PDF -->



                                    <?php  
                                    $relatorios.= "<html><body><br><br><br>
                                    <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>DATA</th>
                                                            <th>EQUIPE NOTIFICADORA</th>
                                                            <th>EQUIPE NOTIFICADA</th>
                                                            <th>IDICIDACADOR</th>
                                                            <th>DESCRIÇÃO</th>
                                                            <th>OCORRÊNCIA</th>
                                                            <th>MOTIVO</th>
                                                            <th>STATUS</th>
                                                            <th>PRAZO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                   
                                    "
                                   ?>
                                          <!-- wold-acesso -->
                              

                      <!-- wold-acesso -->

                       <?php  $relatorios .= "<td>$n->nu_notificacao <br></td>"?>     
                                   
                       <?php  $relatorios .= "<td>$n->data</td>"?>
                       
                        @foreach ($Coordenacoes as $Coordenacao)
                                                                @if ($n->id_notificadora === $Coordenacao->id_coordenacao)
                                                               
                                                                <?php $relatorios .= "<td>$Coordenacao->no_coordenacao</td>" ?>
                                                                @endif
                                                                @endforeach

                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                       <?php  $relatorios .= "<td>$n->id_notificadora</td>"?> 
                      

                                  
                       <?php  $relatorios .="</table>"?>
                                       











                              
                                 //echo $relatorio;
                                    <?php  
                                    session()->put('relatorios', $relatorios);
                                    ?>

                                     <!-- fim -- panel-body-PDF -->
                                <?php 
                                    }//echo  session('tabela2') . 'testando';} ?>
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
