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
          <li><a href="buttons.html">Agentes de contratos / RH</a></li>
        </ol>
        <!-- Final Breadcrump --> 


         <!-- ABAS DA TAB -->  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#recent" data-toggle="tab"
            aria-expanded="false">Editar agente</a></li>
        </ul>
        <!--Final da ABAS DA TAB --> 


        <div class="tab-content mb20">

        <div class="tab-pane active" id="recent">
          <div class="row">
            <div class="col-md-10">
              <div class="panel">
                <div class="panel-heading nopaddingbottom">
                      <h4 class="panel-title">Preencha corretamente o formulário abaixo</h4>
                </div>
                @foreach ($Agentes as $agente)
                <div class="panel-body nopaddingtop">
                        <form id='basicForm' name='basicForm' action='{{ url("agentes/incluir/$agente->id_rh")}}' method="post" class='form-horizontal'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="idrh" value="{{ $agente->id_rh }}">
                        <div class="error"></div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Matrícula <span class="text-danger">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" name="ma_rh" id="ma_rh" value="{{ $agente->ma_rh }}" class="form-control" title="Informe o número da matrícula do agente!" placeholder="c000000" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Nome <span class="text-danger">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" name="no_rh" id="no_rh" value="{{ $agente->no_rh }}" class="form-control" title="Informe o nome do agente que você deseja cadastrar" placeholder="" required />
                          </div>
                        </div>
                    </div>
                    </div><!-- form-group -->
                        <hr>
                        <div class="row">
                          <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-wide btn-primary btn-quirk mr5">Atualizar</button>
                            <button type="button" onClick="history.back();" class="btn btn-wide btn-default btn-quirk">Voltar</button>
                          </div>
                        </div>
                      </form>
                @endforeach
                </div><!-- panel-body -->
              </div><!-- panel -->
            </div><!-- col-md-6 -->
          </div>
          </div> <!-- Final da tab -->
        </div>





      </div> <!-- contentpanel -->
    </div> <!-- mainpanel -->
  </section>




@include('Default.endScripts')

<script>
$(document).ready(function(){

  $('.select2').select2();

    // Input Masks
    //$("#nucontrato").mask("99999/9999");


  // Error Message In One Container
  $('#basicForm').validate({
   errorLabelContainer: jQuery('#basicForm div.error')
  });



});   
</script>


</body>
<html></html>
