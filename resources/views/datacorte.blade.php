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
                    <li><a href="#">Definição da data de corte para as notificações</a></li>
                </ol>
                <!-- Final Breadcrump -->

                <!-- ABAS DA TAB -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#popular" data-toggle="tab"
                                          aria-expanded="false">Definição da data de corte</a></li>
                </ul>
                <!--Final da ABAS DA TAB -->


                <div class="tab-content mb20">

                    <div class="tab-pane active" id="popular">
                        <div class="panel">

                            <div class="panel-heading">
                                <p>Defina a data de corte</p>
                                <div class="panel-body">
                                    @if (session('status'))
                                    <div id="alerta" class="alert alert-{{ session('tipo') }}">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form  id="relatoriomensal" name="" enctype="multipart/form-data" action='{{ url("notificacao/definirdiacorte")}}' method="post" class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                                        <p style="margin-bottom: 10px;">Data de corte Notificações</p>
                                        <div class="menu-mes">
                                            <select class="select2" id="id_contrato" name="dianot" data-placeholder="Dia de corte" title="Selecione um dia de corte" required>
                                                @for($i=1; $i<=31; $i++)
                                                @if($i == $dianot)
                                                <option value="<?= $i ?>" selected><?= $i ?></option>
                                                @else
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                @endif
                                                @endfor 
                                            </select>

                                            <button class="btn btn-blue btn-quirk">Enviar</button>                                            
                                            <p>Dia de corte atual: <?= $dianot ?></p>
                                            <hr>
                                            
                                            <p style="margin-bottom: 10px;">Data de corte SLM</p>                                            
                                            <select class="select2" id="id_contrato" name="diaslm" data-placeholder="Dia de corte" title="Selecione um dia de corte" required>
                                                @for($i=1; $i<=31; $i++)
                                                @if($i == $diaslm)
                                                <option value="<?= $i ?>" selected><?= $i ?></option>
                                                @else
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                @endif
                                                @endfor 
                                            </select>

                                            <button class="btn btn-blue btn-quirk">Enviar</button>
                                        </div>
                                        <p>Dia de corte atual: <?= $diaslm ?></p>
                                            <hr>
                                            
                                            <p style="margin-bottom: 10px;">Data de corte Descumprimento</p>                                            
                                            <select class="select2" id="id_contrato" name="diadesc" data-placeholder="Dia de corte" title="Selecione um dia de corte" required>
                                                @for($i=1; $i<=31; $i++)
                                                @if($i == $diadesc)
                                                <option value="<?= $i ?>" selected><?= $i ?></option>
                                                @else
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                @endif
                                                @endfor 
                                            </select>

                                            <button class="btn btn-blue btn-quirk">Enviar</button>
                                        </div>
                                        <p>Dia de corte atual: <?= $diadesc ?></p>

                                    </form>
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
