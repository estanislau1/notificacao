<?php


//Route::Get('/', 'NotificacaoController@index');
Route::Get('/', 'NotificacaoController@logar');



//Controller de Notificações
Route::Get('/notificacao', 'NotificacaoController@index2');
Route::Post('/inicio', 'NotificacaoController@index');
Route::Post('/notificacao', 'NotificacaoController@index');
Route::Get('/notificacao/logout', 'NotificacaoController@logout');
Route::Get('/notificacao/nova', 'NotificacaoController@nova');
Route::Get('/notificacao/editar/{id}', 'NotificacaoController@editar');
Route::Post('/notificacao/incluiredicao/{id}', 'NotificacaoController@incluiredicao');
Route::Get('/notificacao/autorizar/{id}', 'NotificacaoController@autorizar');
Route::Post('/notificacao/incluir/', 'NotificacaoController@incluir');
Route::Get('/notificacao/justificar/{id}', 'NotificacaoController@justificar');
Route::Get('/notificacao/avaliar/{id}', 'NotificacaoController@avaliar');
Route::Post('/notificacao/incluirjustificativa/', 'NotificacaoController@incluirjustificativa');
Route::Post('/notificacao/incluiravaliacao/', 'NotificacaoController@incluiravaliacao');
Route::Post('/notificacao/incluirautorizacao/', 'NotificacaoController@incluirautorizacao');
Route::Get('/notificacao/ver/{id}', 'NotificacaoController@ver');
Route::Get('/notificacao/corrigir/{id}', 'NotificacaoController@corrigir');
Route::Get('/notificacao/reabrir/{id}', 'NotificacaoController@reabrir');
Route::Get('/notificacao/devolverpreposto/{id}', 'NotificacaoController@devolverpreposto');
Route::Post('/buscar', 'NotificacaoController@buscar');
Route::Get('/notificacao/validar', 'NotificacaoController@validarnotificacao');
Route::Get('/notificacao/login', 'NotificacaoController@login');
Route::Post('/notificacao/login', 'NotificacaoController@login');
Route::Get('/notificacao/testar', 'NotificacaoController@testarfuncoes');
Route::Get('notificacao/buscarminhasnotificacoes', 'NotificacaoController@buscarminhasnotificacoes');
Route::Get('notificacao/datadecorte', 'NotificacaoController@diacorte');
Route::Post('notificacao/definirdiacorte', 'NotificacaoController@definirdatacorte');
Route::Post('/buscarmes', 'NotificacaoController@buscarmes');



Route::Get('/descumprimento', 'DescumprimentoController@index');

Route::Get('/descumprimento/novo', 'DescumprimentoController@novo');
Route::Post('/descumprimento/incluir/', 'DescumprimentoController@incluir');


Route::Get('/descumprimento/avaliar/{id}', 'DescumprimentoController@avaliar');
Route::Post('/descumprimento/incluiravaliacao', 'DescumprimentoController@incluiravaliacao');

Route::Get('/descumprimento/avaliarcoordenacao/{id}', 'DescumprimentoController@avaliarcoordenacao');
Route::Post('/descumprimento/incluiravaliacaocoordenacao', 'DescumprimentoController@incluiravaliacaocoordenacao');

Route::Get('/descumprimento/avaliarrh/{id}', 'DescumprimentoController@avaliarrh');
Route::Post('/descumprimento/incluiravaliacaorh', 'DescumprimentoController@incluiravaliacaorh');

Route::Get('/descumprimento/avaliargerente/{id}', 'DescumprimentoController@avaliargerente');
Route::Post('/descumprimento/incluiravaliacaogerencia', 'DescumprimentoController@incluiravaliacaogerente');


Route::Get('/descumprimento/justificar/{id}', 'DescumprimentoController@justificar');
Route::Post('/descumprimento/incluirjustificativa', 'DescumprimentoController@incluirjustificativa');

Route::Post('/descumprimento/addci', 'DescumprimentoController@addci');
Route::Post('/descumprimento/addsiclg', 'DescumprimentoController@addsiclg');
Route::Post('/descumprimento/addoficio', 'DescumprimentoController@addoficio');


Route::Get('/descumprimento/avaliarresposta/{id}', 'DescumprimentoController@avaliarresposta');
Route::Post('/descumprimento/incluirreavaliacao', 'DescumprimentoController@incluirreavaliacao');

Route::Get('/descumprimento/ver/{id}', 'DescumprimentoController@ver');
Route::Get('/descumprimento/devolverempresa/{id}', 'DescumprimentoController@devolverempresa');
Route::Get('/descumprimento/devolvercaixa/{id}', 'DescumprimentoController@devolvercaixa');
Route::Get('/descumprimento/devolvergerente/{id}', 'DescumprimentoController@devolvergerente');
Route::Get('/descumprimento/devolvercoordenacao/{id}', 'DescumprimentoController@devolvercoordenacao');
Route::Get('/descumprimento/devolverrh/{id}', 'DescumprimentoController@devolverrh');

Route::Get('/descumprimento/validar', 'DescumprimentoController@validardescumprimento');

//SLM
Route::Get('/slm', 'SlmController@index');
Route::Get('/slm/incluir-slm/', 'SlmController@incluirslm');
Route::Get('/slm/ver/{id}', 'SlmController@ver');

Route::Get('/slm/justificar/{id}', 'SlmController@justificar');
Route::Post('/slm/incluirjustificativa', 'SlmController@incluirjustificativa');

Route::Get('/slm/avaliar/{id}', 'SlmController@avaliar');
Route::Post('/slm/incluiravaliacao', 'SlmController@incluiravaliacao');

Route::Get('/slm/devolverempresa/{id}', 'SlmController@devolverempresa');
Route::Get('/slm/devolvercaixa/{id}', 'SlmController@devolvercaixa');
Route::Post('/slm/addequipe', 'SlmController@addequipe');
Route::Get('/slm/validar', 'SlmController@validarslm');
Route::Post('/buscarmesslm', 'SlmController@buscarmesslm');

//Controller de Relatórios 
Route::Get('/relatorio/notificacao_por_contrato', 'RelatorioController@notificacaoporcontrato');
Route::Get('/relatorio/definirrelatorio', 'RelatorioController@notificacaoporcoordenacao');
Route::Get('/relatorio/definirrelatorioporindicador', 'RelatorioController@notificacaoporcoordenacaoind');
Route::Get('/relatorio/definirrelatorioreabertas', 'RelatorioController@notificacaoreabertas');
Route::Get('/relatorio/definirrelatoriogeral', 'RelatorioController@notificacaogeral');
Route::Get('/relatorio/definirrelatoriodescumprimento', 'RelatorioController@reldescumprimento');
Route::Get('/relatorio/definirrelatorioslm', 'RelatorioController@relslm');
Route::Post('/relatorio/relatoriomensal', 'RelatorioController@listarnotificacaoporcoordenacao');
Route::Post('/relatorio/relatoriomensalporindicador', 'RelatorioController@listarnotificacaoporcoordenacaoind');
Route::Post('/relatorio/relatoriomensalreabertas', 'RelatorioController@listarnotificacaoreabertas');
Route::Post('/relatorio/relatoriomensalgeral', 'RelatorioController@listarnotificacaogeral');
Route::Post('/relatorio/relatoriomensaldescumprimento', 'RelatorioController@listardescumprimentos');
Route::Post('/relatorio/relatoriomensalslm', 'RelatorioController@listarslm');
Route::Get('/relatorio/gerarpdf', 'NotificacaoController@gerarpdf');
Route::Get('/relatorio/gerarpdf2', 'NotificacaoController@gerarpdf2');




//Controller de indicadores 
Route::Get('/indicadores', 'IndicadorController@index');
Route::Post('/indicadores/incluir', 'IndicadorController@incluir');
Route::Post('/indicadores/incluir/{id}', 'IndicadorController@incluir');
Route::Get('/indicadores/delete/{id}', 'IndicadorController@delete');
Route::Get('/indicadores/editar/{id}', 'IndicadorController@editar');


//Controller de Contratos 
Route::Get('/contratos', 'ContratoController@index');
Route::Post('/contratos/incluir', 'ContratoController@incluir');
Route::Post('/contratos/incluir/{id}', 'ContratoController@incluir');
Route::Get('/contratos/delete/{id}', 'ContratoController@delete');
Route::Get('/contratos/editar/{id}', 'ContratoController@editar');

//Controller de Empresas
Route::Get('/empresas', 'EmpresaController@index');
Route::Post('/empresas/incluir', 'EmpresaController@incluir');
Route::Post('/empresas/incluir/{id}', 'EmpresaController@incluir');
Route::Get('/empresas/delete/{id}', 'EmpresaController@delete');
Route::Get('/empresas/editar/{id}', 'EmpresaController@editar');

//Controller de Contexto
Route::Get('/contextos', 'ContextoController@index');
Route::Post('/contextos/incluir', 'ContextoController@incluir');
Route::Post('/contextos/incluir/{id}', 'ContextoController@incluir');
Route::Get('/contextos/delete/{id}', 'ContextoController@delete');
Route::Get('/contextos/editar/{id}', 'ContextoController@editar');

//Controller de impacto
Route::Get('/impactos', 'ImpactoController@index');
Route::Post('/impactos/incluir', 'ImpactoController@incluir');
Route::Post('/impactos/incluir/{id}', 'ImpactoController@incluir');
Route::Get('/impactos/delete/{id}', 'ImpactoController@delete');
Route::Get('/impactos/editar/{id}', 'ImpactoController@editar');

//Controller de prepostos
Route::Get('/prepostos', 'PrepostoController@index');
Route::Post('/prepostos/incluir', 'PrepostoController@incluir');
Route::Post('/prepostos/incluir/{id}', 'PrepostoController@incluir');
Route::Get('/prepostos/delete/{id}', 'PrepostoController@delete');
Route::Get('/prepostos/editar/{id}', 'PrepostoController@editar');

//Controller de ACESSO
Route::Get('/agentessupervisao', 'AcessoController@index');
Route::Post('/supervisorse/incluir', 'AcessoController@incluir');
Route::Post('/supervisorse/incluir/{id}', 'AcessoController@incluir');
Route::Get('/supervisorse/delete/{id}', 'AcessoController@delete');
Route::Get('/supervisorse/editar/{id}', 'AcessoController@editar');
//Controller de FATURA
Route::Get('/fatura', 'FaturaController@index');
Route::Post('/fatura/incluir', 'FaturaController@incluir');
Route::Post('/fatura/incluir/{id}', 'FaturaController@incluir');
Route::Get('/fatura/delete/{id}', 'FaturaController@delete');
Route::Get('/fatura/editar/{id}', 'FaturaController@editar');

//Controller de coordenações
Route::Get('/coordenacoes', 'CoordenacaoController@index');
Route::Post('/coordenacoes/incluir', 'CoordenacaoController@incluir');
Route::Post('/coordenacoes/incluir/{id}', 'CoordenacaoController@incluir');
Route::Get('/coordenacoes/delete/{id}', 'CoordenacaoController@delete');
Route::Get('/coordenacoes/editar/{id}', 'CoordenacaoController@editar');

//Controller de gestores
Route::Get('/gestores', 'GestorController@index');
Route::Post('/gestores/incluir', 'GestorController@incluir');
Route::Post('/gestores/incluir/{id}', 'GestorController@incluir');
Route::Get('/gestores/delete/{id}', 'GestorController@delete');
Route::Get('/gestores/editar/{id}', 'GestorController@editar');

//Controller de macrocelulas
Route::Get('/macrocelulas', 'MacrocelulaController@index');
Route::Post('/macrocelulas/incluir', 'MacrocelulaController@incluir');
Route::Post('/macrocelulas/incluir/{id}', 'MacrocelulaController@incluir');
Route::Get('/macrocelulas/delete/{id}', 'MacrocelulaController@delete');
Route::Get('/macrocelulas/editar/{id}', 'MacrocelulaController@editar');

//Controller de celulas
Route::Get('/celulas', 'CelulaController@index');
Route::Post('/celulas/incluir', 'CelulaController@incluir');
Route::Post('/celulas/incluir/{id}', 'CelulaController@incluir');
Route::Get('/celulas/delete/{id}', 'CelulaController@delete');
Route::Get('/celulas/editar/{id}', 'CelulaController@editar');


//Controller de agentes de rh
Route::Get('/agentes', 'RhController@index');
Route::Post('/agentes/incluir', 'RhController@incluir');
Route::Post('/agentes/incluir/{id}', 'RhController@incluir');
Route::Get('/agentes/delete/{id}', 'RhController@delete');
Route::Get('/agentes/editar/{id}', 'RhController@editar');

