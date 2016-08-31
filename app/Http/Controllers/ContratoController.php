<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato; 
use App\Models\Empresa as Empresa; 


use Illuminate\Http\Request;
use DB;




class ContratoController extends Controller
{
    public function index()
    {

        //Pegando informações do usuário que está acessando o sistema
        $matricula  =   getenv('USERNAME');

        //Listando as empresas
        $Empresas = Empresa::all();

        //Listando todos os contratos válidos do sistema     
        $Contratos = DB::table('CONTRATOS')
            ->join('EMPRESA', 'CONTRATOS.id_empresa', '=', 'EMPRESA.id_empresa')
            ->where('CONTRATOS.deleted_at', null)
            ->select('CONTRATOS.*', 'EMPRESA.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('contrato', ['matricula' => $matricula,
                                 'Empresas'  => $Empresas, 
                                 'Contratos' => $Contratos
                                 ]);

    }





    public function editar($id)
    {
        
        //Pegando informações do usuário que está acessando o sistema 
        $matricula  =  getenv('USERNAME');

         //Listando as empresas
        $Empresas = Empresa::all();

        //Buscando informações especificas do ID = $id
        $Contratos = DB::table('CONTRATOS')
            ->join('EMPRESA', 'CONTRATOS.id_empresa', '=', 'EMPRESA.id_empresa')
            ->where('CONTRATOS.deleted_at', null)
            ->where('CONTRATOS.id_contrato', $id)
            ->select('CONTRATOS.*', 'EMPRESA.*')
            ->get();    


        //Carregando View e repassando as variaveis necessárias
        return view('contratoEditar', ['matricula' => $matricula,
                                 'Empresas'  => $Empresas, 
                                 'Contratos' => $Contratos

                                 ]);
    }


    public function incluir(Request $request) 
    {

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('idcontrato') == "") { 
            $Contrato = new Contrato;
        } else {
            $Contrato = Contrato::find($request->input('idcontrato'));
            $Contrato->id_contrato      = $request->input('idcontrato');
        }

        //Capiturando os campos do formulário
        $Contrato->id_empresa       = $request->input('idempresa');
        $Contrato->nu_contrato      = $request->input('nucontrato');
        $Contrato->dt_assinatura    = $request->input('dtassinatura');
        $Contrato->dt_renovacao =   empty($request->input('dtrenovacao')) ? null : $request->input('dtrenovacao');

        //Salvando formulário
        $Contrato->save();

        //Redirecionandopara a página principal
        return redirect()->action('ContratoController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        //Encontrando e deletando Contrato (softDelete)
        $Contrato = Contrato::find($id);
        $Contrato->delete();

        //Redirecionando para a página principal
        return redirect()->action('ContratoController@index')->with('status', 'Contrato deletado com sucesso');
    }


}