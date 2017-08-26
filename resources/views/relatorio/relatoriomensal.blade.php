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
                                            } else {
                                                $mes = Carbon\Carbon::now()->month;
                                            }
                                            ?>
                                            <select class="select2" id="id_contrato" name="id_contrato" data-placeholder="Contrato" title="Selecione um contrato" required>
                                                <option value=""></option>

                                                @foreach ($Contratos as $Contrato)
                                                <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option>
                                                @endforeach

                                            </select>

                                            <select class="select2" id="id_coordenacao" name="id_coordenacao"  data-placeholder="Selecione uma Coordenação ou nehuma para todas!">
                                                <option value="999">Selecione uma Coordenação ou nehuma para todas!</option>
                                                @foreach ($Coordenacoes as $Coordenacao)
                                                <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                                @endforeach

                                            </select>

                                            <select name="mes" class="select2" data-placeholder="Mês" title="Selecione o mês visualizar" >
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

                                    $totalacatada =  0;
                                    $totalnacatada = 0;
                                    if ($All != 'vazio') {
                                        $titulo_contrato = \App\Models\Contrato::find($_POST['id_contrato']);
                                        if ($_POST['id_coordenacao'] != 999) {
                                            $i = $_POST['id_coordenacao'];
                                            $tam = $_POST['id_coordenacao'];
                                        } else {
                                            $i = 1;
                                            $tam = 19;
                                        }
                                        ?>
                                        <?php
                                        for ($i; $i <= $tam; $i++) {

                                            foreach ($Coordenacoes as $cord) {
                                                if ($cord->id_coordenacao == $i) {
                                                    $titulo_coordenacao = $cord->ds_coordenacao;
                                                }
                                            }
                                            ?>

                                            <center><h1 style="font-size: 2em; margin-top:40px; margin-bottom: 40px; color: #1c60ab;">Relatorio mês de <?= $titulo_mes; ?>: <?= $titulo_contrato['nu_contrato'] ?> - <?= $titulo_coordenacao; ?> </h1></center>

                                            <div class="table-responsive">

                                                <table  class="table table-bordered table-striped-col dataTable1">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>DATA</th>
                                                            <th>CONTRATO</th>
                                                            <th>EQUIPE NOTIFICADORA</th>
                                                            <th>Indicador</th>
                                                            <th>Descrição</th>
                                                            <th>STATUS</th>
                                                            <th>AÇÕES</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @foreach ($Notificacoes as $n)
                                                        <?php if ($n->id_notificadora == $i) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="../notificacao/ver/{{ Crypt::encrypt($n->id_notificacao) }}">{{ $n->nu_notificacao }}</a>
                                                                </td>
                                                                <td>{{ Carbon\Carbon::parse($n->created_at)->format('d/m/Y') }}</td>
                                                                <td>{{ $n->nu_contrato }}</td>


                                                                @foreach ($Coordenacoes as $Coordenacao)
                                                                @if ($n->id_notificadora === $Coordenacao->id_coordenacao)
                                                                <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                                @endif
                                                                @endforeach

                                                                <td>{{$n->sg_indicador}}</td>
                                                                <td>{{strip_tags($n->ds_notificacao)}}</td>
                                                                <td>
                                                                    @if($n->bit_aceito == 9)
                                                                    Não autorizado
                                                                    @endif

                                                                    @if($n->bit_aceito == 99)
                                                                    Não autorizado - Tempo de resposta esgotado!
                                                                    @endif

                                                                    @if($n->bit_aceito == 55)
                                                                    Justificativa Não acatada - Tempo de resposta esgotado!
                                                                    @endif

                                                                    @if($n->bit_aceito == 44)
                                                                    Justificativa Acatada - Tempo de resposta esgotado!
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


                                                                <td>
                                                                    <!--  Verifica se a pessoa é gestor-->
                                                                    <!--  Verifica se a pessoa é gestor-->
                                                                    @if(Session::get('isgestor') == 1)
                                                                    @if($n->dt_naoacatado == NULL && $n->bit_aceito == 1)
                                                                    <a href="../notificacao/autorizar/{{ Crypt::encrypt($n->id_notificacao) }}">Autorizar</a>
                                                                    |
                                                                    @endif
                                                                    @endif


                                                                    <!--  Verifica se a pessoa é preposto -->
                                                                    @if(Session::get('ispreposto') == 1)
                                                                    @if($n->bit_aceito == 2)
                                                                    <a href="../notificacao/justificar/{{ Crypt::encrypt($n->id_notificacao) }}">Justificar</a>
                                                                    |
                                                                    @endif
                                                                    @endif

                                                                    @if(Session::get('isgestor') == 1)
                                                                    @if($n->bit_aceito == 3)
                                                                    <a href="../notificacao/avaliar/{{ Crypt::encrypt($n->id_notificacao) }}">Avaliar</a>
                                                                    |
                                                                    @endif
                                                                    @endif

                                                                    <!--  Verifica se a pessoa é agente de RH e Contratos-->
                                                                    @if(Session::get('isrh') == 1)
                                                                    @if($n->bit_aceito == 5)
                                                                    <a href="../notificacao/corrigir/{{ Crypt::encrypt($n->id_notificacao) }}">Corrigir</a>
                                                                    |
                                                                    <a href="../notificacao/devolverpreposto/{{ Crypt::encrypt($n->id_notificacao) }}">Devolver preposto</a>
                                                                    |
                                                                    @endif
                                                                    @endif


                                                                    <a href="../notificacao/ver/{{ Crypt::encrypt($n->id_notificacao) }}">Informações</a>

                                                                    <!--
                                                # COLOCAR ESSAS FUNCIONALIDADES NA PROXIMA VERSÃO
                    
                                                | <a href="notificacao/acatamentoespecial/{{ $n->id_notificacao }}">Acatamento especial</a>
                                                | <a href="notificacao/historico/{{ $n->id_notificacao }}">Histórico</a>
                                                                    -->


                                                                </td>
                                                            </tr>
                                                        <?php } ?><!-- fechamento if do for notificadora-->
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                                
                                                <table class="table table-striped  table-total" style="margin-top: 30px !important;width: 50%;" align="center">
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
                                                            <td style="background: #ffb3ff;">IEPC001</td>
                                                            <!-- Total-->

                                                            <?php
                                                            $contacat = 0;
                                                            $contnacat = 0;
                                                            $totalacatada =  0;
                                                            $totalnacatada = 0;

                                                            $falhaac = 0; //3                         
                                                            $naoconformeprazoac = 0; //4
                                                            $naoconformeeficaciaac = 0; //5
                                                            $indisponibilidadeac = 0; //6

                                                            $falhanac = 0;     //3                         
                                                            $naoconformeprazonac = 0; //4
                                                            $naoconformeeficacianac = 0; //5
                                                            $indisponibilidadenac = 0; //6
                                                            
                                                            $totalacatada1 = 0;
                                                            $totalnacatada1 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 4 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada01 = $contacat;
                                                                    $totalacatada1 = $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac =  $not->total_mot;
                                                                        
                                                                        
                                                                    }
                                                                } elseif ($not->id_indicador == 4 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada01 = $contnacat;
                                                                    $totalnacatada1 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total01 = $contacat + $contnacat;
                                                            $totalglobal01 += $total01;
                                                            ?>
                                                            <td>{{$total01}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>

                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #ffb3b3;">IEPC002</td>
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
                                                            
                                                            $totalacatada2 = 0;
                                                            $totalnacatada2 = 0;

                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 5 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada02 = $contacat;
                                                                    $totalacatada2 =  $contacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 5 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada02 = $contnacat;
                                                                    $totalnacatada2 = $contnacat;

                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total02 = $contacat + $contnacat;
                                                            $totalglobal02 += $total02;
                                                            ?>
                                                            <td>{{$total02}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>

                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #ffffb3;">IEPC003</td>
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
                                                            
                                                            $totalacatada3 = 0;
                                                            $totalnacatada3 = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 6 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada03 = $contacat;
                                                                    $totalacatada3 =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 6 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada03 = $contnacat;
                                                                    $totalnacatada3 = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total03 = $contacat + $contnacat;
                                                            $totalglobal03 += $total03;
                                                            ?>
                                                            <td>{{$total03}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>

                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #b3b3ff;">IEPC004</td>
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
                                                            
                                                            $totalacatada4 = 0;
                                                            $totalnacatada4 = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 7 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada04 = $contacat;
                                                                    $totalacatada4 =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 7 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada04 = $contnacat;
                                                                    $totalnacatada4 = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total04 = $contacat + $contnacat;
                                                            $totalglobal04 += $total04;
                                                            ?>
                                                            <td>{{$total04}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #ffb3d9;">IEPC005D</td>
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
                                                            
                                                            $totalacatada5D = 0;
                                                            $totalnacatada5D = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 8 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada05D = $contacat;
                                                                    $totalacatada5D =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 8 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada05D = $contnacat;
                                                                    $totalnacatada5D = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total05D = $contacat + $contnacat;
                                                            $totalglobal05P += $total05D;
                                                            ?>
                                                            <td>{{$total05D}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>

                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #ffb3d9;">IEPC005P</td>
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
                                                            
                                                            $totalacatada5P = 0;
                                                            $totalnacatada5P = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 11 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada05P = $contacat;
                                                                    $totalacatada5P =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 11 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada05P = $contnacat;
                                                                    $totalnacatada5P = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total05P = $contacat + $contnacat;
                                                            $totalglobal05P += $total05P;
                                                            ?>
                                                            <td>{{$total05P}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #b3d9ff;">IEPC006</td>
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
                                                            
                                                            $totalacatada6 = 0;
                                                            $totalnacatada6 = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 9 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada06 = $contacat;
                                                                    $totalacatada6 =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 9 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada06 = $contnacat;
                                                                    $totalnacatada6 = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total06 = $contacat + $contnacat;
                                                            $totalglobal06 += $total06;
                                                            ?>
                                                            <td>{{$total06}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr >
                                                            <td style="background: #d9d9d9;">IDSP001</td>
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
                                                            
                                                            $totalacatada7 = 0;
                                                            $totalnacatada7 = 0;
                                                            
                                                            foreach ($All as $not):
                                                                if ($not->id_indicador == 10 && $not->id_notificadora == $i && ($not->bit_aceito == 4 || $not->bit_aceito == 44)) {
                                                                    $contacat += $not->total;
                                                                    $totalacatada07 = $contacat;
                                                                    $totalacatada7 =  $contacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhaac = $falhaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazoac = $naoconformeprazoac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficaciaac = $naoconformeeficaciaac + 1;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadeac = $indisponibilidadeac + 1;
                                                                    }
                                                                } elseif ($not->id_indicador == 10 && $not->id_notificadora == $i && ($not->bit_aceito == 5 || $not->bit_aceito == 55)) {
                                                                    $contnacat += $not->total;
                                                                    $totalnacatada07 = $contnacat;
                                                                    $totalnacatada7 = $contnacat;
                                                                    
                                                                    if ($not->id_motivo == 3) {
                                                                        $falhanac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 4) {
                                                                        $naoconformeprazonac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 5) {
                                                                        $naoconformeeficacianac = $not->total_mot;
                                                                    }
                                                                    if ($not->id_motivo == 6) {
                                                                        $indisponibilidadenac = $not->total_mot;
                                                                    }
                                                                }
                                                            endforeach;
                                                            $total07 = $contacat + $contnacat;
                                                            $totalglobal07 += $total07;
                                                            ?>
                                                            <td>{{$total07}}</td>
                                                            <!-- Not Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhanac; ?> | Não conforme com o prazo - <?= $naoconformeprazonac; ?> | Não conforme com a  eficácia <?= $naoconformeeficacianac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadenac; ?> ">{{$contnacat}}</div></td>                                                     
                                                            <!-- Acat-->
                                                            <td><div data-toggle="tooltip" title="Falha de conformidade - <?= $falhaac; ?> | Não conforme com o prazo - <?= $naoconformeprazoac; ?> | Não conforme com a  eficácia <?= $naoconformeeficaciaac; ?> | Indisponibilidade de IC |  <?= $indisponibilidadeac; ?> ">{{$contacat}}</div></td>
                                                        </tr>
                                                        <tr style="background: #b3ffb3;">
                                                            <td>TOTAL</td>
                                                            <td><?= $total01 + $total02 + $total03 + $total04 + $total05D + $total05P + $total06 + $total07; ?></td>
                                                            <td><?= $totalnacatada1 + $totalnacatada2 + $totalnacatada3 + $totalnacatada4 + $totalnacatada5D + $totalnacatada5P + $totalnacatada6 + $totalnacatada7; ?></td>
                                                            <td><?= $totalacatada1 + $totalacatada2 + $totalacatada3 + $totalacatada4 + $totalacatada5D + $totalacatada5P + $totalacatada6 + $totalacatada7; ?></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <hr>

                                            </div>
                                        <?php } ?><!-- fechamento for -->
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
                                                    <td><?= $totalacatada01; ?> </td>
                                                    <td><?= $totalnacatada01; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3b3;">IEPC002</td>
                                                    <td><?= $totalglobal02; ?></td>
                                                    <td><?= $totalacatada02; ?> </td>
                                                    <td><?= $totalnacatada02; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffffb3;">IEPC003</td>
                                                    <td><?= $totalglobal03; ?></td>
                                                    <td><?= $totalacatada03; ?> </td>
                                                    <td><?= $totalnacatada03; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #b3b3ff;">IEPC004</td>
                                                    <td><?= $totalglobal04; ?></td>
                                                    <td><?= $totalacatada04; ?> </td>
                                                    <td><?= $totalnacatada04; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3d9;">IEPC005D</td>
                                                    <td><?= $totalglobal05D; ?></td>
                                                    <td><?= $totalacatada05D; ?> </td>
                                                    <td><?= $totalnacatada05D; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #ffb3d9;">IEPC005P</td>
                                                    <td><?= $totalglobal05P; ?></td>
                                                    <td><?= $totalacatada05P; ?> </td>
                                                    <td><?= $totalnacatada05P; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #b3d9ff;">IEPC006</td>
                                                    <td><?= $totalglobal06; ?></td>
                                                    <td><?= $totalacatada06; ?> </td>
                                                    <td><?= $totalnacatada06; ?></td>
                                                <tr>
                                                <tr>
                                                    <td style="background: #d9d9d9;">IDSP001</td>
                                                    <td><?= $totalglobal07; ?></td>
                                                    <td><?= $totalacatada07; ?> </td>
                                                    <td><?= $totalnacatada07; ?></td>
                                                <tr>
                                                <tr style="background: #b3ffb3;">
                                                    <td>TOTAL GLOBAL</td>
                                                    <td><?= $totalglobal01 + $totalglobal02 + $totalglobal03 + $totalglobal04 + $totalglobal05D + $totalglobal05P + $totalglobal06 + $totalglobal07; ?></td>
                                                    <td><?= $totalacatada01 + $totalacatada02 + $totalacatada03 + $totalacatada04 + $totalacatada05D + $totalacatada05P + $totalacatada06 + $totalacatada07; ?> </td>
                                                    <td><?= $totalnacatada01 + $totalnacatada02 + $totalnacatada03 + $totalnacatada04 + $totalnacatada05D + $totalnacatada05P + $totalnacatada06 + $totalnacatada07; ?></td>
                                                <tr>
                                            </tbody>
                                        </table>

                                    </div> <!-- panel-body -->
                                <?php } ?>
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
