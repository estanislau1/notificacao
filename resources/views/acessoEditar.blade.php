@include('Default.head')

<body>
    @include('Default.header')


    <section>
        @include('Default.leftpanel')



        <div class="mainpanel">

            <div class="contentpanel">

                <!-- Breadcrump --> 
                <ol class="breadcrumb breadcrumb-quirk">
                    <li><a href="index.html"><i class="fa fa-home mr5"></i> Dashboard</a></li>
                    <li><a href="buttons.html">Editar Supervisor SE</a></li>
                </ol>
                <!-- Final Breadcrump --> 


                <!-- ABAS DA TAB -->  
                <ul class="nav nav-tabs">
                    <li class="active"><a class="destaque" href="#recent" data-toggle="tab" aria-expanded="false">Editar supervisor SE</a></li>
                </ul>
                <!--Final da ABAS DA TAB --> 


                <div class="tab-content mb20">

                    <div class="" id="recent">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading nopaddingbottom">
                                        <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                                    </div>
                                    <div class="panel-body nopaddingtop">
                                        @foreach($Acesso as $acess) 
                                        <form id="basicForm" name="basicForm" method="post" action="{{ url("supervisorse/incluir/$acess->id_acesso") }}" class="form-horizontal">
                                            <input type="hidden" name="idacesso" value="{{$acess->id_acesso}}"/>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                            <div class="error" display="block"></div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" >Matrícula:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text"  value="{{$acess->matricula}}" name="matricula" id="matricula" class="form-control" title="Informe a matrícula do servidor" placeholder="Informe a matrícula do servidor" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" >Nome:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text"  value="{{$acess->nome}}" name="nome" id="nome" class="form-control" title="Informe o nome do servidor" placeholder="Informe o nome do servidor" required />
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-9 col-sm-offset-3">

                                                    <button type="submit" class="btn btn-wide btn-primary btn-quirk mr5">Atualizar</button>


                                                    <button type="reset" class="btn btn-wide btn-default btn-quirk">Limpar</button>
                                                </div>
                                            </div>
                                        </form>
                                        @endforeach

                                    </div>

                                </div><!-- form-group -->

                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->
                </div>
            </div> <!-- Final da tab -->
        </div>

    </section>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Tem certeza que deseja excluir essa Agente? </h4>
                </div>
                <div class="modal-body">
                    Caso você exclua esse agente, ele não poderá mais responder as notificações.
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

            $('#dataTable1').dataTable({
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

            $("#alerta").fadeOut(3200);



            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });


        });
    </script>


</body>
<html></html>
