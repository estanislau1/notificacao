<?php
$endereco_imagem = asset("theme/images/logorelatorio.jpg");
$relatorio = "<html> <head>"
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
        . "<img style='vertical-align: middle; margin-top: 3%; margin-left: 40%;' src='$endereco_imagem'>";
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
                    <li><a href="#">Relatório mensal de Notificações</a></li>
                </ol>
                <!-- Final Breadcrump -->

                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Relatório mensal de Notificações</a></li>
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

                                    <form  id="relatoriomensal" name="" enctype="multipart/form-data" action='{{ url("relatorio/relatoriomensal")}}' method="post" class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="menu-mes">

                                            <?php
                                            if (isset($_POST['mes'])) {
                                                $mes = $_POST['mes'];
                                                $display = "";
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
                                    $totalglobal01 = 0;
                                    $totalglobal02 = 0;
                                    $totalglobal03 = 0;
                                    $totalglobal04 = 0;
                                    $totalglobal05D = 0;
                                    $totalglobal05P = 0;
                                    $totalglobal06 = 0;
                                    $totalglobal07 = 0;
                                    $totalacatada01 = 0;
                                    $totalnacatada01 = 0;
                                    $totalacatada02 = 0;
                                    $totalnacatada02 = 0;
                                    $totalacatada03 = 0;
                                    $totalnacatada03 = 0;
                                    $totalacatada04 = 0;
                                    $totalnacatada04 = 0;
                                    $totalacatada05D = 0;
                                    $totalnacatada05D = 0;
                                    $totalacatada05P = 0;
                                    $totalnacatada05P = 0;
                                    $totalacatada06 = 0;
                                    $totalnacatada06 = 0;
                                    $totalacatada07 = 0;
                                    $totalnacatada07 = 0;

                                    $totalacatada = 0;
                                    $totalnacatada = 0;
                                    if ($All != 'vazio') {
                                        $titulo_contrato = \App\Models\Contrato::find($_POST['id_contrato']);
                                        $empresa = \App\Models\Empresa::find($titulo_contrato['id_empresa']);
                                        $empresa = $empresa['no_empresa'];
                                        if ($_POST['id_coordenacao'] != 999) {
                                            $i = $_POST['id_coordenacao'];
                                            $tam = $_POST['id_coordenacao'];
                                        } else {
                                            $i = 1;
                                            $tam = $QtdCoord;
                                        }
                                        ?>

                                        <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">Relatorio mês de <?= $titulo_mes; ?>: <?= $empresa; ?> - <?= $titulo_contrato['nu_contrato'] ?> </h1></center>
                                        <?php
                                        $title_contrato = $titulo_contrato['nu_contrato'];
                                        $relatorio .= "<center><h1 align='center' style='font-size: 1.5em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;'>Relatorio de $titulo_mes/$ano: $empresa - $title_contrato</h1></center>";

                                        for ($i; $i <= $tam; $i++) {

                                            foreach ($Coordenacoes as $cord) {
                                                if ($cord->id_coordenacao == $i) {
                                                    $titulo_coordenacao = $cord->ds_coordenacao;
                                                }
                                            }
                                            ?>

                                            <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;"><?= $titulo_coordenacao; ?> </h1></center>
                                            <?php
                                            $nomedoc = 'relatorio_' . $titulo_mes;
                                            session()->put('nomedoc', $nomedoc);
                                            $title_contrato = $titulo_contrato['nu_contrato'];
                                            $relatorio .= "<div style:'margin-top: 30%;float: left;'><center><h2 align='center' style='font-size: 0.85em; margin-top: 5%; margin-bottom: 2%; color: #1c60ab;'>$titulo_coordenacao</h2></center></div>";
                                            ?>
                                            <div class="table-responsive">

                                                <table  class="table table-bordered table-striped-col dataTable1 tabelarelatorio">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>DATA</th>
                                                            <th>EQUIPE NOTIFICADA</th>
                                                            <th>Indicador</th>
                                                            <th>TDI</th>
                                                            <th>Motivo</th>
                                                            <th>Ocorrência</th>
                                                            <th>Descrição</th>
                                                            <th>STATUS</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @foreach ($Notificacoes as $n)
                                                        <?php if ($n->id_notificadora == $i) { ?>
                                                            <?php
                                                            foreach ($All as $not) {
                                                                if ($not->id_notificadora == $i && $not->id_notificacao == $n->id_notificacao) {
                                                                    if ($not->id_motivo == 3)
                                                                        $motivo = "Falha de conformidade de resgistro";
                                                                    if ($not->id_motivo == 4)
                                                                        $motivo = "Não conforme de acordo com o prazo";
                                                                    if ($not->id_motivo == 5)
                                                                        $motivo = "Não conforme de acordo com sua eficácia";
                                                                    if ($not->id_motivo == 6)
                                                                        $motivo = "Indisponibilidade  de IC";
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="../notificacao/ver/{{ Crypt::encrypt($n->id_notificacao) }}">{{ $n->nu_notificacao }}</a>
                                                                </td>
                                                                <td>{{ Carbon\Carbon::parse($n->data_created)->format('d/m/Y') }}</td>
                                                                @foreach ($Coordenacoes as $Coordenacao)
                                                                @if ($n->id_impactada === $Coordenacao->id_coordenacao)
                                                                <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                                @endif
                                                                @endforeach

                                                                <td>{{$n->sg_indicador}}</td>
                                                                <td>{{$n->nu_horas}}</td>
                                                                <td><?= $motivo; ?></td>
                                                                <td>{{$n->ds_ocorrencia}}</td>
                                                                <td><?= strip_tags($n->ds_notificacao) ?></td>


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

                                                            </tr>
        <?php } ?><!-- fechamento if do for notificadora-->
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                                <?php
                                                if ($i == 0) {
                                                    $pular = 'page-break';
                                                } else {
                                                    $pular = "";
                                                }
                                                $pular = 'page-break';
                                                $relatorio .= "<table border='1' class='table table-striped table-bordered table-hover table-total' style='font-size: 0.85em; width: 70%;border-collapse: collapse; '  align='center'>"
                                                        . "<thead>"
                                                        . "<tr>"
                                                        . "<th>Indicador</th>"
                                                        . "<th>Ocorrências Notificadas</th>"
                                                        . "<th>Não acatadas</th>"
                                                        . "<th>Acatadas</th>"
                                                        . "</tr>"
                                                        . "</thead>"
                                                        . "<tbody>"
                                                        . "<tr>"
                                                        . "<td>IEPC001</td>";
                                                ?>
                                                <table class="table table-striped table-bordered table-hover table-total" style="margin-top: 30px !important;width: 50%;" align="center">
                                                    <thead>
                                                        <tr>
                                                            <th>Indicador</th>
                                                            <th>Ocorrências Notificadas</th>
                                                            <th>Não acatadas</th>
                                                            <th>Acatadas</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>IEPC001</td>
                                                            <!-- Total-->

                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;
                                                            $totalacatada = 0;
                                                            $totalnacatada = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac01 = 0; //3                         
                                                            $naoconformeprazoac01 = 0; //4
                                                            $naoconformeeficaciaac01 = 0; //5
                                                            $indisponibilidadeac01 = 0; //6

                                                            $falhanac01 = 0;     //3                         
                                                            $naoconformeprazonac01 = 0; //4
                                                            $naoconformeeficacianac01 = 0; //5
                                                            $indisponibilidadenac01 = 0; //6

                                                            $totalacatada1 = 0;
                                                            $totalnacatada1 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 4 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada01 += $not->total;
                                                                    $totalacatada1 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac01 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 4 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada01 += $not->total;
                                                                    $totalnacatada1 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac01 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac01 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total01 = $contacat + $contnacat;
                                                            $totalglobal01 += $total01;
                                                            ?>
                                                            <td>{{$total01}}</td>
                                                            <?php $relatorio .= "<td align='center'>$total01</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td> </tr>"; ?>

                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC002</td>"; ?>
                                                        <tr >
                                                            <td>IEPC002</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac02 = 0; //3                         
                                                            $naoconformeprazoac02 = 0; //4
                                                            $naoconformeeficaciaac02 = 0; //5
                                                            $indisponibilidadeac02 = 0; //6

                                                            $falhanac02 = 0;     //3                         
                                                            $naoconformeprazonac02 = 0; //4
                                                            $naoconformeeficacianac02 = 0; //5
                                                            $indisponibilidadenac02 = 0; //6

                                                            $totalacatada2 = 0;
                                                            $totalnacatada2 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 5 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada02 += $not->total;
                                                                    $totalacatada2 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac02 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 5 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada02 += $not->total;
                                                                    $totalnacatada2 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac02 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac02 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total02 = $contacat + $contnacat;
                                                            $totalglobal02 += $total02;
                                                            ?>
                                                            <td>{{$total02}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total02</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td> </tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC003</td>"; ?>
                                                        <tr >
                                                            <td>IEPC003</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac03 = 0; //3                         
                                                            $naoconformeprazoac03 = 0; //4
                                                            $naoconformeeficaciaac03 = 0; //5
                                                            $indisponibilidadeac03 = 0; //6

                                                            $falhanac03 = 0;     //3                         
                                                            $naoconformeprazonac03 = 0; //4
                                                            $naoconformeeficacianac03 = 0; //5
                                                            $indisponibilidadenac03 = 0; //6



                                                            $totalacatada3 = 0;
                                                            $totalnacatada3 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 6 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada03 += $not->total;
                                                                    $totalacatada3 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac03 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 6 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada03 += $not->total;
                                                                    $totalnacatada3 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac03 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac03 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total03 = $contacat + $contnacat;
                                                            $totalglobal03 += $total03;
                                                            ?>
                                                            <td>{{$total03}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total03</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC004</td>"; ?>
                                                        <tr >
                                                            <td>IEPC004</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac04 = 0; //3                         
                                                            $naoconformeprazoac04 = 0; //4
                                                            $naoconformeeficaciaac04 = 0; //5
                                                            $indisponibilidadeac04 = 0; //6

                                                            $falhanac04 = 0;     //3                         
                                                            $naoconformeprazonac04 = 0; //4
                                                            $naoconformeeficacianac04 = 0; //5
                                                            $indisponibilidadenac04 = 0; //6

                                                            $totalacatada4 = 0;
                                                            $totalnacatada4 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 7 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada04 += $not->total;
                                                                    $totalacatada4 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac04 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 7 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada04 += $not->total;
                                                                    $totalnacatada4 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac04 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac04 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total04 = $contacat + $contnacat;
                                                            $totalglobal04 += $total04;
                                                            ?>
                                                            <td>{{$total04}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total04</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC005D</td>"; ?>
                                                        <tr >
                                                            <td>IEPC005D</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac05D = 0; //3                         
                                                            $naoconformeprazoac05D = 0; //4
                                                            $naoconformeeficaciaac05D = 0; //5
                                                            $indisponibilidadeac05D = 0; //6

                                                            $falhanac05D = 0;     //3                         
                                                            $naoconformeprazonac05D = 0; //4
                                                            $naoconformeeficacianac05D = 0; //5
                                                            $indisponibilidadenac05D = 0; //6

                                                            $totalacatada5D = 0;
                                                            $totalnacatada5D = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 8 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada05D += $not->total;
                                                                    $totalacatada5D = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac05D += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 8 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada05D += $not->total;
                                                                    $totalnacatada5D = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac05D += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac05D += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total05D = $contacat + $contnacat;
                                                            $totalglobal05D += $total05D;
                                                            ?>
                                                            <td>{{$total05D}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total05D</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC005P</td>"; ?>
                                                        <tr >
                                                            <td>IEPC005P</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac05P = 0; //3                         
                                                            $naoconformeprazoac05P = 0; //4
                                                            $naoconformeeficaciaac05P = 0; //5
                                                            $indisponibilidadeac05P = 0; //6

                                                            $falhanac05P = 0;     //3                         
                                                            $naoconformeprazonac05P = 0; //4
                                                            $naoconformeeficacianac05P = 0; //5
                                                            $indisponibilidadenac05P = 0; //6

                                                            $totalacatada5P = 0;
                                                            $totalnacatada5P = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 11 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada05P += $not->total;
                                                                    $totalacatada5P = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac05P += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 11 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada05P += $not->total;
                                                                    $totalnacatada5P = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac05P += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac05P += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total05P = $contacat + $contnacat;
                                                            $totalglobal05P += $total05P;
                                                            ?>
                                                            <td>{{$total05P}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total05P</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IEPC006</td>"; ?>
                                                        <tr >
                                                            <td>IEPC006</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac06 = 0; //3                         
                                                            $naoconformeprazoac06 = 0; //4
                                                            $naoconformeeficaciaac06 = 0; //5
                                                            $indisponibilidadeac06 = 0; //6

                                                            $falhanac06 = 0;     //3                         
                                                            $naoconformeprazonac06 = 0; //4
                                                            $naoconformeeficacianac06 = 0; //5
                                                            $indisponibilidadenac06 = 0; //6

                                                            $totalacatada6 = 0;
                                                            $totalnacatada6 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 9 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada06 += $not->total;
                                                                    $totalacatada6 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac06 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 9 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada06 += $not->total;
                                                                    $totalnacatada6 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac06 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac06 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total06 = $contacat + $contnacat;
                                                            $totalglobal06 += $total06;
                                                            ?>
                                                            <td>{{$total06}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total06</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr><td>IDSP001</td>"; ?>
                                                        <tr >
                                                            <td>IDSP001</td>
                                                            <!-- Total-->
                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6

                                                            $falhaac07 = 0; //3                         
                                                            $naoconformeprazoac07 = 0; //4
                                                            $naoconformeeficaciaac07 = 0; //5
                                                            $indisponibilidadeac07 = 0; //6

                                                            $falhanac07 = 0;     //3                         
                                                            $naoconformeprazonac07 = 0; //4
                                                            $naoconformeeficacianac07 = 0; //5
                                                            $indisponibilidadenac07 = 0; //6

                                                            $totalacatada7 = 0;
                                                            $totalnacatada7 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 10 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada07 += $not->total;
                                                                    $totalacatada7 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac += $not->total_mot;
                                                                        $falhaac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac += $not->total_mot;
                                                                        $naoconformeprazoac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac += $not->total_mot;
                                                                        $naoconformeeficaciaac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac += $not->total_mot;
                                                                        $indisponibilidadeac07 += $not->total_mot;
                                                                    }
                                                                } elseif ($not->id_indicador == 10 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada07 += $not->total;
                                                                    $totalnacatada7 = $contnacat;


                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac += $not->total_mot;
                                                                        $falhanac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac += $not->total_mot;
                                                                        $naoconformeprazonac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac += $not->total_mot;
                                                                        $naoconformeeficacianac07 += $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac += $not->total_mot;
                                                                        $indisponibilidadenac07 += $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total07 = $contacat + $contnacat;
                                                            $totalglobal07 += $total07;
                                                            ?>
                                                            <td>{{$total07}}</td>
                                                            <?php $relatorio .= "<td  align='center'>$total07</td>"; ?>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <?php $relatorio .= "<td  align='center'>$contnacat</td>"; ?>
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                            <?php $relatorio .= "<td  align='center'>$contacat</td></tr>"; ?>
                                                        </tr>
                                                        <?php $relatorio .= "<tr style='background: #b3ffb3;'><td>TOTAL</td>"; ?>
                                                        <tr style="background: #b3ffb3;">
                                                            <td>TOTAL</td>
                                                            <td><?= $total01 + $total02 + $total03 + $total04 + $total05D + $total05P + $total06 + $total07; ?></td>
                                                            <?php $totalg1 = $total01 + $total02 + $total03 + $total04 + $total05D + $total05P + $total06 + $total07;
                                                            $relatorio .= "<td  align='center'>$totalg1</td>"; ?>
                                                            <td><?= $totalnacatada1 + $totalnacatada2 + $totalnacatada3 + $totalnacatada4 + $totalnacatada5D + $totalnacatada5P + $totalnacatada6 + $totalnacatada7; ?></td>
                                                            <?php $totalg2 = $totalnacatada1 + $totalnacatada2 + $totalnacatada3 + $totalnacatada4 + $totalnacatada5D + $totalnacatada5P + $totalnacatada6 + $totalnacatada7;
                                                            $relatorio .= "<td  align='center'>$totalg2</td>"; ?>
                                                            <td><?= $totalacatada1 + $totalacatada2 + $totalacatada3 + $totalacatada4 + $totalacatada5D + $totalacatada5P + $totalacatada6 + $totalacatada7; ?></td>
        <?php $totalg3 = $totalacatada1 + $totalacatada2 + $totalacatada3 + $totalacatada4 + $totalacatada5D + $totalacatada5P + $totalacatada6 + $totalacatada7;
        $relatorio .= "<td  align='center'>$totalg3</td></tr>"; ?>

                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <hr>

                                            </div>
                                            <?php
                                            $relatorio .= "</table><center><h2 align='center' style='font-size: 0.85em; margin-top: 5%; margin-bottom: 2%; color: #1c60ab;'>Ocorrências acatadas</h2></center>";
                                            $relatorio .= "<table border='1' class=' table table-striped table-bordered table-hover table-total' style='font-size: 0.85em; width: 90%;border-collapse: collapse; '  align='center'>"
                                                    . "<thead>"
                                                    . "<tr>"
                                                    . "<th>Indicador</th>"
                                                    . "<th>Falha de Conformidade</th>"
                                                    . "<th>Não conforme com o prazo</th>"
                                                    . "<th>Não conforme com a eficácia</th>"
                                                    . "<th>Indisponibilidade de IC</th>"
                                                    . "</tr>"
                                                    . "</thead>"
                                                    . "<tbody>"
                                                    . "<tr>"
                                                    . "<td>IEPC001</td>"
                                                    . "<td>$falhaac01</td>"
                                                    . "<td>$naoconformeprazoac01</td>"
                                                    . "<td>$naoconformeeficaciaac01</td>"
                                                    . "<td>$indisponibilidadeac01</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC002</td>"
                                                    . "<td>$falhaac02</td>"
                                                    . "<td>$naoconformeprazoac02</td>"
                                                    . "<td>$naoconformeeficaciaac02</td>"
                                                    . "<td>$indisponibilidadeac02</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC003</td>"
                                                    . "<td>$falhaac03</td>"
                                                    . "<td>$naoconformeprazoac03</td>"
                                                    . "<td>$naoconformeeficaciaac03</td>"
                                                    . "<td>$indisponibilidadeac03</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC004</td>"
                                                    . "<td>$falhaac04</td>"
                                                    . "<td>$naoconformeprazoac04</td>"
                                                    . "<td>$naoconformeeficaciaac04</td>"
                                                    . "<td>$indisponibilidadeac04</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC005D</td>"
                                                    . "<td>$falhaac05D</td>"
                                                    . "<td>$naoconformeprazoac05D</td>"
                                                    . "<td>$naoconformeeficaciaac05D</td>"
                                                    . "<td>$indisponibilidadeac05D</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC005D</td>"
                                                    . "<td>$falhaac05P</td>"
                                                    . "<td>$naoconformeprazoac05P</td>"
                                                    . "<td>$naoconformeeficaciaac05P</td>"
                                                    . "<td>$indisponibilidadeac05P</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC006</td>"
                                                    . "<td>$falhaac06</td>"
                                                    . "<td>$naoconformeprazoac06</td>"
                                                    . "<td>$naoconformeeficaciaac06</td>"
                                                    . "<td>$indisponibilidadeac06</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IDSP001</td>"
                                                    . "<td>$falhaac07</td>"
                                                    . "<td>$naoconformeprazoac07</td>"
                                                    . "<td>$naoconformeeficaciaac07</td>"
                                                    . "<td>$indisponibilidadeac07</td>"
                                                    . "</tr>"
                                                    . "</tbody></table>";
                                            $relatorio .= "<center><h2 align='center' style=' font-size: 0.85em; margin-top: 5%; margin-bottom: 2%; color: #1c60ab;'>Ocorrências não acatadas</h2></center><table border='1' class=' $pular table table-striped table-bordered table-hover table-total' style=' font-size: 0.85em; width: 90%;border-collapse: collapse; '  align='center'>"
                                                    . "<thead>"
                                                    . "<tr>"
                                                    . "<th>Indicador</th>"
                                                    . "<th>Falha de Conformidade</th>"
                                                    . "<th>Não conforme com o prazo</th>"
                                                    . "<th>Não conforme com a eficácia</th>"
                                                    . "<th>Indisponibilidade de IC</th>"
                                                    . "</tr>"
                                                    . "</thead>"
                                                    . "<tbody>"
                                                    . "<tr>"
                                                    . "<td>IEPC001</td>"
                                                    . "<td>$falhanac01</td>"
                                                    . "<td>$naoconformeprazonac01</td>"
                                                    . "<td>$naoconformeeficacianac01</td>"
                                                    . "<td>$indisponibilidadenac01</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC002</td>"
                                                    . "<td>$falhanac02</td>"
                                                    . "<td>$naoconformeprazonac02</td>"
                                                    . "<td>$naoconformeeficacianac02</td>"
                                                    . "<td>$indisponibilidadenac02</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC003</td>"
                                                    . "<td>$falhanac03</td>"
                                                    . "<td>$naoconformeprazonac03</td>"
                                                    . "<td>$naoconformeeficacianac03</td>"
                                                    . "<td>$indisponibilidadenac03</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC004</td>"
                                                    . "<td>$falhanac04</td>"
                                                    . "<td>$naoconformeprazonac04</td>"
                                                    . "<td>$naoconformeeficacianac04</td>"
                                                    . "<td>$indisponibilidadenac04</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC005D</td>"
                                                    . "<td>$falhanac05D</td>"
                                                    . "<td>$naoconformeprazonac05D</td>"
                                                    . "<td>$naoconformeeficacianac05D</td>"
                                                    . "<td>$indisponibilidadenac05D</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC005D</td>"
                                                    . "<td>$falhanac05P</td>"
                                                    . "<td>$naoconformeprazonac05P</td>"
                                                    . "<td>$naoconformeeficacianac05P</td>"
                                                    . "<td>$indisponibilidadenac05P</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IEPC006</td>"
                                                    . "<td>$falhanac06</td>"
                                                    . "<td>$naoconformeprazonac06</td>"
                                                    . "<td>$naoconformeeficacianac06</td>"
                                                    . "<td>$indisponibilidadenac06</td>"
                                                    . "</tr>"
                                                    . "<tr>"
                                                    . "<td>IDSP001</td>"
                                                    . "<td>$falhanac07</td>"
                                                    . "<td>$naoconformeprazonac07</td>"
                                                    . "<td>$naoconformeeficacianac07</td>"
                                                    . "<td>$indisponibilidadenac07</td>"
                                                    . "</tr>"
                                                    . "</tbody></table>";
                                        }//<!-- fechamento for -->
                                        ?><!-- fechamento for -->


                                        <?php
                                        $relatorio .= "<div style:'margin-top: 30%;float: left;'><center><h2 align='center' style='font-size: 0.85em; margin-top: 5%; margin-bottom: 2%; color: #1c60ab;'>TOTAL GLOBAL</h2></center></div>";
                                        $relatorio .= "<table border='1' class='table table-striped table-bordered table-hover table-total' style='width: 70%;border-collapse: collapse;'  align='center'>"
                                                . "<thead>"
                                                . "<tr>"
                                                . "<th>Indicador</th>"
                                                . "<th>Ocorrências Notificadas</th>"
                                                . "<th>Acatadas</th>"
                                                . "<th>Não acatadas</th>"
                                                . "</tr>"
                                                . "</thead>"
                                                . "<tbody>"
                                                . "<tr>"
                                                . "<td style='background: #ffb3ff;'>IEPC001</td>";
                                        ?>
                                        <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">Relatorio mês de <?= $titulo_mes; ?>: TOTAL GLOBAL </h1></center>
                                        <table class="table table-striped  table-total" style="text-align: center; margin-top: 30px !important;width: 55%;" align="center">
                                            <thead>
                                                <tr>
                                                    <th>Indicador</th>
                                                    <th>Ocorrências Notificadas</th>
                                                    <th>Acatadas</th>
                                                    <th>Não acatadas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="background: #ffb3ff;">IEPC001</td>
                                                    <td><?= $totalglobal01; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal01</td>"; ?>
                                                    <td><?= $totalacatada01; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada01</td>"; ?>
                                                    <td><?= $totalnacatada01; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada01</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3b3;">IEPC002</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #ffb3b3;'>IEPC002</td>"; ?>
                                                    <td><?= $totalglobal02; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal02</td>"; ?>
                                                    <td><?= $totalacatada02; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada02</td>"; ?>
                                                    <td><?= $totalnacatada02; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada02</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffffb3;">IEPC003</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #ffffb3;'>IEPC003</td>"; ?>
                                                    <td><?= $totalglobal03; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal03</td>"; ?>
                                                    <td><?= $totalacatada03; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada03</td>"; ?>
                                                    <td><?= $totalnacatada03; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada03</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #b3b3ff;">IEPC004</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #b3b3ff;'>IEPC004</td>"; ?>
                                                    <td><?= $totalglobal04; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal04</td>"; ?>
                                                    <td><?= $totalacatada04; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada04</td>"; ?>
                                                    <td><?= $totalnacatada04; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada04</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3d9;">IEPC005D</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #ffb3d9;'>IEPC005D</td>"; ?>
                                                    <td><?= $totalglobal05D; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal05D</td>"; ?>
                                                    <td><?= $totalacatada05D; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada05D</td>"; ?>
                                                    <td><?= $totalnacatada05D; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada05D</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3d9;">IEPC005P</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #ffb3d9;'>IEPC005P</td>"; ?>
                                                    <td><?= $totalglobal05P; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal05P</td>"; ?>
                                                    <td><?= $totalacatada05P; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada05P</td>"; ?>
                                                    <td><?= $totalnacatada05P; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada05P</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #b3d9ff;">IEPC006</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #b3d9ff;'>IEPC006</td>"; ?>
                                                    <td><?= $totalglobal06; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal06</td>"; ?>
                                                    <td><?= $totalacatada06; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada06</td>"; ?>
                                                    <td><?= $totalnacatada06; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada06</td></tr>"; ?>
                                                <tr>
                                                <tr>
                                                    <td style="background: #d9d9d9;">IDSP001</td>
                                                    <?php $relatorio .= "<tr><td  style='background: #d9d9d9;'>IDSP001</td>"; ?>
                                                    <td><?= $totalglobal07; ?></td>
                                                    <?php $relatorio .= "<td  align='center'>$totalglobal07</td>"; ?>
                                                    <td><?= $totalacatada07; ?> </td>
                                                    <?php $relatorio .= "<td  align='center'>$totalacatada07</td>"; ?>
                                                    <td><?= $totalnacatada07; ?></td>
    <?php $relatorio .= "<td  align='center'>$totalnacatada07</td></tr>"; ?>
                                                <tr>
                                                <tr style="background: #b3ffb3;">
                                                    <td>TOTAL GLOBAL</td>
                                                    <?php $relatorio .= "<tr style='background: #b3ffb3;'><td>TOTAL GLOBAL</td>"; ?>
                                                    <td><?= $totalglobal01 + $totalglobal02 + $totalglobal03 + $totalglobal04 + $totalglobal05D + $totalglobal05P + $totalglobal06 + $totalglobal07; ?></td>
                                                    <?php $totalgg1 = $totalglobal01 + $totalglobal02 + $totalglobal03 + $totalglobal04 + $totalglobal05D + $totalglobal05P + $totalglobal06 + $totalglobal07;
                                                    $relatorio .= "<td  align='center'>$totalgg1</td>"; ?>
                                                    <td><?= $totalacatada01 + $totalacatada02 + $totalacatada03 + $totalacatada04 + $totalacatada05D + $totalacatada05P + $totalacatada06 + $totalacatada07; ?> </td>
                                                    <?php $totalgg2 = $totalacatada01 + $totalacatada02 + $totalacatada03 + $totalacatada04 + $totalacatada05D + $totalacatada05P + $totalacatada06 + $totalacatada07;
                                                    $relatorio .= "<td  align='center'>$totalgg2</td>"; ?>
                                                    <td><?= $totalnacatada01 + $totalnacatada02 + $totalnacatada03 + $totalnacatada04 + $totalnacatada05D + $totalnacatada05P + $totalnacatada06 + $totalnacatada07; ?></td>
                                        <?php $totalgg3 = $totalnacatada01 + $totalnacatada02 + $totalnacatada03 + $totalnacatada04 + $totalnacatada05D + $totalnacatada05P + $totalnacatada06 + $totalnacatada07;
                                        $relatorio .= "<td  align='center'>$totalgg3</td></tr>"; ?>
                                                <tr>
                                            </tbody>
                                        </table>
                                    <?php $relatorio .= "</tbody></table>"; ?>

                                    </div> <!-- panel-body -->
                                    <?php
                                    $relatorio .= "</body></html>";
                                    //echo $relatorio;
                                    session()->put('relatorio', $relatorio);
                                    ?>
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
