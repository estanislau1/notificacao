<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Preposto as Preposto;
use App\Models\Acesso as Acesso;
use App\Models\Rh as R;
use App\Models\Contexto as Contexto;
use App\Models\Macrocelula as Macrocelula;
use App\Models\Celula as Celula;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Impacto as Impacto;
use App\Models\Motivo as Motivo;
use App\Models\Indicador as Indicador;
use App\Models\Notificacao as Notificacao;
use Carbon\Carbon as Carbon;
use Crypt as Crypt;
use Illuminate\Http\Request;
use DB;
use Adldap\Laravel\Facades\Adldap;

class AcessoController extends Controller {

    public function index() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

        $Coordenacoes = Coordenacao::all();
        $Contratos = Contrato::all();
        //Listando todos os contratos válidos do sistema     
        $acesso = DB::table('ACESSO')
                ->where('ACESSO.deleted_at', null)
                ->select('ACESSO.*')
                ->get();

        //Carregando View e repassando as variáveis necessárias
        return view('acesso', ['matricula' => $matricula,
            'Coordenacoes' => $Coordenacoes,
            'Contratos' => $Contratos,
            'Acesso' => $acesso,
        ]);
    }

    public function editar($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Coordenacoes = Coordenacao::all();
        $Contratos = Contrato::all();

        $Acesso = DB::table('ACESSO')
                ->where('ACESSO.id_acesso', $id)
                ->select('ACESSO.*')
                ->orderBy('created_at', 'desc')
                ->get();


        //Carregando View e repassando as variaveis necessárias
        return view('acessoEditar', [ 'matricula' => $matricula,
            'Coordenacoes' => $Coordenacoes,
            'Contratos' => $Contratos,
            'Acesso' => $Acesso,
        ]);
    }

    public function incluir(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if ($request->input('idacesso') == "") {
            $Acesso = new Acesso;
        } else {
            $Acesso = Acesso::find($request->input('idacesso'));
            $Acesso->id_acesso = $request->input('idacesso');
        }

        //Capiturando os campos do formulário
        $Acesso->matricula = $request->input('matricula');
        $Acesso->nome = $request->input('nome');
        //Salvando formulário
        $Acesso->save();

        //Redirecionandopara a página principal
        return redirect()->action('AcessoController@index')->with('status', 'Sua solicitação foi executada com sucesso!');
    }

    public function delete($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Acesso = Acesso::find($id);
        $Acesso->delete();

        //Redirecionando para a página principal
        return redirect()->action('AcessoController@index')->with('status', 'Supervisor deletado com sucesso!');
    }

}
