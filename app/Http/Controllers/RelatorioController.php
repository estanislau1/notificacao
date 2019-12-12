<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contrato as Contrato;
use App\Models\Empresa as Empresa;
use App\Models\macrocelula as Macrocelula;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Indicador as Indicador;
use Illuminate\Support\Collection;
use DB;
//use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;

class RelatorioController extends Controller {

    public function notificacaoporcontrato() {

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
        //Listando os contratos
        //$Macrocelulas = Macrocelula::all();
        //Listando todos os contratos válidos do sistema     
        //$total = DB::select('SELECT COUNT(id_notificacao) NUM, no_empresa FROM NOTIFICACAO, CONTRATOS, EMPRESA WHERE NOTIFICACAO.id_contrato = CONTRATOS.id_contrato AND CONTRATOS.id_empresa = EMPRESA.id_empresa GROUP BY EMPRESA.no_empresa');

        $total = DB::select('SELECT count(NN.id_notificacao), NC.NU_CONTRATO, E.NO_EMPRESA
            FROM "NOTIFICA"."NOTIFICACAO" NN INNER JOIN "NOTIFICA"."CONTRATOS" NC ON NC.ID_CONTRATO = NN.ID_CONTRATO
            INNER JOIN "NOTIFICA"."EMPRESA" E ON NC.ID_EMPRESA = E.ID_EMPRESA
            where NN.deleted_at is null
            GROUP BY NC.NU_CONTRATO,E.NO_EMPRESA
            ORDER BY count(NN.id_notificacao) DESC');

        $total_nao_acatada = DB::select('SELECT count(NN.id_notificacao)
            FROM "NOTIFICA"."NOTIFICACAO" NN 
            where bit_aceito = 55 or bit_aceito = 5
            and deleted_at is null');

        $total_acatada = DB::select('SELECT count(NN.id_notificacao)
            FROM "NOTIFICA"."NOTIFICACAO" NN 
            where bit_aceito = 44 or bit_aceito = 4
            and deleted_at is null');

        $mensal_hitss = DB::select('SELECT id_contrato,extract(year from created_at) as ano,extract(month from created_at) as mes , count(extract(month from created_at)) as total
            FROM "NOTIFICA"."NOTIFICACAO"
            where (bit_aceito = 5 or bit_aceito = 55) 
            and id_contrato = 17
            and deleted_at is null
            group by id_contrato,extract(year from created_at),extract(month from created_at)
            order by mes asc');
        $mensal_cpm = DB::select('SELECT id_contrato,extract(year from created_at) as ano,extract(month from created_at) as mes , count(extract(month from created_at)) as total
            FROM "NOTIFICA"."NOTIFICACAO"
            where (bit_aceito = 5 or bit_aceito = 55) 
            and id_contrato = 19
            and deleted_at is null
            group by id_contrato,extract(year from created_at),extract(month from created_at)
            order by mes asc');
        $mensal_ctis = DB::select('SELECT id_contrato,extract(year from created_at) as ano,extract(month from created_at) as mes , count(extract(month from created_at)) as total
            FROM "NOTIFICA"."NOTIFICACAO"
            where (bit_aceito = 5 or bit_aceito = 55) 
            and id_contrato = 18
            and deleted_at is null
            group by id_contrato,extract(year from created_at),extract(month from created_at)
            order by mes asc');


        //Carregando View e repassando as variáveis necessárias
        return view('relatorio.notificacaoporcontrato', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'arrayPizza' => $total,
            'TotalAcatadas' => $total_acatada,
            'TotalNaoAcatadas' => $total_nao_acatada,
            'mensal_hitss' => $mensal_hitss,
            'mensal_cpm' => $mensal_cpm,
            'mensal_ctis' => $mensal_ctis,
        ]);
    }

    function random_color_part() {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function listarnotificacaoporcoordenacao(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }


        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
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
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
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
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data_created')
                    ->get();


            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 44, 5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', DB::raw("count('NOTIFICACAO.id_indicador') as total"), 'NOTIFICACAO_MOTIVO.id_motivo as id_motivo', DB::raw("count('NOTIFICACAO_MOTIVO.id_motivo') as total_mot"))
                    ->groupBy('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', 'NOTIFICACAO_MOTIVO.id_motivo')
                    ->get();
            $QtdCoordenacoes = DB::table('COORDENACOES')->count();
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
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data_created')
                    ->get();


            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 44, 5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', DB::raw("count('NOTIFICACAO.id_indicador') as total"), 'NOTIFICACAO_MOTIVO.id_motivo as id_motivo', DB::raw("count('NOTIFICACAO_MOTIVO.id_motivo') as total_mot"))
                    ->groupBy('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', 'NOTIFICACAO_MOTIVO.id_motivo')
                    ->get();
            $QtdCoordenacoes = DB::table('COORDENACOES')->count();
        }



        return view('relatorio.relatoriomensal', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'All' => $All,
            'QtdCoord' => $QtdCoordenacoes,
        ]);
    }

    public function listarnotificacaoporcoordenacaoind(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
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
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
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
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data')
                    ->get();

            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 44, 5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', DB::raw("count('NOTIFICACAO.id_indicador') as total"), 'NOTIFICACAO_MOTIVO.id_motivo as id_motivo', DB::raw("count('NOTIFICACAO_MOTIVO.id_motivo') as total_mot"))
                    ->groupBy('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', 'NOTIFICACAO_MOTIVO.id_motivo')
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
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data')
                    ->get();

            $All = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 44, 5, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', DB::raw("count('NOTIFICACAO.id_indicador') as total"), 'NOTIFICACAO_MOTIVO.id_motivo as id_motivo', DB::raw("count('NOTIFICACAO_MOTIVO.id_motivo') as total_mot"))
                    ->groupBy('NOTIFICACAO.id_notificacao', 'NOTIFICACAO.id_notificadora', 'NOTIFICACAO.id_indicador', 'NOTIFICACAO.bit_aceito', 'NOTIFICACAO_MOTIVO.id_motivo')
                    ->get();
        }



        return view('relatorio.relatoriomensalindicador', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'All' => $All,
        ]);
    }

    public function notificacaoporcoordenacao() {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');
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

    public function notificacaoporcoordenacaoind() {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');
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


        return view('relatorio.relatoriomensalindicador', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'All' => $All,
        ]);
    }

    public function notificacaogeral() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        $matricula = session('matricula');
        $mes = \Carbon\Carbon::now()->month;
        //Listando as empresas
        $Empresas = Empresa::all();
        $Indicadores = Indicador::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Display_table = 'none';

        //Listando todos os contratos válidos do sistema     
        $Notificacoes = DB::table('NOTIFICACAO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                ->where('NOTIFICACAO.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes)
                ->whereIn('bit_aceito', array(4, 5, 44, 55))
                ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO_MOTIVO.*')
                ->get();
        return view('relatorio.relatoriomensalgeral', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'Display_table' => $Display_table,
        ]);
    }

    public function listarnotificacaogeral(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
        $id_coordenacao = $request->input('id_coordenacao');
        $Display_table = 'true';

        //Listando as empresas
        $Empresas = Empresa::all();

        $Indicadores = Indicador::all();

        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();

        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        if ($id_coordenacao != 999) {
            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
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
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data')
                    ->get();
        } else {

            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data', 'NOTIFICACAO_MOTIVO.*')
                    ->get();
            $TotalContratos = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->join('NOTIFICACAO_MOTIVO', 'NOTIFICACAO_MOTIVO.id_notificacao', '=', 'NOTIFICACAO.id_notificacao')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->distinct()
                    ->select('CONTRATOS.nu_contrato', 'CONTRATOS.id_empresa')
                    ->get();
        }
        return view('relatorio.relatoriomensalgeral', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'TotalContrato' => $TotalContratos,
            'Display_table' => $Display_table,
        ]);
    }

    public function notificacaoreabertas() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        $matricula = session('matricula');
        $mes = \Carbon\Carbon::now()->month;
        //Listando as empresas
        $Empresas = Empresa::all();
        $Indicadores = Indicador::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Display_table = 'none';

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
        return view('relatorio.relatoriomensalreabertas', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'Display_table' => $Display_table,
        ]);
    }

    public function listarnotificacaoreabertas(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
        $id_contrato = $request->input('id_contrato');
        $id_coordenacao = $request->input('id_coordenacao');
        $Display_table = 'true';

        //Listando as empresas
        $Empresas = Empresa::all();

        $Indicadores = Indicador::all();

        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();

        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        if ($id_coordenacao != 999) {
            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->whereNotNull('NOTIFICACAO.reaberto')
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
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
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data')
                    ->get();
        } else {

            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('INDICADOR', 'INDICADOR.id_indicador', '=', 'NOTIFICACAO.id_indicador')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->whereNotNull('NOTIFICACAO.reaberto')
                    ->where('CONTRATOS.deleted_at', null)
                    ->whereIn('bit_aceito', array(4, 5, 44, 55))
                    ->when($mes, function ($query) use ($mes) {
                        return $query->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($mes, function ($query) use ($ano) {
                        return $query->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->when($id_contrato, function ($query) use ($id_contrato) {
                        return $query->where('NOTIFICACAO.id_contrato', '=', $id_contrato);
                    }, function ($query) {
                        //return $query->orderBy('name');
                    })
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'INDICADOR.*', 'NOTIFICACAO.created_at as data')
                    ->get();
        }
        return view('relatorio.relatoriomensalreabertas', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes,
            'Indicadores' => $Indicadores,
            'Display_table' => $Display_table,
        ]);
    }

    public function relslm() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        $matricula = session('matricula');
        $mes = \Carbon\Carbon::now()->month;
        //Listando as empresas
        $Empresas = Empresa::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Display_table = 'none';

        $Slm = DB::select('SELECT c.nu_contrato,s.id_indicador,s.status,s.nu_slm,count(s.id_slm) as total
         FROM "NOTIFICA"."SLM" s join "NOTIFICA"."CONTRATOS" c on s.id_contrato = c.id_contrato
         where (status = 3 or status = 33 or status = 4 or status = 44)
	and s.deleted_at is null 
	group by c.nu_contrato,s.id_indicador,s.status,s.nu_slm
	order by c.nu_contrato,s.id_indicador,s.status, total desc');

        //Carregando View e repassando as variáveis necessárias
        return view('relatorio.relatoriomensalslm', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm,
            'Display_table' => $Display_table
        ]);
    }

    public function reldescumprimento() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        $matricula = session('matricula');
        $mes = \Carbon\Carbon::now()->month;
        //Listando as empresas
        $Empresas = Empresa::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Display_table = 'none';

        $Descumprimentos = DB::table('DESCUMPRIMENTO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'DESCUMPRIMENTO.id_contrato')
                ->where('DESCUMPRIMENTO.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "DESCUMPRIMENTO".created_at) = ' . $mes)
                ->whereIn('status', array(4, 5))
                ->get();

        return view('relatorio.relatoriomensaldescumprimento', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimentos,
            'Display_table' => $Display_table,
        ]);
    }

    public function listarslm(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
        $Display_table = 'true';

        $Empresas = Empresa::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        $Slm = DB::select('SELECT c.nu_contrato,s.id_indicador,s.status,s.nu_slm,count(s.id_slm) as total
         FROM "NOTIFICA"."SLM" s join "NOTIFICA"."CONTRATOS" c on s.id_contrato = c.id_contrato
         where (status = 3 or status = 33 or status = 4 or status = 44)
	and s.deleted_at is null 
        and extract(Month from s.created_at) =' . $mes .
                        'and extract(Year from s.created_at) =' . $ano .
                        'group by c.nu_contrato,s.id_indicador,s.status,s.nu_slm
	order by c.nu_contrato,s.id_indicador,s.status,total desc ');

         /*$Slm2 = DB::table('SLM')
          ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'SLM.id_contrato')
          ->where('CONTRATOS.deleted_at', null)
          ->where('SLM.deleted_at', null)
          ->WhereRaw('EXTRACT(Month from "SLM".created_at) = ' . $mes)
          ->WhereRaw('EXTRACT(Year from "SLM".created_at) = ' . $ano)
          ->whereIn('status', array(3,33,4,44))
          ->groupBy('CONTRATOS.nu_contrato','SLM.id_indicador', 'SLM.status')
          ->orderBy('CONTRATOS.nu_contrato', 'desc')
          ->orderBy('SLM.id_indicador', 'desc')
          ->orderBy('SLM.status', 'desc')

          ->get();
          * 
          */
   

        return view('relatorio.relatoriomensalslm', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm,
            'Display_table' => $Display_table
        ]);
    }

    public function listardescumprimentos(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');
        $id_contrato = $request->input('id_contrato');
        $id_coordenacao = $request->input('id_coordenacao');
        $Display_table = 'true';

        //Listando as empresas
        $Empresas = Empresa::all();

        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();

        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        $Descumprimentos = DB::table('DESCUMPRIMENTO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'DESCUMPRIMENTO.id_contrato')
                ->where('DESCUMPRIMENTO.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "DESCUMPRIMENTO".created_at) = ' . $mes)
                ->whereIn('status', array(4, 5))
                ->when($mes, function ($query) use ($mes) {
                    return $query->WhereRaw('EXTRACT(Month from "DESCUMPRIMENTO".created_at) = ' . $mes);
                }, function ($query) {
                    //return $query->orderBy('name');
                })
                ->when($mes, function ($query) use ($ano) {
                    return $query->WhereRaw('EXTRACT(Year from "DESCUMPRIMENTO".created_at) = ' . $ano);
                }, function ($query) {
                    //return $query->orderBy('name');
                })
                ->when($id_contrato, function ($query) use ($id_contrato) {
                    return $query->where('DESCUMPRIMENTO.id_contrato', '=', $id_contrato);
                }, function ($query) {
                    //return $query->orderBy('name');
                })
                ->select('CONTRATOS.*', 'DESCUMPRIMENTO.*', 'DESCUMPRIMENTO.created_at as data')
                ->get();

        return view('relatorio.relatoriomensaldescumprimento', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimentos,
            'Display_table' => $Display_table,
        ]);
    }

}
