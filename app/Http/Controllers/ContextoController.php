<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa; 
use App\Models\Contexto as Contexto; 
use App\Models\Contrato as Contrato;

use Illuminate\Http\Request;
use DB;




class ContextoController extends Controller
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
        
        //Listando todos os contratos válidos do sistema     
        $Contextos = DB::table('CONTEXTO')
            ->where('CONTEXTO.deleted_at', null)
            ->select('CONTEXTO.*')
            ->get();    



        //Carregando View e repassando as variáveis necessárias
        return view('contexto', ['matricula' => $matricula,
                                 'Contextos'  => $Contextos, 
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
        $Contratos = Contrato::all();

         //Listando as empresas
        $Contextos = DB::table('CONTEXTO')
                    ->where('CONTEXTO.id_contexto', $id)
                    ->select('CONTEXTO.*')
                    ->get();

        
        //Carregando View e repassando as variaveis necessárias
        return view('contextoEditar', ['matricula' => $matricula,
                                        'Contextos'  => $Contextos,
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
        if($request->input('idcontexto') == "") { 
            $Contexto = new Contexto;
        } else {
            $Contexto = Contexto::find($request->input('idcontexto'));
            $Contexto->id_contexto      = $request->input('idcontexto');
        }

        //Capiturando os campos do formulário
        $Contexto->no_contexto       = $request->input('nocontexto');
       
     
        //Salvando formulário
        $Contexto->save();

        //Redirecionandopara a página principal
        return redirect()->action('ContextoController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Contexto = Contexto::find($id);
        $Contexto->delete();

        //Redirecionando para a página principal
        return redirect()->action('ContextoController@index')->with('status', 'Contexto excluido com sucesso!');
    }


}