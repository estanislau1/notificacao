<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coordenacao as Coordenacao; 
use App\Models\Rh as Rh; 
use App\Models\Contrato as Contrato;

use Illuminate\Http\Request;
use DB;



class RhController extends Controller
{
	
	public function __construct() {
	
	}
	
    public function index()
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

        //Listando todas as coordenações 
        $Coordenacoes 	= Coordenacao::all();
        $Contratos 		= Contrato::all();

        //Listando todos os contratos válidos do sistema     
        $Agentes = DB::table('AGENTE_RH')
            ->where('AGENTE_RH.deleted_at', null)
            ->select('AGENTE_RH.*')
            ->get();    

        //Carregando View e repassando as variáveis necessárias
        return view('rh', [ 'matricula' 	=> $matricula,
                                'Coordenacoes' 	=> $Coordenacoes,
                                'Agentes'  		=> $Agentes,
                                'Contratos' 	=> $Contratos
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
	        $Contratos = Contrato::all();
          //Listando todas as coordenações 
    	    $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Agentes = DB::table('AGENTE_RH')
		             ->where('AGENTE_RH.deleted_at', null)
		             ->where('AGENTE_RH.id_rh', $id)
		             ->select('AGENTE_RH.*')
		             ->get();    


        //Carregando View e repassando as variaveis necessárias
        return view('rhEditar', [   	'matricula' 	=> $matricula,
                                        'Coordenacoes' 	=> $Coordenacoes,
                                        'Contratos'     => $Contratos, 
                                        'Agentes' 		=> $Agentes
                                    ]);
    }


    public function incluir(Request $request) 
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if($request->input('idrh') == "") { 
            $Rh = new Rh;
        } else {
            $Rh = Rh::find($request->input('idrh'));
            $Rh->id_rh          = $request->input('idrh');
        }

        //Capiturando os campos do formulário
        $Rh->no_rh              = $request->input('no_rh');
        $Rh->ma_rh              = $request->input('ma_rh');

        //Salvando formulário
        $Rh->save();

        //Redirecionandopara a página principal
        return redirect()->action('RhController@index')->with('status', 'Sua solicitação foi executada com sucesso!');
    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Rh = Rh::find($id);
        $Rh->delete();

        //Redirecionando para a página principal
        return redirect()->action('RhController@index')->with('status', 'Agente deletado com sucesso');
    }


}