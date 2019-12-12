<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa; 
use App\Models\Contrato as Contrato; 
use App\Models\Preposto as Preposto; 
use App\Models\Coordenacao as Coordenacao;

use Illuminate\Http\Request;
use DB;


class PrepostoController extends Controller
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
        $Empresas = Empresa::all();
        $Coordenacoes = Coordenacao::all();
        
        //Listando os contratos    
        $Contratos = Contrato::all();

        //Listando todos os contratos válidos do sistema     
        $Prepostos = DB::table('PREPOSTO')
            ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'PREPOSTO.id_contrato')
            ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
            ->where('PREPOSTO.deleted_at', null)
            ->where('CONTRATOS.deleted_at', null)
            ->select('CONTRATOS.*', 'PREPOSTO.*', 'EMPRESA.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('preposto', ['matricula' => $matricula,
                                 'Empresas'  => $Empresas, 
                                 'Contratos' => $Contratos,
                                 'Prepostos' => $Prepostos,
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
        $matricula = session('matricula');

         //Listando as empresas
        $Empresas = Empresa::all();

        //Listando os contratos    
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
        //Buscando informações especificas do ID = $id
        $Prepostos = DB::table('PREPOSTO')
            ->where('PREPOSTO.id_preposto', $id)
            ->select('PREPOSTO.*')
            ->get();   


        //Carregando View e repassando as variaveis necessárias
        return view('prepostoEditar', [ 'matricula' => $matricula,
                                        'Empresas'  => $Empresas, 
                                        'Contratos' => $Contratos, 
                                        'Prepostos' => $Prepostos,
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
        if($request->input('idpreposto') == "") { 
            $Preposto = new Preposto;
        } else {
            $Preposto = Preposto::find($request->input('idpreposto'));
            $Preposto->id_preposto    = $request->input('idpreposto');
        }

        //Capiturando os campos do formulário
        $Preposto->id_contrato       = $request->input('idcontrato');
        $Preposto->ma_preposto      = $request->input('mapreposto');
        $Preposto->no_preposto    = $request->input('nopreposto');
        

        //Salvando formulário
        $Preposto->save();

        //Redirecionandopara a página principal
        return redirect()->action('PrepostoController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Preposto = Preposto::find($id);
        $Preposto->delete();

        //Redirecionando para a página principal
        return redirect()->action('PrepostoController@index')->with('status', 'Preposto deletado com sucesso');
    }


}