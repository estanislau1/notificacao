<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato; 
use App\Models\Indicador as Indicador;  
use App\Models\Coordenacao as Coordenacao;

use Illuminate\Http\Request;
use DB;




class IndicadorController extends Controller
{
    public function index()
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

        //Listando as empresas
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
        //Listando todos os contratos válidos do sistema     
        $Indicadores = DB::table('INDICADOR')
            ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'INDICADOR.id_contrato')
            ->where('INDICADOR.deleted_at', null)
            ->select('CONTRATOS.*', 'INDICADOR.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('indicador', ['matricula'   => $matricula, 
                                 'Indicadores'  => $Indicadores,
                                 'Contratos'    => $Contratos,
        						 'Coordenacoes' => $Coordenacoes,
                                 ]);

    }





    public function editar($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        
        //Pegando informações do usuário que está acessando o sistema 
        $matricula  =  getenv('USERNAME');

         //Listando os contratos
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
        
        //Buscando informações especificas do ID = $id
        
      $Indicadores = DB::table('INDICADOR')
            ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'INDICADOR.id_contrato')
            ->where('INDICADOR.deleted_at', null)
            ->where('INDICADOR.id_indicador', $id)
            ->select('CONTRATOS.*', 'INDICADOR.*')
            ->get();    



        //Carregando View e repassando as variaveis necessárias
        return view('indicadorEditar', ['matricula' => $matricula,
                                 		'Indicadores'  => $Indicadores, 
                                 		'Contratos' => $Contratos,
        								'Coordenacoes' => $Coordenacoes,

                                 ]);
    }


    public function incluir(Request $request) 
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('id_indicador') == "") { 
            $Indicador = new Indicador;
        } else {
            $Indicador = Indicador::find($request->input('id_indicador'));
            $Indicador->id_indicador = $request->input('id_indicador');
        }

        //Capiturando os campos do formulário
        $Indicador->id_contrato         = $request->input('id_contrato');
        $Indicador->sg_indicador        = $request->input('sg_indicador');
        $Indicador->no_indicador        = $request->input('no_indicador');
        $Indicador->ds_indicador        = $request->input('ds_indicador');
        

        //Salvando formulário
        $Indicador->save();

        //Redirecionandopara a página principal
        return redirect()->action('IndicadorController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Indicador = Indicador::find($id);
        $Indicador->delete();

        //Redirecionando para a página principal
        return redirect()->action('IndicadorController@index')->with('status', 'Indicador deletado com sucesso');
    }


}