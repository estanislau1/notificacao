@include('Default.head')

<body>
    @include('Default.header')


    <section>
        @include('Default.leftpanel2')



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
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Descumprimentos contratuais registrados</a></li>
                </ul>
                <!--Final da ABAS DA TAB --> 


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Verifique os descumprimentos registrados no sistema.</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="dataTable1" class="table table-bordered table-striped-col">
                                            <thead>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>DATA</th>
                                                    <th>CONTRATO</th>
                                                    <th>COORDENAÇÃO</th>
                                                    <th>TÍTULO</th>
                                                    <th>TIPO</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>
                                                    <th>AÇÕES</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>DATA</th>
                                                    <th>CONTRATO</th>                          
                                                    <th>COORDENAÇÃO</th>                          
                                                    <th>TÍTULO</th>
                                                    <th>TIPO</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>
                                                    <th>AÇÕES</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $cont = 1;
                                                $id_contrato_prep = DB::table('PREPOSTO')->where('ma_preposto', session('matricula'))->value('id_contrato');
                                                //var_dump($id_contrato_prep);
                                                ?>
                                                @foreach ($Descumprimento as $n)
                                                @if($n->id_contrato == $id_contrato_prep && $id_contrato_prep <> NULL)
                                                <tr>
                                                    <td><a href="descumprimento/ver/{{ Crypt::encrypt($n->id_descumprimento) }}">{{ $n->nu_descumprimento }}</a></td>
                                                    <td>{{ Carbon\Carbon::parse($n->created_at)->format('d/m/Y') }}</td>
                                                    <td>{{ $n->nu_contrato }}</td>
                                                    @foreach ($Coordenacoes as $Coordenacao)
                                                    @if ($n->id_impactada === $Coordenacao->id_coordenacao)
                                                    <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                    @endif
                                                    @endforeach
                                                    <td>{{ $n->ds_titulo }}</td>
                                                    <td>
                                                        @if ($n->tipo === 1)
                                                        Advertência
                                                        @elseif($n->tipo === 2)
                                                        Multa
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($n->status == 11) 
                                                        Aguardando análise interna do RH
                                                        @endif

                                                        @if($n->status == 111) 
                                                        Aguardando análise interna do RH
                                                        @endif

                                                        @if($n->status == 1) 
                                                        Aguardando análise interna
                                                        @endif

                                                        @if($n->status == 2) 
                                                        Aguardando avaliação da Coordenação
                                                        @endif

                                                        @if($n->status == 3) 
                                                        Aguardando avaliação da gerência
                                                        @endif

                                                        @if($n->status == 6) 
                                                        Aguardando avaliação do RH
                                                        @endif

                                                        @if($n->status == 7) 
                                                        Aguardando avaliação da Empresa
                                                        @endif

                                                        @if($n->status == 8) 
                                                        Aguardando avaliação da Coordenação
                                                        @endif

                                                        @if($n->status == 4) 
                                                        Descumprimento Acatado
                                                        @endif
                                                        @if($n->status == 44) 
                                                        Descumprimento Acatado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 5) 
                                                        Justificativa não Acatada
                                                        @endif
                                                        @if($n->status == 55) 
                                                        Descumprimento não acatado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 9) 
                                                        Descumprimento contratual desconsiderado por determinação da Coordenação
                                                        @endif
                                                        @if($n->status == 99) 
                                                        Descumprimento contratual desconsiderado por determinação da Gerência
                                                        @endif
                                                        @if($n->status == 999) 
                                                        Descumprimento contratual desconsiderado por determinação da Logística
                                                        @endif
                                                        @if($n->status == 9999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 3999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 2999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 6999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif

                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($n->prazo)->format('d/m/Y H:i')}}</td>
                                                    <td style="width: 20%;">

                                                        <!--  Verifica se a pessoa é preposto -->
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 11)
                                                        <a href="descumprimento/avaliar/{{ Crypt::encrypt($n->id_descumprimento) }}">Retificação minuta - Coordenação</a> |     	                          
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 111)
                                                        <a href="descumprimento/avaliar/{{ Crypt::encrypt($n->id_descumprimento) }}">Retificação minuta - Gerência</a> |     	                          
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isgestor') == 1)
                                                        @if($n->status == 2)
                                                        <a href="descumprimento/avaliarcoordenacao/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar minuta</a> |                                
                                                        @endif 
                                                        @endif                                                        

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 3)
                                                        <a href="descumprimento/avaliargerente/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar decisão da coordenação</a> |                                
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 6)
                                                        <a href="descumprimento/avaliarrh/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar decisão da gerência</a> |                                
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('ispreposto') == 1)
                                                        @if($n->status == 7)
                                                        <a href="descumprimento/justificar/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar Descumprimento </a> |     	                          
                                                        @endif
                                                        @endif

                                                        @if(Session::get('isgestor') == 1)
                                                        @if($n->status == 8)
                                                        <a href="descumprimento/avaliarresposta/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar Empresa</a> |                                
                                                        @endif 
                                                        @endif     

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 55)
                                                        <a href="descumprimento/devolverempresa/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Empresa</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44)
                                                        <a href="descumprimento/devolvercaixa/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Caixa</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 3999)
                                                        <a href="descumprimento/devolvergerente/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Gerente</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 2999)
                                                        <a href="descumprimento/devolvercoordenacao/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Coordenação</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 6999)
                                                        <a href="descumprimento/devolverrh/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Logística</a> |
                                                        @endif
                                                        @endif

                                                        <a href="descumprimento/ver/{{ Crypt::encrypt($n->id_descumprimento) }}">Informações</a>
                                                        <?php
                                                        $id_ci = 'div_ci' . $cont;
                                                        $id_siclg = 'div_siclg' . $cont;
                                                        $id_oficio = 'div_oficio' . $cont;
                                                        $link = $cont;
                                                        ?>
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 4 || $n->status == 5)

                                                        | <a class="link_ci" style="cursor: pointer;" data-id="{{$link}}">CI</a> |
                                                        <a class="link_siclg" style="cursor: pointer;" data-id="{{$link}}">SICLG</a> |
                                                        <a class="link_oficio" style="cursor: pointer;" data-id="{{$link}}">PARECER</a>                                 
                                                        @endif 
                                                        @endif

                                                        <br>

                                                        <div id="{{$id_ci}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addci/")}}' method="post">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="ci" type="text"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                        <div id="{{$id_siclg}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addsiclg/")}}' method="post">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="siclg" type="text"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                        <div id="{{$id_oficio}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addoficio/")}}' method="post">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="oficio" type="text"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                </tr>
                                                @elseif(Session::get('isgestor') == 1 || Session::get('isrh') == 1 || Session::get('issupervisor') == 1 || (substr(session('matricula'), 0, 1)) == 'c')
                                                <tr>
                                                    <td><a href="descumprimento/ver/{{ Crypt::encrypt($n->id_descumprimento) }}">{{ $n->nu_descumprimento }}</a></td>
                                                    <td>{{ Carbon\Carbon::parse($n->created_at)->format('d/m/Y') }}</td>
                                                    <td>{{ $n->nu_contrato }}</td>
                                                    @foreach ($Coordenacoes as $Coordenacao)
                                                    @if ($n->id_impactada === $Coordenacao->id_coordenacao)
                                                    <td>{{ $Coordenacao->no_coordenacao }}</td>
                                                    @endif
                                                    @endforeach
                                                    <td>{{ $n->ds_titulo }}</td>
                                                    <td>
                                                        @if ($n->tipo === 1)
                                                        Advertência
                                                        @elseif($n->tipo === 2)
                                                        Multa
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($n->status == 1) 
                                                        Aguardando análise interna
                                                        @endif

                                                        @if($n->status == 11) 
                                                        Aguardando análise interna do RH
                                                        @endif

                                                        @if($n->status == 111) 
                                                        Aguardando análise interna do RH
                                                        @endif

                                                        @if($n->status == 2) 
                                                        Aguardando avaliação da Coordenação
                                                        @endif

                                                        @if($n->status == 3) 
                                                        Aguardando avaliação da gerência
                                                        @endif

                                                        @if($n->status == 6) 
                                                        Aguardando avaliação do RH
                                                        @endif

                                                        @if($n->status == 7) 
                                                        Aguardando avaliação da Empresa
                                                        @endif

                                                        @if($n->status == 8) 
                                                        Aguardando avaliação da Coordenação
                                                        @endif

                                                        @if($n->status == 4) 
                                                        Descumprimento Acatado
                                                        @endif
                                                        @if($n->status == 44) 
                                                        Descumprimento Acatado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 5) 
                                                        Justificativa não Acatada
                                                        @endif
                                                        @if($n->status == 55) 
                                                        Descumprimento não acatado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 9) 
                                                        Descumprimento contratual desconsiderado por determinação da Coordenação
                                                        @endif
                                                        @if($n->status == 99) 
                                                        Descumprimento contratual desconsiderado por determinação da Gerência
                                                        @endif
                                                        @if($n->status == 999) 
                                                        Descumprimento contratual desconsiderado por determinação da Logística
                                                        @endif
                                                        @if($n->status == 9999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 3999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 2999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif
                                                        @if($n->status == 6999) 
                                                        Descumprimento contratual cancelado - Prazo excedido!
                                                        @endif

                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($n->prazo)->format('d/m/Y H:i')}}</td>
                                                    <td style="width: 20%;">

                                                        <!--  Verifica se a pessoa é preposto -->
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 1)
                                                        <a href="descumprimento/avaliar/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliação interna</a> |     	                          
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 11)
                                                        <a href="descumprimento/avaliar/{{ Crypt::encrypt($n->id_descumprimento) }}">Retificação minuta - Coordenação</a> |     	                          
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 111)
                                                        <a href="descumprimento/avaliar/{{ Crypt::encrypt($n->id_descumprimento) }}">Retificação minuta - Gerência</a> |     	                          
                                                        @endif 
                                                        @endif                                                        

                                                        @if(Session::get('isgestor') == 1)
                                                        @if($n->status == 2)
                                                        <a href="descumprimento/avaliarcoordenacao/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar minuta</a> |                                
                                                        @endif 
                                                        @endif                                                        

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 3)
                                                        <a href="descumprimento/avaliargerente/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar decisão da coordenação</a> |                                
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 6)
                                                        <a href="descumprimento/avaliarrh/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar decisão da gerência</a> |                                
                                                        @endif 
                                                        @endif

                                                        @if(Session::get('ispreposto') == 1)
                                                        @if($n->status == 7)
                                                        <a href="descumprimento/justificar/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar Descumprimento </a> |     	                          
                                                        @endif
                                                        @endif

                                                        @if(Session::get('isgestor') == 1)
                                                        @if($n->status == 8)
                                                        <a href="descumprimento/avaliarresposta/{{ Crypt::encrypt($n->id_descumprimento) }}">Avaliar Empresa</a> |                                
                                                        @endif 
                                                        @endif     

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 55)
                                                        <a href="descumprimento/devolverempresa/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Empresa</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44)
                                                        <a href="descumprimento/devolvercaixa/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Caixa</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 3999)
                                                        <a href="descumprimento/devolvergerente/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Gerente</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 2999)
                                                        <a href="descumprimento/devolvercoordenacao/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Coordenação</a> |
                                                        @endif
                                                        @endif
                                                        
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 6999)
                                                        <a href="descumprimento/devolverrh/{{ Crypt::encrypt($n->id_descumprimento) }}">Devolver Logística</a> |
                                                        @endif
                                                        @endif

                                                        <a href="descumprimento/ver/{{ Crypt::encrypt($n->id_descumprimento) }}">Informações</a>
                                                        <?php
                                                        $id_ci = 'div_ci' . $cont;
                                                        $id_siclg = 'div_siclg' . $cont;
                                                        $id_oficio = 'div_oficio' . $cont;
                                                        $link = $cont;
                                                        ?>
                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 4 || $n->status == 5)

                                                        | <a class="link_ci" style="cursor: pointer;" data-id="{{$link}}">CI</a> |
                                                        <a class="link_siclg" style="cursor: pointer;" data-id="{{$link}}">SICLG</a> |
                                                        <a class="link_oficio" style="cursor: pointer;" data-id="{{$link}}">PARECER</a>                                 
                                                        @endif 
                                                        @endif

                                                        <br>

                                                        <div id="{{$id_ci}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addci/")}}' method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="ci" type="text" style="margin-top: 10px;"/>
                                                                <input name="nome_anexo_ci" type="file" style="margin-top: 10px; margin-bottom: 10px;"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                        <div id="{{$id_siclg}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addsiclg/")}}' method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="siclg" type="text"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                        <div id="{{$id_oficio}}" style="display: none;">
                                                            <form action='{{ url("descumprimento/addoficio/")}}' method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_descumprimento" value="{{ $n->id_descumprimento }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input name="oficio" type="text" style="margin-top: 10px;"/>
                                                                <input name="nome_anexo_parecer" type="file" style="margin-top: 10px; margin-bottom: 10px;"/>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                </tr>
                                                @endif
                                                <?php $cont++; ?>
                                                @endforeach
                                                </tr>
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

            $("#alerta").fadeOut(6200);



            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });

            $(".link_ci").click(function (e) {
                var indice = $(e.target).data('id');
                var div = '#div_ci' + indice;
                $(div).slideToggle("slow");
            });
            $(".link_siclg").click(function (e) {
                var indice = $(e.target).data('id');
                var div = '#div_siclg' + indice;
                $(div).slideToggle("slow");
            });
            $(".link_oficio").click(function (e) {
                var indice = $(e.target).data('id');
                var div = '#div_oficio' + indice;
                $(div).slideToggle("slow");
            });

        });
    </script>


</body>
<html></html>
