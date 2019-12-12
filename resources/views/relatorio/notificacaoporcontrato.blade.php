@include('Default.head')

<body>
@include('Default.header')


  <section>
  @include('Default.leftpanel')



    <div class="mainpanel">

      <div class="contentpanel">

        <!-- Breadcrump --> 
        <ol class="breadcrumb breadcrumb-quirk">
          <li><a href="#"><i class="fa fa-home mr5"></i> Relatório</a></li>
        </ol>
        <!-- Final Breadcrump --> 


         <!-- ABAS DA TAB -->  
        <ul class="nav nav-tabs">
          <li class="active"><a href="#popular" data-toggle="tab" aria-expanded="false">Notificações por contrato</a></li>        
          <li class="btn-blue"><a href="#acatXnaoacat" data-toggle="tab" aria-expanded="false">Notificações Acatadas X Não Acatadas</a></li>        
          <li class="btn-blue"><a href="#linhas" data-toggle="tab" aria-expanded="false">Nível de serviço</a></li>        
        </ul>
        <!--Final da ABAS DA TAB --> 


        <div class="tab-content mb20">

          <div class="tab-pane active" id="popular">
            <div class="panel">
            

			<div class="">
	          <div class="panel">
	            <div class="panel-heading">
	              <h4 class="panel-title">Número de notificações por contrato</h4>
	              
	            </div>
	            <div class="panel-body">
	              <div id="piechart" class="flot-chart col-sm-6 right"></div>
	              
	              <div class="col-sm-6">
	                <ul>
		                @foreach ($arrayPizza as $p)
	    	            	<li>
	    	            		Contrato : {{ $p->no_empresa }} - {{ $p->nu_contrato }} - Total de notificações : {{$p->count }}
	    	            	</li>
	        			@endforeach

	                </ul>
                   
	              </div>
	            </div>
	          </div><!-- panel -->
	        </div>


              
            </div> <!-- panel -->
          </div> <!-- Final do Primeiro panel (TAB:popular) --> 
          
          <div class="tab-pane active" id="acatXnaoacat">
            <div class="panel">
            

			<div class="">
	          <div class="panel">
	            <div class="panel-heading">
	              <h4 class="panel-title">Total de Notificações Acatadas X Total de Notificações Não Acatadas</h4>
	              
	            </div>
	            <div class="panel-body">
	              <div id="PizzaAcatNaoacat" class="flot-chart col-sm-6 right"></div>
	              
	              <div class="col-sm-6">
	                <ul>
                            @foreach ($TotalAcatadas as $total)
	    	            	<li>
                                    Total Acatadas : {{$total->count}}
	    	            	</li>
                            @endforeach
                            @foreach ($TotalNaoAcatadas as $total)
	    	            	<li>
                                    Total Não Acatadas : {{$total->count}}
	    	            	</li>
                            @endforeach
	        			

	                </ul>
                   
	              </div>
	            </div>
	          </div><!-- panel -->
	        </div>


              
            </div> <!-- panel -->
          </div> <!-- Final do Primeiro panel (TAB:acatadas X não acatadas) --> 
          
          <div class="tab-pane active" id="linhas">
            <div class="panel">
            

			<div class="">
	          <div class="panel">
	            <div class="panel-heading">
	              <h4 class="panel-title">Nível de Serviço</h4>
	              
	            </div>
	            <div class="panel-body">
	            <div id="grafico" class="flot-chart col-sm-6 right"></div>

	              
	              
	            </div>
	          </div><!-- panel -->
	        </div>


              
            </div> <!-- panel -->
          </div> <!-- Final do Primeiro panel (TAB:acatadas X não acatadas) --> 

          
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


  function showTooltip(x, y, contents) {
		$('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
		  position: 'absolute',
		  display: 'none',
		  top: y + 5,
		  left: x + 5
		}).appendTo('body').fadeIn(200);
	}
  function gd(year, month, day) {
        return new Date(year, month, day).getTime();
  }
  
  var hitss = [
      @foreach ($mensal_hitss as $hit)
      
      [gd({{$hit->ano}},{{$hit->mes - 1}},1),{{$hit->total}}],
      @endforeach
  ];
  var cpm = [
      @foreach ($mensal_cpm as $cpm)
      
      [gd({{$cpm->ano}},{{$cpm->mes - 1}},1),{{$cpm->total}}],
      @endforeach
  ];
  var ctis = [
      @foreach ($mensal_ctis as $ctis)
      
      [gd({{$ctis->ano}},{{$ctis->mes - 1}},1),{{$ctis->total}}],
      @endforeach
  ];
 
  var dataset = [{label:"CPM",data:cpm, points: { symbol: "circle"}},
                {label:"HITSS",data:hitss, points: { symbol: "triangle"}},
                {label:"CTIS",data:ctis, points: { symbol: "square"}}];

  var piedata = [
                 //Dados vindos do blade do laravel
                 @foreach ($arrayPizza as $p)
                  { label: '{{ $p->no_empresa }}', data: [[ {{$p->count }} , {{$p->count }} ]]}, 
         		 @endforeach
         	 ];
  var pieacatxnaoacat = [
                 //Dados vindos do blade do laravel
                 @foreach ($TotalAcatadas as $totalsim)
                 @foreach ($TotalNaoAcatadas as $totalnao)
                  { label: 'Total Acatadas', data: [[ {{$totalsim->count }} , {{$totalsim->count }} ]]}, 
                  { label: 'Total Não Acatadas', data: [[ {{$totalnao->count }} , {{$totalnao->count }} ]]}, 
         		 @endforeach
         		 @endforeach
         	 ];

             $.plot('#piechart', piedata, {
                 series: {
                     pie: {
                         show: true,
                         radius: 1,
                         label: {
                                show: true,
                                radius: 1,
                                formatter: labelFormatter,
                                background: {
                                    opacity: 0.5,
                                    color: '#000'
                                }
                        }
                     }
                 },
                 grid: {
                     hoverable: true,
                     clickable: true
                 }
             });
             
             $.plot('#PizzaAcatNaoacat', pieacatxnaoacat, {
                 series: {
                     pie: {
                         show: true,
                         radius: 1,
                         label: {
                                show: true,
                                radius: 1,
                                formatter: labelFormatter,
                                background: {
                                    opacity: 0.5,
                                    color: '#000'
                                }
                        }
                     }
                 },
                 grid: {
                     hoverable: true,
                     clickable: true
                 }
             });
             
             $.plot('#grafico', dataset, {
                 series: {
                     lines: {
                         show: true,
                         
                     },
                     points: {
                        radius: 3,
                        fill: true,
                        show: true            
                    }
                 },
                  xaxis: {
        mode: "time",
        tickSize: [1, "month"],        
        tickLength: 0,
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10
    },
                 grid: {
                     hoverable: true,
                     clickable: true
                 }
             });

             function labelFormatter(label, series) {
         		return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br>' + Math.round(series.percent) + '%</div>';
         	}
           
  

});   
</script>




<script src="{{ asset("theme/lib/flot/jquery.flot.js") }}"></script>

<script src="{{ asset("theme/lib/flot/jquery.flot.pie.js") }}"></script>
<script src="{{ asset("theme/lib/flot/jquery.flot.time.js") }}"></script>
<script src="{{ asset("theme/lib/flot/jquery.flot.symbol.js") }}"></script>
<script src="{{ asset("theme/lib/flot/jquery.flot.axislabels.js") }}"></script>
<script src="{{ asset("theme/lib/flot/jquery.flot.jshashtable-2.1.js") }}"></script>





</body>
<html></html>
