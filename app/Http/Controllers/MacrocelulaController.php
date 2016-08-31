<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato; 
use App\Models\Empresa as Empresa; 
use App\Models\Macrocelula as Macrocelula; 


use Illuminate\Http\Request;
use DB;




class MacrocelulaController extends Controller
{
    public function index()
    {

        //Pegando informações do usuário que está acessando o sistema
        $matricula  =   getenv('USERNAME');

        //Listando as empresas
        $Empresas = Empresa::all();

        //Listando os contratos
        $Contratos = Contrato::all();


        //Listando todos os contratos válidos do sistema     
        $Macrocelulas = DB::table('MACROCELULA')
            ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'MACROCELULA.id_contrato')
            ->where('MACROCELULA.deleted_at', null)
            ->select('CONTRATOS.*', 'MACROCELULA.*')
            ->get();    


        //Carregando View e repassando as variáveis necessárias
        return view('macrocelula', ['matricula' => $matricula,
                                    'Empresas'  => $Empresas, 
                                    'Macrocelulas'  => $Macrocelulas, 
                                    'Contratos' => $Contratos
                                 ]);
        }


    public function editar($id)
    {
        
        //Pegando informações do usuário que está acessando o sistema 
        $matricula  =  getenv('USERNAME');

         //Listando as empresas
        $Empresas = Empresa::all();
   

        //Listando os contratos
        $Contratos = Contrato::all();
        


        //Buscando informações especificas do ID = $id
        $Macrocelulas = DB::table('MACROCELULA')
            ->where('MACROCELULA.deleted_at', null)
            ->where('MACROCELULA.id_macrocelula', $id)
            ->select('MACROCELULA.*')
            ->get();    


        //Carregando View e repassando as variaveis necessárias
        return view('macrocelulaEditar', ['matricula' => $matricula,
                                 'Empresas'  => $Empresas, 
                                 'Contratos' => $Contratos,
                                 'Macrocelulas' => $Macrocelulas
                                 ]);
    }


    public function incluir(Request $request) 
    {

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('idmacrocelula') == "") { 
            $Macrocelula = new Macrocelula;
        } else {
            $Macrocelula = Macrocelula::find($request->input('idmacrocelula'));
            $Macrocelula->id_macrocelula      = $request->input('idmacrocelula');
        }

        //Capiturando os campos do formulário
        $Macrocelula->id_contrato           = $request->input('idcontrato');
        $Macrocelula->no_macrocelula        = $request->input('nomacrocelula');
        $Macrocelula->ds_macrocelula        = $request->input('dsmacrocelula');
        
        //Salvando formulário
        $Macrocelula->save();

        //Redirecionandopara a página principal
        return redirect()->action('MacrocelulaController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        //Encontrando e deletando Contrato (softDelete)
        $Macrocelula = Macrocelula::find($id);
        $Macrocelula->delete();

        //Redirecionando para a página principal
        return redirect()->action('MacrocelulaController@index')->with('status', 'Macrocelula deletado com sucesso');
    }


}