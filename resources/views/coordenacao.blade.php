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
          <li><a href="buttons.html">Coordenações</a></li>
        </ol>
        <!-- Final Breadcrump --> 


         <!-- ABAS DA TAB -->  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#popular" data-toggle="tab"
            aria-expanded="false">Coordenações registradas</a></li>
          <li class="btn-blue"><a class="destaque" href="#recent" data-toggle="tab"
            aria-expanded="false">Adicionar nova coordenação</a></li>
        </ul>
        <!--Final da ABAS DA TAB --> 


        <div class="tab-content mb20">

          <div class="tab-pane active" id="popular">
            <div class="panel">


         

              <div class="panel-heading">
                <p>Verifique as coordenações registrados no sistema.</p>
                <div class="panel-body">
                @if (session('status'))
                      <div id="alerta" class="alert alert-success">
                          {{ session('status') }}
                      </div>
                @endif

                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-bordered table-striped-col">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>NÚMERO</th>
                          <th>NOME</th>
                          <th>DESCRIÇÃO</th>
                          <th>AÇÕES</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                     <th>ID</th>
                          <th>NÚMERO</th>
                          <th>NOME</th>
                          <th>DESCRIÇÃO</th>
                          <th>AÇÕES</th>
                        </tr>
                      </tfoot>
                      <tbody>

                      @foreach ($Coordenacoes as $Coordenacao)
                        <tr>
                          <td>{{ $Coordenacao->id_coordenacao }}</td>
                          <td>{{ $Coordenacao->nu_coordenacao }}</td>
                          <td>{{ $Coordenacao->no_coordenacao }}</td>
                          <td>{{ $Coordenacao->ds_coordenacao }}</td>

  
                          <td>
                            <a href="coordenacoes/editar/{{ $Coordenacao->id_coordenacao }}">Editar</a> 
                            | <a href="#">Ver noficações</a>
                            | <a data-href="coordenacoes/delete/{{ $Coordenacao->id_coordenacao }}" data-toggle="modal" data-target="#confirm-delete"}">Excluir</a>
                          </td>
                        </tr>
                      @endforeach

                      
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div> <!-- panel-body --> 
              </div>
            </div> <!-- panel -->
          </div> <!-- Final do Primeiro panel (TAB:popular) --> 

          <div class="tab-pane" id="recent">
          <div class="row">
            <div class="col-md-12">
              <div class="panel">
                <div class="panel-heading nopaddingbottom">
                      <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                </div>
                <div class="panel-body nopaddingtop">
                        <form id="basicForm" name="basicForm" method="post" action="{{ url("coordenacoes/incluir") }}" class="form-horizontal">
                        <input type="hidden" name="idcoordenacao">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="error" display="block"></div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Número da coordenação <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="nucoordenacao" id="nucoordenacao" class="form-control" title="Informe o número da coordenação!" placeholder="00" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Nome da coordenação (resumido)<span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="nocoordenacao" id="nocoordenacao" class="form-control" title="Informe o nome da coordenação corretamete!" placeholder="CEPTIBRXXX" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Descrição da coordenação<span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="dscoordenacao" id="dscoordenacao" class="form-control" title="Informe o nome detalhado da coordenação!" placeholder="Coordenação de ..." required/>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="col-sm-3 control-label">E-mail</label>
                          <div class="col-sm-9">
                            <input type="text" name="dsemail" id="dsemail" class="form-control" placeholder="" />
                          </div>
                        </div>
                    </div>
                    </div><!-- form-group -->

                        <hr>

                        <div class="row">
                          <div class="col-sm-9 col-sm-offset-3">
                            
                            <button type="submit" class="btn btn-wide btn-primary btn-quirk mr5">Cadastrar</button>


                            <button type="reset" class="btn btn-wide btn-default btn-quirk">Limpar</button>
                          </div>
                        </div>
                      </form>
                </div><!-- panel-body -->
              </div><!-- panel -->
            </div><!-- col-md-6 -->
          </div>
          </div> <!-- Final da tab -->
        </div>





      </div> <!-- contentpanel -->
    </div> <!-- mainpanel -->
  </section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Tem certeza que deseja excluir essa coordenação? </h4>
            </div>
            <div class="modal-body">
                Caso você exclua essa coordenação não será possível vincular novas notificações a ela, nem células de trabalho.
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
$(document).ready(function(){

  // Error Message In One Container
  $('#basicForm').validate({
   errorLabelContainer: jQuery('#basicForm div.error')
  });

  $('.select2').select2();

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
       "sFirst":    "Primeiro",
       "sPrevious": "Anterior",
       "sNext":     "Próximo",
       "sLast":     "Último"
    }
 } 
});

$( "#alerta" ).fadeOut(3200);



$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});



});   
</script>


</body>
<html></html>
