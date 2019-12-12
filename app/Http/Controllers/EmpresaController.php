<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa; 
use App\Models\Contrato as Contrato;
use App\Models\Coordenacao as Coordenacao;


use Illuminate\Http\Request;
use DB;




class EmpresaController extends Controller
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
        $Coordenacoes = Coordenacao::all();
        
        
        //Listando todos os contratos válidos do sistema     
        $Contratos = DB::table('CONTRATOS')
            ->join('EMPRESA', 'CONTRATOS.id_empresa', '=', 'EMPRESA.id_empresa')
            ->where('CONTRATOS.deleted_at', null)
            ->select('CONTRATOS.*', 'EMPRESA.*')
            ->get();  

        //Carregando View e repassando as variáveis necessárias
        return view('empresa', [ 'matricula' => $matricula,
                                 'Empresas'  => $Empresas,
                                 'Contratos' => $Contratos,
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
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
         //Listando as empresas
        $Empresas = DB::table('EMPRESA')
                    ->where('EMPRESA.id_empresa', $id)
                    ->select('EMPRESA.*')
                    ->get();

        
        //Carregando View e repassando as variaveis necessárias
        return view('empresaEditar', [  'matricula' => $matricula,
                                        'Empresas'  => $Empresas,
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
        if($request->input('idempresa') == "") { 
            $Empresa = new Empresa;
        } else {
            $Empresa = Empresa::find($request->input('idempresa'));
            $Empresa->id_empresa      = $request->input('idempresa');
        }

        //Capiturando os campos do formulário
        $Empresa->ds_cnpj       = $request->input('dscnpj');
        $Empresa->no_empresa      = $request->input('noempresa');
     
        //Salvando formulário
        $Empresa->save();

        //Redirecionandopara a página principal
        return redirect()->action('EmpresaController@index')->with('status', 'Sua solicitação foi executada com sucesso!');


    }


    public function delete($id)
    {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Empresa = Empresa::find($id);
        $Empresa->delete();

        //Redirecionando para a página principal
        return redirect()->action('EmpresaController@index')->with('status', 'Empresa excluida com sucesso!');
    }


}