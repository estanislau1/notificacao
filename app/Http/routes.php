<?php


Route::Get('/', 'ContextoController@index');

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

