<div class="leftpanel">
    <div class="leftpanelinner">


        <!-- Painel de abertura de notificação --> 
        <div class="media leftpanel-profile">
             <div class="media-body">



                @if((substr(session('matricula'), 0, 1)) != 'p')
                <a href="{{ url("notificacao/nova")}}">
                    <button class="btn btn-blue btn-quirk" style="width:100%">Abrir notificação</button>
                </a>
                <a style="margin-top:15px; display:block;" href="{{ url("descumprimento/novo")}}">
                    <button class="btn btn-blue btn-quirk" style="width:100%">Abrir descumprimento</button>
                </a>
                @endif
                
            </div>
        </div>

        <!-- Painel de abertura de notificação --> 

        <div class="tab-content">

            <!-- ################# MAIN MENU ################### -->

            <!-- #################### BUSCA ################### -->

            <div class="tab-pane active " id="settings">

                <h5 class="sidebar-title" >Descumprimentos</h5>

                <ul class="nav nav-pills nav-stacked nav-quirk">
        <!--
            <div class="btn-group btn-group-toggle" data-toggle="buttons">        

                <li><a href="{{ url("notificacao")}}"  ><i class="fa fa-asterisk"></i><span>HOME - Nível de serviço</span></a></li>

                    <li><a style="display: block; "href="{{ url("descumprimento")}}"><i class="fa fa-list"></i> <span>HOME - Contratual</span></a></li>
			<li><a style="display: block; "href="{{ url("slm")}}"><i class="fa fa-list"></i> <span>HOME - SLM</span></a></li>

            </div>
                  -->

           <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons">-->
               <!-- <label class="btn btn-secondary active">-->
                 <!--   <input type="radio" name="options" id="option1" autocomplete="off" checked> Ativo -->
                 <!--   <li><a href="{{ url("notificacao")}}"  ><i class="fa fa-asterisk"></i><span>HOME - Nível de serviço</span></a></li>-->
        <div class="media leftpanel-profile">
             <div class="media-body">

                <a href="{{ url("notificacao")}}">
                    <button class="btn btn-cor btn-quirk" style="width:100%">HOME - Nível de serviço</button>
                </a>
                <a style="margin-top:15px; display:block;" href="{{ url("descumprimento")}}">
                    <button class="btn btn-blue btn-quirk" style="width:100%">HOME - Contratual</button>
                </a>

                 <a style="margin-top:15px; display:block;" href="{{ url("slm")}}">
                    <button class="btn btn-blue btn-quirk" style="width:100%">HOME - SLM</button>
                </a>
             
         <!--    <a class="btn btn-ss" style="margin-top:15px; display:block;" href="{{ url("slm")}}" id="demo" onclick="myFunction()">
                  <button class="btn btn-ss">HOME - SLM</button> 
              </a>  -->
            </div>
        </div>

                    <h5 class="sidebar-title">Navegação</h5>
                    @if(Session::get('isrh') == 1)


                    <li class="nav-parent">
                        <a href=""><i class="fa fa-check-square"></i> <span>Administração</span></a>
                        <ul class="children">

                            <li><a href="{{ url("notificacao/datadecorte") }}">Dia de corte</a></li>
				<li><a href="{{ url("fatura") }}">Fatura</a></li>
                            <li><a href="{{ url("agentes") }}">Agentes de contrato</a></li>
                            <li><a href="{{ url("agentessupervisao") }}">Agentes Supervisão</a></li>
                            <li><a href="{{ url("prepostos") }}">Prepostos</a></li>
                            <li><a href="{{ url("empresas") }}">Empresas</a></li>
                            <li><a href="{{ url("gestores") }}">Gestores</a></li>
                            <li><a href="{{ url("coordenacoes") }}">Coordenações</a></li>
                            <hr>
                            <li><a href="{{ url("contratos") }}">Contratos</a></li>
                            <li><a href="{{ url("indicadores") }}">Indicadores</a></li>                  


                            <!--
                            #Itens removidos do projeto 
                            #Macrocelulas e celulas não são necessárias nesse momento. 
                             
                            <li><a href="{{ url("macrocelulas") }}">Macrocélulas</a></li>
                            <li><a href="{{ url("celulas") }}">Células</a></li>
                            
                            -->
                        </ul>
                    </li>
                    @endif
                    @if(Session::get('isrh') == 1 || Session::get('isgestor') == 1 || Session::get('ispreposto') == 1 || Session::get('issupervisor') == 1)
                    <li class="nav-parent"><a href=""><i class="fa fa-bar-chart"></i> <span>Relatórios</span></a>
                        <ul class="children">
                            @if(Session::get('isrh') == 1 || Session::get('isgestor') == 1 || Session::get('issupervisor') == 1)
                            <li class=""><a href="{{ url('relatorio/notificacao_por_contrato')}}">Relatórios por contrato</a></li>
                            @endif
                            @if(Session::get('isrh') == 1)
                            <li class=""><a href="{{ url('relatorio/definirrelatorioreabertas')}}">Relatório de notificações reabertas</a></li>
                            <li class=""><a href="{{ url('relatorio/definirrelatoriogeral')}}">Relatório Geral de notificações</a></li>
                            @endif
                            <li><a href="{{ url('relatorio/definirrelatorio')}}">Relatório mensal</a></li>
                            <li><a href="{{ url('relatorio/definirrelatorioporindicador')}}">Relatório mensal por indicador</a></li>
                            <hr>
                             <li><a href="{{ url('relatorio/definirrelatoriodescumprimento')}}">Relatório mensal Descumprimento</a></li>
				<hr>
                             <li><a href="{{ url('relatorio/definirrelatorioslm')}}">Relatório SLM</a></li>

                        </ul>
                    </li>
                    @endif
                </ul>



                <h5 class="sidebar-title">Busca de notificações - Nivel de servico</h5>


                <form id='basicForm1' name='basicForm1' enctype="multipart/form-data" action='{{ url("buscar")}}' method="post" class='form-horizontal'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <ul class="list-group list-group-settings">
                        <li class="list-group-item">

                            <div class="form-group">
                                <input type="text" class="form-control" id="palavra_chave" name="palavra_chave" placeholder="Palavra chave">
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" class="form-control" id="palavra_chave" name="ma_cadastro" placeholder="Mátricula do solicitante">
                            </div>

                            <div class="form-group">
                                <div>
                                    <select class="select2" id="id_notificadora" name="id_notificadora" style="width: 100%" data-placeholder="Selecione a coordenação notificadora" title="Você precisa selecionar a coordenação notificadora">
                                        <option value=""></option>
                                        @foreach ($Coordenacoes as $Coordenacao)
                                        <option value="{{ $Coordenacao->id_coordenacao }}">{{ $Coordenacao->ds_coordenacao }}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div><!-- form-group -->


                            <div class="form-group">

                                <select class="select2" id="id_contrato" name="id_contrato" style="width: 100%" data-placeholder="Selecione um contrato" title="Você precisa selecionar uma contrato">
                                    <option value=""></option>
                                    @foreach ($Contratos as $c)

                                    <option value="{{ $c->id_contrato }}">{{ $c->nu_contrato }} - <?php echo DB::table('EMPRESA')->where('id_empresa', $c->id_empresa)->value('no_empresa'); ?></option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="data inicial : dd/mm/aaaa" name="datainicio" id="datainicio">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="data final : dd/mm/aaaa" name="datafinal" id="datafinal">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>  

                            <button class="btn btn-warning btn-quirk" style="width:100%">Buscar notificação</button>


                            </form>


                        </li>
                    </ul>


            </div><!-- tab-pane -->

        </div><!-- tab-content -->

    </div><!-- leftpanelinner -->
</div><!-- leftpanel -->

<script>
var controle = 0;
function myFunction() {
    
    if(controle ==0){
        document.getElementById("demo").style.background = "blue";
        controle++;
        }
    else{
        document.getElementById("demo").style.background = "green";
        controle--;
        }
}
</script>