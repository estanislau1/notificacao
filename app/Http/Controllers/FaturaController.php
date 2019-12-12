<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Preposto as Preposto;
use App\Models\Fatura as Fatura;
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

class FaturaController extends Controller {

    public function index() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Coordenacoes = Coordenacao::all();

        //Listando os contratos    
        $Contratos = DB::table('CONTRATOS')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('EMPRESA.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->select('CONTRATOS.*', 'EMPRESA.*')
                ->get();

        //Listando todos os contratos válidos do sistema     
        $fatura = DB::table('FATURA')
                ->join('CONTRATOS','CONTRATOS.id_contrato','=','FATURA.id_contrato')
                ->where('FATURA.deleted_at', null)
                ->select('FATURA.*','CONTRATOS.*')
                ->get();



        //Carregando View e repassando as variáveis necessárias
        return view('fatura', ['matricula' => $matricula,
            'Fatura' => $fatura,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
        ]);
    }

    public function editar($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');

        //Listando as empresas
        $Empresas = Empresa::all();

        //Listando os contratos    
        $Contratos = DB::table('CONTRATOS')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('EMPRESA.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->select('CONTRATOS.*', 'EMPRESA.*')
                ->get();

        $Coordenacoes = Coordenacao::all();
        //Buscando informações especificas do ID = $id
        $Fatura = DB::table('FATURA')
                ->where('FATURA.id_fatura', $id)
                ->select('FATURA.*')
                ->orderBy('created_at', 'desc')
                ->get();


        //Carregando View e repassando as variaveis necessárias
        return view('faturaEditar', [ 'matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Fatura' => $Fatura,
            'Coordenacoes' => $Coordenacoes,
        ]);
    }

    public function incluir(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Verificando se a solicitação veio da inclusão ou edição
        if ($request->input('idfatura') == "") {
            $Fatura = new Fatura;
        } else {
            $Fatura = Fatura::find($request->input('idfatura'));
            $Fatura->id_fatura = $request->input('idfatura');
        }

        //Capiturando os campos do formulário
        $Fatura->id_contrato = $request->input('idcontrato');
        $Fatura->mes = $request->input('mes');
        $Fatura->ano = $request->input('ano');
        $Fatura->ordem_servico = $request->input('ordem_servico');
        $Fatura->incidentes = $request->input('incidentes');
        $Fatura->incidentes_p = $request->input('incidentes_p');
        $Fatura->incidentes_d = $request->input('incidentes_d');
        $Fatura->tarefas = $request->input('tarefas');
        $Fatura->pend_amostragem = $request->input('pend_amostragem');
        $Fatura->atributos_branco = $request->input('atributos_branco');
        $Fatura->created_at = Carbon::now();
        $Fatura->pend_processos = $request->input('pend_processos');
        //Salvando formulário
        $Fatura->save();

        //Redirecionandopara a página principal
        return redirect()->action('FaturaController@index')->with('status', 'Sua solicitação foi executada com sucesso!');
    }

    public function delete($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Encontrando e deletando Contrato (softDelete)
        $Fatura = Fatura::find($id);
        $Fatura->delete();

        //Redirecionando para a página principal
        return redirect()->action('FaturaController@index')->with('status', 'Fatura deletada com sucesso!');
    }

}
