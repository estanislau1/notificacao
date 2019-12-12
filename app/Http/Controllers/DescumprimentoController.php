<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Contexto as Contexto;
use App\Models\Macrocelula as Macrocelula;
use App\Models\Celula as Celula;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Impacto as Impacto;
use App\Models\Motivo as Motivo;
use App\Models\Indicador as Indicador;
use Carbon\Carbon as Carbon;
use Crypt as Crypt;
use Illuminate\Http\Request;
use DB;
use App\Models\Descumprimento;
use App\Http\Requests\DescumprimentoMinutaRequest;
use App\Http\Requests\DescumprimentoOficioRequest;
use App\Http\Requests\DescumprimentoEmpresaRequest;

date_default_timezone_set('America/Sao_Paulo');

class DescumprimentoController extends Controller {

    public function index() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

        //Itens do menu esquerda de busca
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();


        //Listando todos os contratos válidos do sistema     
        $Descumprimento = DB::table('DESCUMPRIMENTO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'DESCUMPRIMENTO.id_contrato')
                ->where('DESCUMPRIMENTO.deleted_at', null)
                ->where('DESCUMPRIMENTO.deleted_at', null)
                ->select('CONTRATOS.*', 'DESCUMPRIMENTO.*')
                ->get();


        //Carregando View e repassando as variáveis necessárias
        return view('descumprimento', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function novo() {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');

        //Carregando modulos
        //$Contratos = Contrato::orderBy('nu_contrato','asc')->get();
        $Contratos = DB::table('CONTRATOS')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('EMPRESA.deleted_at', null)
                ->where('CONTRATOS.deleted_at', NULL)
                ->select('CONTRATOS.*', 'EMPRESA.*')
                ->get();
        //$Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        //$Coordenacoes = Coordenacao::all();
        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoNovo', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes
        ]);
    }

    public function avaliar($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoAvaliar', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function avaliarcoordenacao($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoAvaliarCoordenacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function avaliargerente($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoAvaliarGerente', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function avaliarrh($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoAvaliarRh', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function justificar($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoJustificar', [
            'matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function avaliarresposta($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoAvaliarresposta', [
            'matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function ver($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Buscando informações especificas do ID = $id
        $Descumprimento = Descumprimento::find(Crypt::decrypt($id));

        //Carregando View e repassando as variaveis necessárias
        return view('descumprimentoVer', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Descumprimento' => $Descumprimento
        ]);
    }

    public function incluirjustificativa(DescumprimentoEmpresaRequest $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $dij = Descumprimento::find($request->input('id_descumprimento'));

        $dij->ds_justificativa = $request->input('ds_justificativa');
        $dij->ma_justificativa = $matricula;
        $dij->dt_justificativa = Carbon::now();
        $dij->status = 8; //Aguardar avaliação final

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();

        if ($request->file('nome_anexo_empresa')) {

            $doc = $request->file('nome_anexo_empresa');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $dij->nome_anexo_empresa = $prefix . '_' . $doc->getClientOriginalName();
            }
        }


        $dij->save();
        $dd = $dij->nu_descumprimento;

        // INICIO EMAIL
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');

        $email = 'ceptibr012@mail.caixa,' . $eqnotificadoramin . '@mail.caixa';

        $emails = explode(',', $email);

        Mail::send('Emails.d_analisejustificativa', ['empresa' => $nome_empresa_notificada, 'data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
            $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise de Descumprimento Contratual (SADC) – Terceirizadas');
        });
        //fim email
        //Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua justificativa foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluiravaliacao(DescumprimentoMinutaRequest $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $dij = Descumprimento::find($request->input('id_descumprimento'));

        $dij->bit_favoravel = 1;
        $dij->ma_avaliador = $matricula;
        $dij->dt_avaliacao = Carbon::now();
        $dij->tipo = $request->input('tipo');
        $dij->status = 2;

        $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();

        if ($request->file('nome_anexo_rh')) {

            $doc = $request->file('nome_anexo_rh');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $dij->nome_anexo_rh = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

        $dij->save();

        // INICIO EMAIL
        $dd = $dij->nu_descumprimento;
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');

        $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

        $emails = explode(',', $email);

        Mail::send('Emails.d_minuta', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function($message) use($dd, $emails) {
            $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO - Coordenação');
        });
        //fim email
        //Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluiravaliacaocoordenacao(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $dij = Descumprimento::find($request->input('id_descumprimento'));

        $dij->bit_coordenacao = $request->input('bit_coordenacao');
        $dij->ds_avacoordenacao = $request->input('ds_avacoordenacao');
        $dij->ma_avacoordenador = $matricula;
        $dij->dt_avacoordenacao = Carbon::now();

        if ($request->input('bit_coordenacao') == 0) {
            $dij->status = 11; //Retificação - volta para o RH
        } elseif ($request->input('bit_coordenacao') == 2) {
            $dij->status = 9; //Cancelar por determinacao da coordenacao
        } else {
            $dij->status = 3; //continua o fluxo
        }


        $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();


        $dij->save();
        $dd = $dij->nu_descumprimento;

        //------------------------------------------------------------------------------
        if ($request->input('bit_coordenacao') == 0) {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_retificacao_minuta', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO - Coordenação - retificação');
            });
            //fim email
        } elseif ($request->input('bit_coordenacao') == 2) {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_cancelamento_minuta', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO - Coordenação - Cancelamento');
            });
            //fim email
        } else {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa,ceptibr09@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_gerente', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO - Gerência');
            });
            //fim email
        }
//fim email
        //Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluiravaliacaogerente(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $dij = Descumprimento::find($request->input('id_descumprimento'));

        $dij->bit_gerente = $request->input('bit_gerente');
        $dij->ds_avagerente = $request->input('ds_avagerente');
        $dij->ma_avagerente = $matricula;
        $dij->dt_avagerente = Carbon::now();

        if ($request->input('bit_gerente') == 0) {
            $dij->status = 111; //Retificação - volta para o RH
        } elseif ($request->input('bit_gerente') == 2) {
            $dij->status = 99; //Cancelar por determinacao da coordenacao
        } else {
            $dij->status = 6; //continua o fluxo
        }


        $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();


        $dij->save();
        $dd = $dij->nu_descumprimento;

        // INICIO EMAIL
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');
        //------------------------------------------------------------------------------
        if ($request->input('bit_gerente') == 0) {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_retificacao_minuta', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO – Gerencia - retificação');
            });
            //fim email
        } elseif ($request->input('bit_gerente') == 2) {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_cancelamento_minuta', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO – Gerencia - Cancelamento');
            });
            //fim email
        } else {
            // INICIO EMAIL
            $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
            $eqnotificadora = substr($dotificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

            date_default_timezone_set('America/Sao_Paulo');
            $data = Carbon::now()->format('d/m/Y H:i');

            $email = 'ceptibr012@mail.caixa,ceptibr09@mail.caixa';

            $emails = explode(',', $email);

            Mail::send('Emails.d_rh', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise da MINUTA do OFÍCIO - Gerência');
            });
            //fim email
        }
//fim email
        //Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluiravaliacaorh(DescumprimentoOficioRequest $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');
        $dij = Descumprimento::find($request->input('id_descumprimento'));
        $dij->ma_avarh = $matricula;
        $dij->status = 7; //continua fluxo - vai para empresa

        if ($request->file('nome_anexo_rh_oficio')) {

            $doc = $request->file('nome_anexo_rh_oficio');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $dij->nome_anexo_rh_oficio = $prefix . '_' . $doc->getClientOriginalName();
            }
        }
        
        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();

        $dij->save();
        $dd = $dij->nu_descumprimento;

        // INICIO EMAIL
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $empresa_notificada_email_externo = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email_externo');
        $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');
        
        $email = 'ceptibr012@mail.caixa,' . $eqnotificadoramin . '@mail.caixa,' . $empresa_notificada_email . ',' . $empresa_notificada_email_externo ;

        $emails = explode(',', $email);
        $anexo = $dij->nome_anexo_rh_oficio;

        Mail::send('Emails.d_terceirizada', ['empresa' => $nome_empresa_notificada, 'data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails,$anexo) {
            $message->to($emails, 'CEPTIBR012')
                    ->subject('SINOC - Solicitação de Análise de Descumprimento Contratual (SADC) – Terceirizadas')
                    ->attach('../storage/uploads/' . $anexo);
        });
        //fim email            
        //Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluirreavaliacao(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $dij = Descumprimento::find($request->input('id_descumprimento'));

        $dij->bit_acatamento = $request->input('bit_acatamento');
        $dij->ds_reavaliacao = $request->input('ds_reavaliacao');
        $dij->ma_reavaliador = $matricula;
        $dij->dt_reavaliacao = Carbon::now();

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $dij->prazo = $dt_prazo->endOfDay();

        if ($request->input('bit_acatamento') == 0) {
            $dij->status = 5; //Finalizado por avaliação negativa
        } else {
            $dij->status = 4; //Finalizado por avaliação positiva
        }


        $dij->save();
        $dd = $dij->nu_descumprimento;

        // INICIO EMAIL
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $dij->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $dij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');

        $email = 'ceptibr012@mail.caixa,' . $eqnotificadoramin . '@mail.caixa';

        $emails = explode(',', $email);

        Mail::send('Emails.d_parecerfinal', ['empresa' => $nome_empresa_notificada, 'data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function ($message) use ($dd, $emails) {
            $message->to($emails, 'CEPTIBR012')->subject('SINOC - Solicitação de Análise de Descumprimento Contratual (SADC) – Terceirizadas');
        });
        //fim email
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function corrigir($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $dcj = Descumprimento::find(Crypt::decrypt($id));

        $dcj->dt_justificativa = NULL;
        $dcj->dt_naoacatado = NULL;

        $dcj->save();

        #Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')->with('status', 'A notificação pode ser corrigida agora!');
    }

    public function incluir(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        #Criando o objeto Descumprimento
        $d = new Descumprimento;

        $d->id_contrato = $request->input('id_contrato');
        $d->ds_titulo = $request->input('ds_titulo');
        $d->ds_descumprimento = $request->input('ds_descumprimento');
        $d->status = 1;
        $d->ma_cadastro = session('matricula');
        $d->id_impactada = $request->input('id_impactada');
        $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        if ($request->file('nome_anexo')) {

            $doc = $request->file('nome_anexo');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $d->nome_anexo = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

        #Salvando formulário
        $d->save();

        #Pegando o ID do novo registro criado
        $dewId = $d->id_descumprimento;

        #Criando o número da notificação baseado no ID recém criado.
        $dd = "D" . Carbon::parse(Carbon::now())->format('Ym') . $dewId;
        $dcj = Descumprimento::find($dewId);
        $dcj->nu_descumprimento = $dd;
        $dcj->save();
        //------------------------------------------------------------------------------
        // INICIO EMAIL
        $dotificadora = DB::table('COORDENACOES')->where('id_coordenacao', $d->id_impactada)->value('no_coordenacao');
        $eqnotificadora = substr($dotificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $d->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $dome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');

        $email = 'ceptibr012@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

        $emails = explode(',', $email);

        Mail::send('Emails.d_abertura', ['data' => $data, 'notificadora' => $eqnotificadora, 'numdesc' => $dd], function($message) use($dd, $emails) {
            $message->to($emails, 'CEPTIBR012')
                    ->subject('SINOC - Solicitação de Análise de Descumprimento Contratual (SADC) – Abertura - ' . $dd);
            
        });
//fim email
        //------------------------------------------------------------------------------
        #Redirecionandopara a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Novo descumprimento contratutal cadastrado com sucesso!')
                        ->with('tipo', 'success');
    }

    public function delete($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        // #Descumprimento sendo deletada
        // #Esse metodo só irá ser disponibilizado para pessoas do RH / Logística  

        $d = Descumprimento::find($id);
        $d->delete();

        // #Redirecionando para a página principal
        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento deletado com sucesso')
                        ->with('tipo', 'danger');
    }

    public function addci(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Descumprimento
        $d = Descumprimento::find($request->input('id_descumprimento'));

        $d->ci = $request->input('ci');
        if ($request->file('nome_anexo_ci')) {

            $doc = $request->file('nome_anexo_ci');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $d->nome_anexo_ci = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'CI cadastrado com sucesso!')
                        ->with('tipo', 'success');
    }

    public function addsiclg(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Descumprimento
        $d = Descumprimento::find($request->input('id_descumprimento'));

        $d->siclg = $request->input('siclg');

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'SICLG cadastrado com sucesso!')
                        ->with('tipo', 'success');
    }

    public function addoficio(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Descumprimento
        $d = Descumprimento::find($request->input('id_descumprimento'));

        $d->oficio = $request->input('oficio');
        if ($request->file('nome_anexo_parecer')) {

            $doc = $request->file('nome_anexo_parecer');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $d->nome_anexo_parecer = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'OFÍCIO cadastrado com sucesso!')
                        ->with('tipo', 'success');
    }

    public function devolverempresa($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('DescumprimentoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $d = Descumprimento::find(Crypt::decrypt($id));

        $d->status = 7;

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento Devolvido para empresa. Novo prazo de 5 dias úteis!')
                        ->with('tipo', 'success');
    }
    
    public function devolvercaixa($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('DescumprimentoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $d = Descumprimento::find(Crypt::decrypt($id));

        $d->status = 8;

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento Devolvido para empresa. Novo prazo de 5 dias úteis!')
                        ->with('tipo', 'success');
    }
    public function devolvergerente($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('DescumprimentoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $d = Descumprimento::find(Crypt::decrypt($id));

        $d->status = 3;

       $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento Devolvido para o gerente. Novo prazo de 2 dias úteis!')
                        ->with('tipo', 'success');
    }
    public function devolvercoordenacao($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('DescumprimentoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $d = Descumprimento::find(Crypt::decrypt($id));

        $d->status = 2;

       $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento Devolvido para a coordenação. Novo prazo de 2 dias úteis!')
                        ->with('tipo', 'success');
    }
    public function devolverrh($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('DescumprimentoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $d = Descumprimento::find(Crypt::decrypt($id));

        $d->status = 6;

       $dt_now = Carbon::now();

        if ($dt_now->dayOfWeek == '1' || $dt_now->dayOfWeek == '2' || $dt_now->dayOfWeek == '3' || $dt_now->dayOfWeek == '0') {
            $dt_prazo = $dt_now->addDay(2);
        } elseif ($dt_now->dayOfWeek == '4' || $dt_now->dayOfWeek == '5') {
            $dt_prazo = $dt_now->addDay(4);
        } else {
            $dt_prazo = $dt_now->addDay(3);
        }

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $d->prazo = $dt_prazo->endOfDay();

        $d->save();

        return redirect()->action('DescumprimentoController@index')
                        ->with('status', 'Descumprimento Devolvido para a logística. Novo prazo de 2 dias úteis!')
                        ->with('tipo', 'success');
    }

    public function validardescumprimento() {

        $descumprimento = Descumprimento::where('prazo', '<', Carbon::now())->where('prazo', '>', Carbon::now()->addDay(-15))->orderBy('created_at', 'desc')->get();

        foreach ($descumprimento as $d):

            if (Carbon::parse($d->prazo) < Carbon::now()):
                $diff = Carbon::now()->diffInDays(Carbon::parse($d->prazo));
                $diff = $diff + 1;

                echo $diff;
                echo ' | ' . Carbon::now() . ' | ' . $d->prazo . ' | ' . $d->nu_descumprimento;
                echo "<br>";


//Fazer mais uma validaçao para verificar se não ja foi respondido, ou seja, se não respondeu e  diff > 2 e status X então...

                if ($diff >= 1 && $d->status == 7):

                    $d->status = 55;
                    $d->save();
                endif;
                if ($diff >= 1 && $d->status == 8):

                    $d->status = 44;
                    $d->save();
                endif;
                if ($diff >= 1 && $d->status == 1):

                    $d->status = 9999;
                    $d->save();
                endif;
                if ($diff >= 1 && $d->status == 2): //coordenacao

                    $d->status = 2999;
                    $d->save();
                endif;
                if ($diff >= 1 && $d->status == 3)://gerencia

                    $d->status = 3999;
                    $d->save();
                endif;
                if ($diff >= 1 && $d->status == 6)://gerencia

                    $d->status = 6999;
                    $d->save();
                endif;
            endif;


        endforeach;
    }

}
