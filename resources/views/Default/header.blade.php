<header>
<?php date_default_timezone_set('America/Sao_Paulo');?>
    <div class="headerpanel">

        <div class="logopanel">
            <center><h2><a href="{{ url('notificacao')}}"><span class="titulologo">SI<span style="color: rgb(255, 116, 0);">N</span>OC</span></a></h2></center>
            <center><a href="{{ url('notificacao')}}"><span class="titulologo2">Sistema de notificações</span></a></center>
        </div><!-- logopanel -->
        
        <div class="logocaixa">
            <h2 style="text-align: center;"><a href="{{ url('notificacao')}}"><img src='{{ asset("theme/images/logocaixa.gif") }}'></a></h2>
        </div><!-- logopanel -->


        <div class="headerbar">

            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>


            <!-- INICIO - HEADER COM NOME   -->
            <div class="header-right">
                <ul class="headermenu">
                    <li>
                        <div class="btn-group matricula">
                            <button type="button" class="btn btn-logged" data-toggle="dropdown">
                                <span style="font-size: 15px !important;"><b>{{ session('matricula') }}</b></span>
                             <!-- <span class="caret"></span>-->
                            </button>

                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ url('notificacao/logout')}}"><i class="glyphicon glyphicon-log-out"></i> Sair </a></li>
                            </ul>

                        </div>
                    </li>
                </ul>
            </div><!-- header-right -->
            <!-- FIM - HEADER COM NOME   -->
        </div><!-- headerbar -->
    </div><!-- header-->
</header>
