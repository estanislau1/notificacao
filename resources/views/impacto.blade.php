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
          <li><a href="buttons.html">Categoria de Impacto</a></li>
        </ol>
        <!-- Final Breadcrump --> 


         <!-- ABAS DA TAB -->  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#popular" data-toggle="tab"
            aria-expanded="false">Categorias de Impactos registrados</a></li>
          <li class=""><a href="#recent" data-toggle="tab"
            aria-expanded="false">Adicionar nova categoria de impacto</a></li>
        </ul>
        <!--Final da ABAS DA TAB --> 


        <div class="tab-content mb20">

          <div class="tab-pane active" id="popular">
            <div class="panel">


         

              <div class="panel-heading">
                <p>Verifique as categorias de impacto registrados no sistema.</p>
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
                          <th>Nº</th>
                          <th>NOME DA CATEGORIA DE IMPACTO</th>
                          <th>AÇÕES</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Nº</th>
                          <th>NOME DA CATEGORIA DE IMPACTO</th>
                          <th>AÇÕES</th>
                      </tfoot>
                      <tbody>

                      @foreach ($Impactos as $impacto)
                        <tr>
                          <td>{{ $impacto->id_impacto }}</td>
                          <td>{{ $impacto->no_impacto }}</td>
  
                          <td>
                            <a href="impactos/editar/{{ $impacto->id_impacto }}">Editar</a> 
                            | <a href="#">Ver noficações</a>
                            | <a data-href="impactos/delete/{{ $impacto->id_impacto }}" data-toggle="modal" data-target="#confirm-delete">Excluir</a>
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
            <div class="col-md-6">
              <div class="panel">
                <div class="panel-heading nopaddingbottom">
                      <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                </div>
                <div class="panel-body nopaddingtop">
                        <form id="basicForm" name="basicForm" method="post" action="{{ url("impactos/incluir") }}" class="form-horizontal">
                        <input type="hidden" name="idimpacto">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="error" display="block"></div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nome da categoria de impacto <span class="text-danger">*</span></label>
                          <div class="col-sm-7">
                            <input type="text" name="noimpacto" id="noimpacto" class="form-control" title="Informe o nome da categoria de impacto corretamente." required />
                          </div>
                        </div>
                    </div>
                  </div><!-- form-group -->
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
                <h4>Tem certeza que deseja excluir essa categoria de impacto? </h4>
            </div>
            <div class="modal-body">
                Caso você exclua essa categoria de impacto não será possível associa-la a uma notificação.
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
