<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato;
use App\Models\Empresa as Empresa;
use App\Models\celula as Celula;
use App\Models\macrocelula as Macrocelula;
use Illuminate\Http\Request;
use DB;

class CelulaController extends Controller {

    public function index() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

        //Listando as empresas
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();

        //Listando os contratos
        $Macrocelulas = Macrocelula::all();


        //Listando todos os contratos válidos do sistema     
        $Celulas = DB::table('CELULA')
                ->join('MACROCELULA', 'MACROCELULA.id_macrocelula', '=', 'CELULA.id_macrocelula')
                ->where('CELULA.deleted_at', null)
                ->select('MACROCELULA.*', 'CELULA.*')
                ->get();


        //Carregando View e repassando as variáveis necessárias
        return view('celula', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Celulas' => $Celulas,
            'Contratos' => $Contratos,
            'Macrocelulas' => $Macrocelulas
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
        $Contratos = Contrato::all();
        //Listando os macrocelulas
        $Macrocelulas = Macrocelula::all();



        //Buscando informações especificas do ID = $id
        $Celulas = DB::table('CELULA')
                ->where('CELULA.deleted_at', null)
                ->where('CELULA.id_celula', $id)
                ->select('CELULA.*')
                ->get();


        //Carregando View e repassando as variaveis necessárias
        return view('celulaEditar', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Macrocelulas' => $Macrocelulas,
            'Contratos' => $Contratos,
            'Celulas' => $Celulas
        ]);
    }

    public function incluir(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        //Verificando se a solicitação veio da inclusão ou edição
        if ($request->input('idcelula') == "") {
            $celula = new celula;
        } else {
            $celula = celula::find($request->input('idcelula'));
            $celula->id_celula = $request->input('idcelula');
        }

        //Capiturando os campos do formulário
        $celula->id_macrocelula = $request->input('idmacrocelula');
        $celula->no_celula = $request->input('nocelula');
        $celula->ds_celula = $request->input('dscelula');

        //Salvando formulário
        $celula->save();

        //Redirecionandopara a página principal
        return redirect()->action('CelulaController@index')->with('status', 'Sua solicitação foi executada com sucesso!');
    }

    public function delete($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
//Encontrando e deletando Contrato (softDelete)
        $celula = celula::find($id);
        $celula->delete();

        //Redirecionando para a página principal
        return redirect()->action('CelulaController@index')->with('status', 'Celula deletada com sucesso');
    }

}
