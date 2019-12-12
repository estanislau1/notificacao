<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa; 
use App\Models\Coordenacao as Coordenacao; 
use App\Models\Contrato as Contrato;
use Illuminate\Http\Request; 
use DB;




class CoordenacaoController extends Controller
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
        $Contratos = Contrato::all();
		
        //Listando todos os Coordenacoes válidos do sistema     
        $Coordenacoes = DB::table('COORDENACOES')
            ->where('COORDENACOES.deleted_at', null)
            ->select('COORDENACOES.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('coordenacao', ['matricula' => $matricula,
                                    'Empresas'  => $Empresas, 
                                    'Coordenacoes' => $Coordenacoes,
                                    'Contratos' => $Contratos
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

         //Listando as empresas
        $Empresas = Empresa::all();
        $Contratos = Contrato::all() ;
        
        //Buscando informações especificas do ID = $id
        $Coordenacoes = DB::table('COORDENACOES')
            ->where('COORDENACOES.deleted_at', null)
            ->where('COORDENACOES.id_coordenacao', $id)
            ->select('COORDENACOES.*')
            ->get();    


        //Carregando View e repassando as variaveis necessárias
        return view('coordenacaoEditar', [  'matricula' => $matricula,
                                            'Empresas'  => $Empresas, 
                                            'Coordenacoes' => $Coordenacoes,
                                            'Contratos' => $Contratos

                                 ]);
    }


    public function incluir(Request $request) 
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('idcoordenacao') == "") { 
            $Coordenacao = new Coordenacao;
        } else {
            $Coordenacao = Coordenacao::find($request->input('idcoordenacao'));
            $Coordenacao->id_coordenacao    = $request->input('idcoordenacao');
        }

        //Capiturando os campos do formulário
        $Coordenacao->nu_coordenacao        = $request->input('nucoordenacao');
        $Coordenacao->no_coordenacao        = $request->input('nocoordenacao');
        $Coordenacao->ds_coordenacao        = $request->input('dscoordenacao');
        $Coordenacao->ds_email              = $request->input('dsemail');
        
        //Salvando formulário
        $Coordenacao->save();

        //Redirecionandopara a página principal
        return redirect()->action('CoordenacaoController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }   
        //Encontrando e deletando Coordenacao (softDelete)
        $Coordenacao = Coordenacao::find($id);
        $Coordenacao->delete();

        //Redirecionando para a página principal
        return redirect()->action('CoordenacaoController@index')->with('status', 'Coordenação deletada com sucesso');
    }


}