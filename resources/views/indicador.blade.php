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
          <li><a href="#">Indicadores</a></li>
        </ol>
        <!-- Final Breadcrump --> 


         <!-- ABAS DA TAB -->  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#popular" data-toggle="tab"
            aria-expanded="false">Indicadores cadastradas</a></li>
          <li class="btn-blue"><a class="destaque" href="#recent" data-toggle="tab"
            aria-expanded="false">Adicionar novo indicador</a></li>
        </ul>
        <!--Final da ABAS DA TAB --> 


        <div class="tab-content mb20">

          <div class="tab-pane active" id="popular">
            <div class="panel">


         

              <div class="panel-heading">
                <p>Verifique os indicadores registrado no sistema.</p>
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
                          <th>CONTRATO</th>
                          <th>SIGLA</th>
                          <th>INDICADOR</th>                          
                          <th>AÇÕES</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>CONTRATO</th>
                          <th>SIGLA</th>
                          <th>INDICADOR</th>                          
                          <th>AÇÕES</th>
                        </tr>
                      </tfoot>
                      <tbody>

                      @foreach ($Indicadores as $indicador)
                        <tr>
                          <td>{{ $indicador->id_indicador }}</td>
                          <td>{{ $indicador->nu_contrato }}</td>
                          <td>{{ $indicador->sg_indicador }}</td>
                          <td>{{ $indicador->no_indicador }}</td>
  
                          <td>
                            <a href="indicadores/editar/{{ $indicador->id_indicador }}">Editar</a> 
                            | <a data-href="indicadores/delete/{{ $indicador->id_indicador }}" data-toggle="modal" data-target="#confirm-delete">Excluir</a>

                            
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
                <br>
                <div class="panel-body nopaddingtop">
                        <form id="basicForm" name="basicForm" method="post" action="{{ url("indicadores/incluir") }}" class="form-horizontal">
                        <input type="hidden" name="id_indicador">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="error" display="block"></div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label"> Sigla do indicador<span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="sg_indicador" id="sg_indicador" class="form-control" title="Informe a sigla do indicador que você deseja cadastrar" placeholder="" required />
                          </div>
                        </div>
             
                        <div class="form-group">
                          <label class="col-sm-3 control-label"> Nome do indicador<span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="no_indicador" id="no_indicador" class="form-control" title="Informe o nome do indicador que você deseja cadastrar" placeholder="" required />
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="col-sm-3 control-label">Descrição <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" name="ds_indicador" id="ds_indicador" class="form-control" title="Informe a descrição deste indicador" placeholder="" />
                          </div>
                        </div>


                    <div class="form-group">
                    <label class="col-sm-3 control-label">Contrato <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                      <select class="select2" id="id_contrato" name="id_contrato" style="width: 100%" data-placeholder="Selecione um contrato" title="Você precisa selecionar uma contrato" required>
                        <option value=""></option>
                          @foreach ($Contratos as $Contrato)
                            <option value="{{ $Contrato->id_contrato }}">{{ $Contrato->nu_contrato }}</option>
                          @endforeach
  
                      </select>
                    
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
                <h4>Tem certeza que deseja excluir esse indicador? </h4>
            </div>
            <div class="modal-body">
                Caso você exclua esse indicador, não será possível notifica-lo futuramente.
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

    // Input Masks
  //$("#nucontrato").mask("99999/9999");

  
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
