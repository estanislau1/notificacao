<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coordenacao as Coordenacao; 
use App\Models\Empresa as Empresa; 
use App\Models\Gestor as Gestor; 
use App\Models\Contrato as Contrato;



use Illuminate\Http\Request;
use DB;




class GestorController extends Controller
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

        //Listando todas as coordenações 
        $Coordenacoes = Coordenacao::all();
        $Contratos = Contrato::all();

        //Listando todos os contratos válidos do sistema     
        $Gestores = DB::table('GESTOR_COORDENACAO')
            ->join('COORDENACOES', 'COORDENACOES.id_coordenacao', '=', 'GESTOR_COORDENACAO.id_coordenacao')
            ->where('GESTOR_COORDENACAO.deleted_at', null)
            ->select('COORDENACOES.*', 'GESTOR_COORDENACAO.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('gestor', [ 'matricula' => $matricula,
                                'Empresas'  => $Empresas, 
                                'Coordenacoes' => $Coordenacoes,
                                'Gestores'  => $Gestores,
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
        $Contratos = Contrato::all();

          //Listando todas as coordenações 
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Gestores = DB::table('GESTOR_COORDENACAO')
            ->join('COORDENACOES', 'COORDENACOES.id_coordenacao', '=', 'GESTOR_COORDENACAO.id_coordenacao')
            ->where('GESTOR_COORDENACAO.deleted_at', null)
            ->where('GESTOR_COORDENACAO.id_gestor', $id)
            ->select('GESTOR_COORDENACAO.*', 'COORDENACOES.*')
            ->get();    


        //Carregando View e repassando as variaveis necessárias
        return view('gestorEditar', [   'matricula' => $matricula,
                                        'Empresas'  => $Empresas,
                                        'Coordenacoes' => $Coordenacoes,
                                        'Contratos'     => $Contratos, 
                                        'Gestores' => $Gestores                                 
                                    ]);
    }


    public function incluir(Request $request) 
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('idgestor') == "") { 
            $Gestor = new Gestor;
        } else {
            $Gestor = Gestor::find($request->input('idgestor'));
            $Gestor->id_gestor          = $request->input('idgestor');
        }

        //Capiturando os campos do formulário
        $Gestor->id_coordenacao         = $request->input('idcoordenacao');
        $Gestor->no_gestor              = $request->input('nogestor');
        $Gestor->ma_gestor              = $request->input('magestor');

        //Salvando formulário
        $Gestor->save();

        //Redirecionandopara a página principal
        return redirect()->action('GestorController@index')->with('status', 'Sua solicitação foi executada com sucesso!');
    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Gestor = Gestor::find($id);
        $Gestor->delete();

        //Redirecionando para a página principal
        return redirect()->action('GestorController@index')->with('status', 'Contrato deletado com sucesso');
    }


}