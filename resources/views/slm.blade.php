@include('Default.head')

<body>
    @include('Default.header')


    <section>
        @include('Default.leftpanel3')



        <div class="mainpanel">

            <div class="contentpanel">

                <!-- Breadcrump --> 
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="#"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="#">SLM</a></li>
                </ol>
                <!-- Final Breadcrump --> 


                <!-- ABAS DA TAB -->  
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">SLMs registrados</a></li>
                </ul>
                <!--Final da ABAS DA TAB --> 


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Verifique os SLMs registrados no sistema.</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                          <form id="" name="" enctype="multipart/form-data" action='{{ url("buscarmesslm")}}' method="post" class="">
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
                                                <option value="2020" <?php echo ($ano == '2020') ? "selected" : ""; ?>>2020</option>

                                            </select>

                                            <select name="mes" class="select2" style="width: 9% !important;" title="Selecione o m�s visualizar" >
                                                <option value="01" <?php echo ($mes == '01') ? "selected" : ""; ?>>Janeiro</option>
                                                <option value="02" <?php echo ($mes == '02') ? "selected" : ""; ?>>Fevereiro</option>
                                                <option value="03" <?php echo ($mes == '03') ? "selected" : ""; ?>>Mar�o</option>
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

                                    <div class="table-responsive">
                                        <table id="dataTable1" class="table table-bordered table-striped-col">
                                            <thead>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>AÇÕES</th>
                                                    <th>IC</th>
                                                    <th>CONTRATO</th>
                                                    <th>COORDENAÇÃO</th>
                                                    <th>EQUIPE</th>
                                                    <th>INCIDENTE</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>AÇÕES</th>
                                                    <th>IC</th>
                                                    <th>CONTRATO</th>
                                                    <th>COORDENAÇÃO</th>
                                                    <th>EQUIPE</th>
                                                    <th>INCIDENTE</th>
                                                    <th>STATUS</th>
                                                    <th>PRAZO</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $cont = 1;
                                                $id_contrato_prep = DB::table('PREPOSTO')->where('ma_preposto', session('matricula'))->value('id_contrato');
                                                
                                                //var_dump($Slm);
                                                ?>
                                                @foreach ($Slm as $n)
                                                
                                                <?php $nome_coordenacao = DB::table('COORDENACOES')->where('id_coordenacao', $n->id_coordenacao)->value('no_coordenacao');?>
                                                @if(($n->id_contrato == $id_contrato_prep && $id_contrato_prep <> NULL) || ((substr(session('matricula'), 0, 1) == 'p') && (session('empresa') == $n->id_contrato)) )
                                                <tr>
                                                    <td><a href="{{ url("slm/ver/".Crypt::encrypt($n->id_slm) )}}">{{ $n->nu_slm }}</a></td>
                                                    <td style="width: 20%;">

                                                        @if(substr(session('matricula'), 0, 1) == 'p' || Session::get('isrh') == 1)
                                                        @if($n->status == 1)
                                                        <a href="{{ url("slm/justificar/".Crypt::encrypt($n->id_slm) )}}">Justificar</a> |     	 

                                                        @endif
                                                        @endif

                                                        @if(substr(session('matricula'), 0, 1) == 'c')
                                                        @if($n->status == 2)
                                                        <a href="{{ url("slm/avaliar/".Crypt::encrypt($n->id_slm) )}}">Avaliar</a> |                                
                                                        @endif 
                                                        @endif                                                        

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44 || $n->status == 4 || $n->status == 33 || $n->status == 3)
                                                        <a href="{{ url("slm/devolverempresa/".Crypt::encrypt($n->id_slm) )}}">Devolver Terceiro</a> |
                                                        @endif
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44 || $n->status == 4 || $n->status == 33 || $n->status == 3)
                                                        <a href="{{ url("slm/devolvercaixa/".Crypt::encrypt($n->id_slm) )}}">Devolver Caixa</a> |
                                                        @endif
                                                        @endif

                                                        <a href="{{ url("slm/ver/".Crypt::encrypt($n->id_slm) )}}">Informações</a>
                                                    </td>    

                                                    <td>{{$n->ic}}</td>
                                                    <td>{{ $n->no_empresa }} - {{ $n->nu_contrato }}</td>
                                                    <td>{{$nome_coordenacao}}</td>
                                                    <?php
                                                    $id_equipe = 'div_equipe' . $cont;
                                                    $link = $cont;
                                                    ?>
                                                    @if ($n->equipe === 1)
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Dia</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                    @elseif($n->equipe === 2)
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Noite</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Madrugada</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <td>{{$n->incidente}}</td>
                                                    <td>
                                                        @if($n->status == 1) 
                                                        Aguardando análise da terceirizada
                                                        @endif

                                                        @if($n->status == 2) 
                                                        Aguardando análise da caixa
                                                        @endif

                                                        @if($n->status == 3) 
                                                        SLM Acatado
                                                        @endif

                                                        @if($n->status == 33) 
                                                        SLM Acatado - Prazo excedido!
                                                        @endif

                                                        @if($n->status == 4) 
                                                        SLM Não Acatado
                                                        @endif

                                                        @if($n->status == 44) 
                                                        SLM Não Acatado - Prazo excedido!
                                                        @endif                                             

                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($n->dt_prazo)->format('d/m/Y H:i')}}</td>                                                                       


                                                </tr>
                                                @elseif(Session::get('isgestor') == 1 || Session::get('isrh') == 1 || Session::get('issupervisor') == 1 || (substr(session('matricula'), 0, 1)) == 'c')
                                                <tr>
                                                    <td><a href="{{ url("slm/ver/".Crypt::encrypt($n->id_slm) )}}">{{ $n->nu_slm }}</a></td>
                                                    <td style="width: 20%;">
                                                        @if(substr(session('matricula'), 0, 1) == 'p' || Session::get('isrh') == 1)
                                                        @if($n->status == 1)
                                                        <a href="{{ url("slm/justificar/".Crypt::encrypt($n->id_slm) )}}">Justificar</a> |     	                          
                                                        @endif
                                                        @endif

                                                        @if(substr(session('matricula'), 0, 1) == 'c')
                                                        @if($n->status == 2)
                                                        <a href="{{ url("slm/avaliar/".Crypt::encrypt($n->id_slm) )}}">Avaliar</a> |                                
                                                        @endif 
                                                        @endif                                                        

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44 || $n->status == 4 || $n->status == 33 || $n->status == 3)
                                                        <a href="{{ url("slm/devolverempresa/".Crypt::encrypt($n->id_slm) )}}">Devolver Terceiro</a> |
                                                        @endif
                                                        @endif

                                                        @if(Session::get('isrh') == 1)
                                                        @if($n->status == 44 || $n->status == 4 || $n->status == 33 || $n->status == 3)
                                                        <a href="{{ url("slm/devolvercaixa/".Crypt::encrypt($n->id_slm) )}}">Devolver Caixa</a> |
                                                        @endif
                                                        @endif

                                                        <a href="{{ url("slm/ver/".Crypt::encrypt($n->id_slm) )}}">Informações</a>
                                                    </td>
                                                    <td>{{$n->ic}}</td>                           
                                                    <td>{{ $n->no_empresa }} - {{ $n->nu_contrato }}</td>
                                                    <td>{{$nome_coordenacao}}</td>
                                                    <?php
                                                    $id_equipe = 'div_equipe' . $cont;
                                                    $link = $cont;
                                                    ?>
                                                    @if ($n->equipe === 1)
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Dia</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>

                                                    @elseif($n->equipe === 2)
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Noite</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <a class="link_equipe" style="cursor: pointer;" data-id="{{$link}}">Madrugada</a>
                                                        <div id="{{$id_equipe}}" style="display: none;">
                                                            <form action='{{ url("slm/addequipe/")}}' method="post">
                                                                <input type="hidden" name="id_slm" value="{{ $n->id_slm }}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div style="margin-bottom: 5px;">
                                                                    <select class="select2" id="bit_acatamento" name="equipe" style="width: 80px;" data-placeholder="Informe sua decisão"  title="Campo equipe Obrigatório!! Favor preencher!" required>
                                                                        <option  disabled></option>
                                                                        <option value="1">Dia</option>
                                                                        <option value="2">Noite</option>
                                                                        <option value="3">Madrugada</option>
                                                                    </select>
                                                                </div>
                                                                <button id="btn_ci"class="btn-group-xs btn-blue" type="submit">enviar</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <td>{{$n->incidente}}</td>
                                                    <td>
                                                        @if($n->status == 1) 
                                                        Aguardando análise da terceirizada
                                                        @endif

                                                        @if($n->status == 2) 
                                                        Aguardando análise da caixa
                                                        @endif

                                                        @if($n->status == 3) 
                                                        SLM Acatado
                                                        @endif

                                                        @if($n->status == 33) 
                                                        SLM Acatado - Prazo excedido!
                                                        @endif

                                                        @if($n->status == 4) 
                                                        SLM Não Acatado
                                                        @endif

                                                        @if($n->status == 44) 
                                                        SLM Não Acatado - Prazo excedido!
                                                        @endif                                                      

                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($n->dt_prazo)->format('d/m/Y H:i')}}</td>


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

            $("#alerta").fadeOut(6200);



            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });

            $(".link_equipe").click(function (e) {
                var indice = $(e.target).data('id');
                var div = '#div_equipe' + indice;
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
