<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato;
use App\Models\Empresa as Empresa;
use App\Models\macrocelula as Macrocelula;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Indicador as Indicador;
use DB;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;

class RelatorioController extends Controller {

    public function notificacaoporcontrato() {

        //Pegando informações do usuário que está acessando o sistema
        $matricula = getenv('USERNAME');

        //Listando as empresas
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
        //Listando os contratos
        $Macrocelulas = Macrocelula::all();


        //Listando todos os contratos válidos do sistema     
        //$total = DB::select('SELECT COUNT(id_notificacao) NUM, no_empresa FROM NOTIFICACAO, CONTRATOS, EMPRESA WHERE NOTIFICACAO.id_contrato = CONTRATOS.id_contrato AND CONTRATOS.id_empresa = EMPRESA.id_empresa GROUP BY EMPRESA.no_empresa');

        $total = DB::select('SELECT count(NN.id_notificacao), NC.NU_CONTRATO FROM 
											"NOTIFICA"."NOTIFICACAO" NN
											INNER JOIN "NOTIFICA"."CONTRATOS" NC ON NC.ID_CONTRATO = NN.ID_CONTRATO
											GROUP BY NC.NU_CONTRATO');


//         $strpizza[][] = '';
//         $count = 1; 
//         foreach($total as $p) { 
//         	//$strpizza[][$count] =  " { label: '". $p->nu_contrato ."', data: [[ ".$p->count ." ]], color: '#". $this->random_color() ."'}, ";
//         	$strpizza[1][$count] =   $p->nu_contrato;
//         	$strpizza[2][$count] =   $p->count;
//         	$strpizza[3][$count] =   "#". $this->random_color();
//         	$count = $count + 1;
//         }
        //Carregando View e repassando as variáveis necessárias
        return view('relatorio.notificacaoporcontrato', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Macrocelulas' => $Macrocelulas,
            'arrayPizza' => $total,
        ]);
    }

    function random_color_part() {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function listarnotificacaoporcoordenacao(Request $request) {
        $matricula = getenv('USERNAME');

        $mes = $request->input('mes');
        $id_contrato = $request->input('id_contrato');
        $id_coordenacao = $request->input('id_coordenacao');

        //Listando as empresas
        $Empresas = Empresa::all();

        $Indicadores = Indicador::all();

        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();

        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        //Listando todos os contratos válidos do sistema  
        if ($id_coordenacao != 999) {
            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_coordenacao, function ($query) use ($id_coordenacao) {
                        return $query->where('NOTIFICACAO.id_notificadora', '=', $id_coordenacao);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*')
                    ->get();

           
            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4,44,5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito',DB::raw("count('NOTIFICACAO.id_indicador') as total"))
                    ->groupBy('NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador','NOTIFICACAO.bit_aceito')
                    ->get();
            
        } else {
            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*')
                    ->get();

           
            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4,44,5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito',DB::raw("count('NOTIFICACAO.id_indicador') as total"))
                    ->groupBy('NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador','NOTIFICACAO.bit_aceito')
                    ->get();
            
        }



        return view('relatorio.relatoriomensal', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'All' => $All,
        ]);
    }

    public function notificacaoporcoordenacao() {
        $matricula = getenv('USERNAME');
        $mes = \Carbon\Carbon::now()->month;
        //Listando as empresas
        $Empresas = Empresa::all();
        $Indicadores = Indicador::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $All = 'vazio';

        //Listando todos os contratos válidos do sistema     
        $Notificacoes = DB::table('NOTIFICACAO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                ->where('NOTIFICACAO.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes)
                ->whereIn('bit_aceito', array(4, 5, 44, 55))
                ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*')
                ->get();


        return view('relatorio.relatoriomensal', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'All' => $All,
        ]);
    }

}
