<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Preposto as Preposto;
use App\Models\Rh as R;
use App\Models\Acesso as Supervisor;
use App\Models\Contexto as Contexto;
use App\Models\Macrocelula as Macrocelula;
use App\Models\Celula as Celula;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Impacto as Impacto;
use App\Models\Motivo as Motivo;
use App\Models\Indicador as Indicador;
use App\Models\Notificacao as Notificacao;
use app\lib\Arquivo;
use App\Lib\Csv;
use Carbon\Carbon as Carbon;
use Crypt as Crypt;
use Illuminate\Http\Request;
use DB;
use Adldap\Laravel\Facades\Adldap;
use PDF;

class NotificacaoController extends Controller {

    public function logar() {
        session()->put('matricula', '');
        session()->put('isgestor', '');
        session()->put('issupervisor', '');
        session()->put('isrh', '');
        session()->put('ispreposto', '');
	 session()->put('empresa', '');
        return view('notificacaoLogin', ['status' => '']);
    }

    public function logout() {
        if (session('_token') !== null) {

            session()->forget('ispreposto');
            session()->forget('isrh');
            session()->forget('matricula');
            session()->forget('isgestor');
            session()->forget('issupervisor');
            session()->forget('cargo');
	     session()->forget('empresa');
            return view('notificacaoLogin', ['status' => '']);
        }
    }

    /*
      public function login(Request $request) {

      $user = $request->input('user');
      $password = $request->input('password');

      $ldap_dn = "uid=SNOTBP01,ou=Users,o=caixa";
      $ldap_password = 'Sotpb5938';
      /*
      dn: uid=SNOTBP01,ou=Users,o=caixa
      Conta: SNOTBP01
      SENHA: Sotpb5938


      $ldap_con = ldap_connect("10.192.192.26", 389); //

      ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

      if (@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {

      $filter = "(uid=" . $user . ")";
      $result = ldap_search($ldap_con, "ou=People,o=caixa", $filter) or exit("Usuário não existe no LDAP");
      $entries = ldap_get_entries($ldap_con, $result);
      ldap_unbind($ldap_con);

      foreach ($entries[0]['uid'] as $mat) {
      session()->put('matricula', strtolower($mat));

      $prep = Preposto::where('ma_preposto', strtolower($mat))->get();
      if (!is_null(@$prep[0]->ma_preposto)) {
      session()->put('ispreposto', 1);
      } else {
      session()->put('ispreposto', 0);
      }

      $rh = R::where('ma_rh', strtolower($mat))->get();
      if (!is_null(@$rh[0]->ma_rh)) {
      session()->put('isrh', 1);
      } else {
      session()->put('isrh', 0);
      }
      }
      foreach ($entries[0]['description'] as $cargo) {
      session()->put('cargo', strtolower($cargo));
      if ($cargo == 'SUPERVISOR DE TI' || $cargo == 'COORDENADOR DE TI') {
      session()->put('isgestor', 1);
      } else {
      session()->put('isgestor', 0);
      }
      }
      $data = $request->session()->all();
      var_dump($data);
      print "<pre>";
      print_r($entries);
      print "</pre>";
      return 0;
      } else {
      return view('notificacaoLogin', ['status' => 'negado']);
      }
      }
     */

    public function index2() {
        //echo 'pedroka' . session('issupervisor');
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
//Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');

//Listando as empresas
        $Empresas = Empresa::all();

//Listando os contratos    
//$Contratos = Contrato::all();
        $Contratos = Contrato::orderBy('id_contrato', 'desc')->get();
//$Coordenacoes = Coordenacao::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

//Listando todos os contratos válidos do sistema     
        $Notificacoes = DB::table('NOTIFICACAO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->where('NOTIFICACAO.deleted_at', null)
                ->where('CONTRATOS.deleted_at', null)
                ->select('CONTRATOS.*', 'NOTIFICACAO.*')
		  ->limit(250)
		  ->orderBy('NOTIFICACAO.nu_notificacao', 'desc')
                ->get();


//Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);
    }

    public function index(Request $request) {

        $user = $request->input('user');
        $password = $request->input('password');

        if (empty($user)) {
            $usuario = session('matricula');
        } else {
            $usuario = $user;
        }

        $ldap_dn = "uid=$usuario,ou=People,o=caixa";
        $ldap_password = $password;
        /*
          $ldap_dn = "uid=$usuario,ou=People,o=caixa";
          $ldap_password = $password;
         */
        /*
          dn: uid=SNOTBP01,ou=Users,o=caixa
          Conta: SNOTBP01
          SENHA: Sotpb5938
         */

        $ldap_con = ldap_connect("10.192.192.26", 389); //
        //$ldap_con = ldap_connect("intranet.openldap.corecaixa", 389); //

        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);


        if (@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {

            $filter = "(uid=" . $usuario . ")";
            $result = ldap_search($ldap_con, "ou=People,o=caixa", $filter) or exit("Usuário não existe no LDAP");
            $entries = ldap_get_entries($ldap_con, $result);
            ldap_unbind($ldap_con);

            foreach ($entries[0]['uid'] as $mat) {
                session()->put('matricula', strtolower($mat));

                $prep = Preposto::where('ma_preposto', strtolower($mat))->get();
                if (!is_null(@$prep[0]->ma_preposto)) {
                    session()->put('ispreposto', 1);
                } else {
                    session()->put('ispreposto', 0);
                }

                $rh = R::where('ma_rh', strtolower($mat))->get();
                if (!is_null(@$rh[0]->ma_rh)) {
                    session()->put('isrh', 1);
                } else {
                    session()->put('isrh', 0);
                }
                $supervisor = Supervisor::where('matricula', strtolower($mat))->get();
                if (!is_null(@$supervisor[0]->matricula)) {
                    session()->put('issupervisor', 1);
                } else {
                    session()->put('issupervisor', 0);
                }
                
            }
            if ((substr(session('matricula'), 0, 1)) == 'c' && isset($entries[0]['no-funcao'])) {
                foreach ($entries[0]['no-funcao'] as $cargo) {
                    session()->put('cargo', strtolower($cargo));
                    if ($cargo == 'SUPERVISOR DE TI' || $cargo == 'COORDENADOR DE TI' || session('matricula') == 'c140932' || session('matricula') == 'c093519' || session('matricula') == 'c081204') {
                        session()->put('isgestor', 1);
                    } else {
                        session()->put('isgestor', 0);
                    }
                }
            } elseif ((substr(session('matricula'), 0, 1)) == 'c' && isset($entries[0]['no-cargo'])) {
                foreach ($entries[0]['no-cargo'] as $cargo) {
                    session()->put('cargo', strtolower($cargo));
                    if ($cargo == 'SUPERVISOR DE TI' || $cargo == 'COORDENADOR DE TI' || session('matricula') == 'c140932' || session('matricula') == 'c093519') {
                        session()->put('isgestor', 1);
                    } else {
                        session()->put('isgestor', 0);
                    }
                }
            } elseif ((substr(session('matricula'), 0, 1)) == 'p' && isset($entries[0]['description'])) {
                foreach ($entries[0]['description'] as $cargo) {
                    session()->put('cargo', strtolower($cargo));
                    if ($cargo == 'SUPERVISOR DE TI' || $cargo == 'COORDENADOR DE TI' || session('matricula') == 'c140932' || session('matricula') == 'c093519') {
                        session()->put('isgestor', 1);
                    } else {
                        session()->put('isgestor', 0);
                    }
                }
            } else {
                foreach ($entries[0]['nu-cnpj'] as $cargo) {
                    session()->put('cargo', strtolower($cargo));
                    if ($cargo == 'SUPERVISOR DE TI' || $cargo == 'COORDENADOR DE TI' || session('matricula') == 'c140932' || session('matricula') == 'c093519') {
                        session()->put('isgestor', 1);
                    } else {
                        session()->put('isgestor', 0);
                    }
                }
            }
		foreach ($entries[0]['no-empresa'] as $emp) {
                if (strstr($emp, 'CPM') || strstr($emp, 'POLITEC')) {
                    session()->put('empresa', '19');
                } elseif (strstr($emp, 'PROJETOS') || strstr($emp, 'HITSS')) { //projetos � igual g&p
                    session()->put('empresa', '17');
                } elseif (strstr($emp, 'CTIS')) {
                    session()->put('empresa', '18');
                }
            }

            /*
              $data = $request->session()->all();
              var_dump($data);
              print "<pre>";
              print_r($entries);
              print "</pre>";
              return 0;
             * 
             */

//Pegando informações do usuário que está acessando o sistema
            $matricula = session('matricula');

//Listando as empresas
            $Empresas = Empresa::all();

//Listando os contratos    
//$Contratos = Contrato::all();
            $Contratos = Contrato::orderBy('nu_contrato', 'desc')->get();
//$Coordenacoes = Coordenacao::all();
            $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

//Listando todos os contratos válidos do sistema     
            $Notificacoes = DB::table('NOTIFICACAO')
                    ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                    ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                    ->where('NOTIFICACAO.deleted_at', null)
                    ->where('CONTRATOS.deleted_at', null)
                    ->select('CONTRATOS.*', 'NOTIFICACAO.*', 'EMPRESA.*')
                    ->get();


//Carregando View e repassando as variáveis necessárias
            return redirect()->action('NotificacaoController@index2');

            if (session('matricula') == null) {
                return view('notificacaoLogin', ['status' => 'expirado']);
                die();
            }
        } else {
            return view('notificacaoLogin', ['status' => 'negado']);
        }
    }

    public function nova() {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');

        $Contratos = DB::table('CONTRATOS')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('EMPRESA.deleted_at', null)
                ->where('CONTRATOS.deleted_at', NULL)
                ->select('CONTRATOS.*', 'EMPRESA.*')
                ->get();
//Carregando modulos
        $Empresas = Empresa::all();
//$Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
//$Coordenacoes = Coordenacao::all();
        //$Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
	 $Coordenacoes = DB::table('COORDENACOES')
                ->where('COORDENACOES.id_coordenacao', '<>',18) //ceptibr 41 e 43
                ->where('COORDENACOES.id_coordenacao', '<>',19)
                ->select('COORDENACOES.*')
                ->get();
        $Impactos = Impacto::all();
        $Motivos = Motivo::orderBy('no_motivo', 'asc')->get();
        $Indicadores = Indicador::orderBy('sg_indicador', 'asc')->get();

//Carregando View e repassando as variaveis necessárias
        return view('notificacaoNova', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores
        ]);
    }

    public function avaliar($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('NotificacaoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::all();
        $Impactos = Impacto::all();
        $Motivos = Motivo::all();
        $Indicadores = Indicador::all();

//Buscando informações especificas do ID = $id
        $Notificacao = Notificacao::find(Crypt::decrypt($id));

//Listando motivo da notificação
        $NotificacaoMotivo = DB::table('NOTIFICACAO_MOTIVO')
                ->where('NOTIFICACAO_MOTIVO.id_notificacao', Crypt::decrypt($id))
                ->select('NOTIFICACAO_MOTIVO.*')
                ->get();


//Carregando View e repassando as variaveis necessárias
        return view('notificacaoAvaliar', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'NotificacaoMotivo' => $NotificacaoMotivo
        ]);
    }

    public function justificar($id) {


        if (session('ispreposto') == 1) {
            
        } else {
            return redirect()->action('NotificacaoController@index')
                            ->with('status', 'você tentou acessar uma área restrita')
                            ->with('tipo', 'danger');
        }


//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::all();
        $Impactos = Impacto::all();
        $Motivos = Motivo::all();
        $Indicadores = Indicador::all();

//Buscando informações especificas do ID = $id
        $Notificacao = Notificacao::find(Crypt::decrypt($id));


//Listando motivo da notificação
        $NotificacaoMotivo = DB::table('NOTIFICACAO_MOTIVO')
                ->where('NOTIFICACAO_MOTIVO.id_notificacao', Crypt::decrypt($id))
                ->select('NOTIFICACAO_MOTIVO.*')
                ->get();


//Carregando View e repassando as variaveis necessárias
        return view('notificacaoJustificar', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'NotificacaoMotivo' => $NotificacaoMotivo
        ]);
    }

    public function ver($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::all();
        $Impactos = Impacto::all();
        $Motivos = Motivo::all();
        $Indicadores = Indicador::all();

//Buscando informações especificas do ID = $id
        $Notificacao = Notificacao::find(Crypt::decrypt($id));

//Listando motivo da notificação
        $NotificacaoMotivo = DB::table('NOTIFICACAO_MOTIVO')
                ->where('NOTIFICACAO_MOTIVO.id_notificacao', Crypt::decrypt($id))
                ->select('NOTIFICACAO_MOTIVO.*')
                ->get();


//Carregando View e repassando as variaveis necessárias
        return view('notificacaoVer', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'NotificacaoMotivo' => $NotificacaoMotivo
        ]);
    }

    public function editar($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        $Notificacao = Notificacao::find($id);

        if (session('matricula') != $Notificacao->ma_cadastro) {
            return redirect()->action('NotificacaoController@index')
                            ->with('status', 'Você não tem permissão para editar esta notificação!')
                            ->with('tipo', 'danger');
        }

//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        //$Contratos = Contrato::all();
        $Contratos = DB::table('CONTRATOS')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('EMPRESA.deleted_at', null)
                ->where('CONTRATOS.deleted_at', NULL)
                ->select('CONTRATOS.*', 'EMPRESA.*')
                ->get();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Impactos = Impacto::all();
        $Motivos = Motivo::orderBy('no_motivo', 'asc')->get();
        $Indicadores = Indicador::orderBy('sg_indicador', 'asc')->get();

//Buscando informações especificas do ID = $id
//Listando motivo da notificação
        $NotificacaoMotivo = DB::table('NOTIFICACAO_MOTIVO')
                ->where('NOTIFICACAO_MOTIVO.id_notificacao', $id)
                ->select('NOTIFICACAO_MOTIVO.*')
                ->get();


//Carregando View e repassando as variaveis necessárias
        return view('notificacaoEditar', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'NotificacaoMotivo' => $NotificacaoMotivo
        ]);
    }

    public function autorizar($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
         if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('NotificacaoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


//Pegando informações do usuário que está acessando o sistema 
        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::all();
        $Impactos = Impacto::all();
        $Motivos = Motivo::all();
        $Indicadores = Indicador::all();

//Buscando informações especificas do ID = $id
        $Notificacao = Notificacao::find(Crypt::decrypt($id));

//Listando motivo da notificação
        $NotificacaoMotivo = DB::table('NOTIFICACAO_MOTIVO')
                ->where('NOTIFICACAO_MOTIVO.id_notificacao', Crypt::decrypt($id))
                ->select('NOTIFICACAO_MOTIVO.*')
                ->get();


//Carregando View e repassando as variaveis necessárias
        return view('notificacaoAutorizar', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'NotificacaoMotivo' => $NotificacaoMotivo
        ]);
    }

    public function incluirautorizacao(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->bit_aceito = $request->input('bit_aceito');
        $nij->ds_naoautorizado = $request->input('ds_naoautorizado');
        $nij->ma_autorizador = $matricula;
        $nij->dt_autorizacao = Carbon::now();

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

        $nij->dt_fim_justificativa = $dt_prazo->endOfDay();

        $mes_atual = Carbon::now()->month;
        $diac = DB::table('DIA_CORTE')->select('dia')->where('id', 1)->limit(1)->get();
        foreach ($diac as $d) {
            $dia = $d->dia;
        }
        $no_days = array();
        for ($i = $dia; $i <= 31; $i++) {
            $no_days[] = $i;
        }

        $dt_criacao = $nij->created_at;

        if ($dt_now->month > date("m", strtotime($dt_criacao))) { //se o mes atual for maior que o mes de criacao
            $dt_final = $dt_now->firstOfMonth();
            $nij->created_at = $dt_final;
        } else {
            if (in_array($dt_now->day, $no_days)) {

                $dt_final = Carbon::now()->addMonth()->firstOfMonth();
                //$dt_final = $dt_final->subMonth();

                $nij->created_at = $dt_final;
            }
        }

        $nij->save();

// INICIO EMAIL
        if ($nij->bit_aceito != 9) {
            $notificadora = DB::table('COORDENACOES')->where('id_coordenacao', $nij->id_notificadora)->value('no_coordenacao');
            $eqnotificadora = substr($notificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $nij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');
            date_default_timezone_set('America/Sao_Paulo');

            $data = Carbon::now()->format('d/m/Y H:i');
            $nd = $nij->nu_notificacao;

            $empresa_notificada_email = $empresa_notificada_email . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $empresa_notificada_email);

            Mail::send('Emails.justificativa', ['data' => $data, 'notificadora' => $nome_empresa_notificada, 'numnot' => $nd], function($message) use($nd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('Notificação Aberta - SINOC - ' . $nd);
            });
//fim email
        } else {
            $notificadora = DB::table('COORDENACOES')->where('id_coordenacao', $nij->id_notificadora)->value('no_coordenacao');
            $eqnotificadora = substr($notificadora, 0, 9);
            $eqnotificadoramin = strtolower($eqnotificadora);

            $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $nij->id_contrato)->value('id_empresa');
            $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
            $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');
            date_default_timezone_set('America/Sao_Paulo');

            $data = Carbon::now()->format('d/m/Y H:i');
            $nd = $nij->nu_notificacao;
            $ma_cadastro = $nij->ma_cadastro;

            $empresa_notificadora_email = $ma_cadastro . '@mail.caixa' . ',' . $eqnotificadoramin . '@mail.caixa';

            $emails = explode(',', $empresa_notificadora_email);

            Mail::send('Emails.autorizacaoneg', ['data' => $data, 'notificadora' => $eqnotificadora, 'numnot' => $nd], function($message) use($nd, $emails) {
                $message->to($emails, 'CEPTIBR012')->subject('Notificação não Autorizada - SINOC - ' . $nd);
            });
        }
//Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluirjustificativa(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->ds_justificativa = $request->input('ds_justificativa');
        $nij->ma_justificativa = $matricula;
        $nij->dt_justificativa = Carbon::now();
        $nij->bit_aceito = 3;

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

        $nij->dt_fim_justificativa = $dt_prazo->endOfDay();



        if ($request->file('justificativa_anexo')) {

            $doc = $request->file('justificativa_anexo');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $nij->justificativa_anexo = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

        $nij->save();

// INICIO EMAIL
        $notificadora = DB::table('COORDENACOES')->where('id_coordenacao', $nij->id_notificadora)->value('no_coordenacao');
        $eqnotificadora = substr($notificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);
        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');
        $nd = $nij->nu_notificacao;

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $nij->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        $empresa_notificada_email = $empresa_notificada_email . ',' . $eqnotificadoramin . '@mail.caixa';
        $emails = $eqnotificadoramin . '@mail.caixa';

        Mail::send('Emails.avaliacao', ['data' => $data, 'notificadora' => $eqnotificadora, 'numnot' => $nd], function($message) use($nd, $emails) {
            $message->to($emails, 'CEPTIBR012')->subject('Notificação Justificada - SINOC - ' . $nd);
        });
//fim email
//Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Sua justificativa foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function validarnotificacao() {
        $notificacao = Notificacao::where('dt_fim_justificativa', '<', Carbon::now())->where('dt_fim_justificativa', '>', Carbon::now()->addDay(-5))->orderBy('created_at', 'desc')->get();

        foreach ($notificacao as $n):

            if (Carbon::parse($n->dt_fim_justificativa) < Carbon::now()):
                $diff = Carbon::now()->diffInDays(Carbon::parse($n->dt_fim_justificativa));
                $diff = $diff + 1;

                echo $diff;
                echo ' | ' . Carbon::now() . ' | ' . $n->dt_fim_justificativa . ' | ' . $n->nu_notificacao;
                echo "<br>";


//Fazer mais uma validaçao para verificar se não ja foi respondido, ou seja, se não respondeu e  diff > 2 e bit_aceito X então...

                if ($diff >= 1 && $n->bit_aceito == 1):

                    $n->bit_aceito = 99;
                    $n->save();
                endif;
                if ($diff >= 1 && $n->bit_aceito == 3):

                    $n->bit_aceito = 44;
                    $n->save();
                endif;
                if ($diff >= 1 && $n->bit_aceito == 2):

                    $n->bit_aceito = 55;
                    $n->save();
                endif;
            endif;


        endforeach;
    }

    //END validarnotificacao()

    public function incluiravaliacao(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->bit_aceito = $request->input('bit_aceito');
        $nij->ds_naoacatado = $request->input('ds_naoacatado');
        $nij->ds_acatado = $request->input('ds_acatado');
        $nij->ma_avaliador = $matricula;
        $nij->dt_naoacatado = Carbon::now();
        $nij->dt_acatado = Carbon::now();

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

        $nij->dt_fim_justificativa = $dt_prazo->endOfDay();



        $nij->save();

//Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function devolverpreposto($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

         if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('NotificacaoController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $ncj = Notificacao::find(Crypt::decrypt($id));

        $ncj->dt_naoacatado = NULL;
        $ncj->ds_naoacatado = NULL;
        $ncj->ma_avaliador = NULL;
        $ncj->ds_justificativa = NULL;
        $ncj->ma_justificativa = NULL;
        $ncj->dt_justificativa = NULL;

        $ncj->bit_aceito = 2;
        $ncj->reaberto = 2;

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

        $ncj->dt_fim_justificativa = $dt_prazo->endOfDay();


        $ncj->save();

#Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'A notificação foi devolvida! O preposto já pode incluir nova justificativa.')
                        ->with('tipo', 'success');
    }

    public function corrigir($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $ncj = Notificacao::find(Crypt::decrypt($id));

        $ncj->dt_naoacatado = NULL;
        $ncj->ds_naoacatado = NULL;
        $ncj->ma_avaliador = NULL;
        $ncj->bit_aceito = 3;
        $ncj->reaberto = 1;

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

        $ncj->dt_fim_justificativa = $dt_prazo->endOfDay();


        $ncj->save();

#Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'O descumprimento de nível de serviço já pode ser corrigido!')
                        ->with('tipo', 'success');
    }

    public function reabrir($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $ncj = Notificacao::find(Crypt::decrypt($id));

        $ncj->bit_aceito = 1;
        $ncj->reaberto = 1;

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

        $ncj->dt_fim_justificativa = $dt_prazo->endOfDay();


        $ncj->save();

#Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'O descumprimento de nível de serviço foi reaberto!')
                        ->with('tipo', 'success');
    }
	
        public function buscarminhasnotificacoes() {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        //Listando os contratos    
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Listando todos os contratos v�lidos do sistema     
        //$Notificacoes = DB::select(DB::raw("select * from NOTIFICACAO join CONTRATOS"))

        $Notificacoes = DB::table('NOTIFICA.NOTIFICACAO')
                ->join('NOTIFICA.CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->Where('NOTIFICACAO.deleted_at', null)
                ->Where('CONTRATOS.deleted_at', null)
                ->Where('NOTIFICACAO.ma_cadastro', '=', $matricula)
                ->select('CONTRATOS.*', 'NOTIFICACAO.*')
                ->get();

//Carregando View e repassando as vari�veis necess�rias
        return view('notificacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);
    }

    public function buscarmes(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $mes = $request->input('mes');
        $ano = $request->input('ano');

//Listando os contratos    
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

//Listando todos os contratos válidos do sistema     
//$Notificacoes = DB::select(DB::raw("select * from NOTIFICACAO join CONTRATOS"))

        $Notificacoes = DB::table('NOTIFICA.NOTIFICACAO')
                ->join('NOTIFICA.CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->Where('NOTIFICACAO.deleted_at', null)
                ->Where('CONTRATOS.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = ' . $mes)
                ->WhereRaw('EXTRACT(Year from "NOTIFICACAO".created_at) = ' . $ano)
                ->select('CONTRATOS.*', 'NOTIFICACAO.*')
                ->get();

//Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);
    }

    public function buscar(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $n_notificacao = $request->input('n_notificacao');
        $palavra_chave = $request->input('palavra_chave');
        $id_notificadora = $request->input('id_notificadora');
        $id_contrato = $request->input('id_contrato');
        $datainicio = $request->input('datainicio');
        $datafinal = $request->input('datafinal');
	  $ma_cadastro = $request->input('ma_cadastro');

//Listando os contratos    
        $Contratos = Contrato::all();
        /*
          $Contratos = DB::table('CONTRATOS')
          ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATO.id_empresa')
          ->Where('CONTRATOS.deleted_at', null)
          ->orderBy('id_contrato', 'desc')
          ->select('CONTRATOS.*', 'EMPRESA.*')
          ->get();
         * */

        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
//Listando todos os contratos v�lidos do sistema     
        $Notificacoes = DB::table('NOTIFICACAO')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
                ->Where('NOTIFICACAO.deleted_at', null)
                ->Where('CONTRATOS.deleted_at', null)
                ->when($id_notificadora, function ($query) use ($id_notificadora) {
                    return $query->Where('NOTIFICACAO.id_notificadora', $id_notificadora);
                }, function ($query) {
//return $query->orderBy('name');
                })
                ->when($palavra_chave, function ($query) use ($palavra_chave) {
                    return $query->Where('NOTIFICACAO.nu_notificacao', 'like', '%' . $palavra_chave . '%')->orWhere('NOTIFICACAO.ds_notificacao', 'like', '%' . $palavra_chave . '%');
                }, function ($query) {
                    
                })
                ->when($id_contrato, function ($query) use ($id_contrato) {
                    return $query->Where('NOTIFICACAO.id_contrato', $id_contrato);
                }, function ($query) {
//return $query->orderBy('name');
                })
                ->when($datainicio, function ($query) use ($datainicio) {
                    return $query->Where('NOTIFICACAO.created_at', '>', $datainicio);
                }, function ($query) {
//return $query->orderBy('name');
                })
                ->when($datafinal, function ($query) use ($datafinal) {
                    return $query->Where('NOTIFICACAO.created_at', '<', $datafinal);
                }, function ($query) {
//return $query->orderBy('name');
                })
                ->when($ma_cadastro, function ($query) use ($ma_cadastro) {
                    return $query->Where('NOTIFICACAO.ma_cadastro', '=', $ma_cadastro);
                }, function ($query) {
//return $query->orderBy('name');
                })
                ->select('CONTRATOS.*', 'NOTIFICACAO.*')
                ->get();
//Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);
    }

    public function incluir(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Notificacao
        $n = new Notificacao;

        $n->id_contrato = $request->input('id_contrato');
        $n->ds_ocorrencia = $request->input('ds_ocorrencia');
        $n->id_notificadora = $request->input('id_notificadora');
        $n->id_impactada = $request->input('id_impactada');
        $n->ds_ticket = $request->input('ds_ticket');
        $n->ds_notificacao = $request->input('ds_notificacao');
        $n->nu_horas = $request->input('nu_horas');
        $n->id_impactada = $request->input('id_impactada');
        $n->ds_ticket = $request->input('ds_ticket');
        $n->ma_cadastro = session('matricula');
        $n->id_indicador = $request->input('id_indicador');
        $n->bit_aceito = 1;

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

        $n->dt_fim_justificativa = $dt_prazo->endOfDay();


//--------------------------------------------------------------------------
//$n->dt_fim_justificativa = $dt_prazo->endOfDay()->format('d/m/Y H:i');
//$n->dt_fim_justificativa = Carbon::now()->addDay(2)->endOfDay()->format('d/m/Y H:i');

        if ($request->file('nome_anexo')) {

            $doc = $request->file('nome_anexo');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $n->nome_anexo = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

#Salvando formulário
        $n->save();

#Pegando o ID do novo registro criado
        $newId = $n->id_notificacao;

#Criando o número da notificação baseado no ID recém criado.
        $nd = "N" . Carbon::parse(Carbon::now())->format('Ym') . $newId;
        $ncj = Notificacao::find($newId);
        $ncj->nu_notificacao = $nd;
        $ncj->save();
//------------------------------------------------------------------------------
#Fazendo a inclusão na tabela :Motivo
        $id_motivo = [];
        $id_motivo = $request->input('id_motivo');
        foreach ($id_motivo as $mot) {
            $datasetMot[] = [
                'id_notificacao' => $newId,
                'id_motivo' => $mot,
            ];
        }
        DB::table('NOTIFICACAO_MOTIVO')->insert($datasetMot);

// INICIO EMAIL
        $notificadora = DB::table('COORDENACOES')->where('id_coordenacao', $n->id_notificadora)->value('no_coordenacao');
        $eqnotificadora = substr($notificadora, 0, 9);
        $eqnotificadoramin = strtolower($eqnotificadora);

        $id_empresa_notificada = DB::table('CONTRATOS')->where('id_contrato', $n->id_contrato)->value('id_empresa');
        $empresa_notificada_email = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('email');
        $nome_empresa_notificada = DB::table('EMPRESA')->where('id_empresa', $id_empresa_notificada)->value('no_empresa');

        date_default_timezone_set('America/Sao_Paulo');
        $data = Carbon::now()->format('d/m/Y H:i');

        $empresa_notificada_email = $empresa_notificada_email . ',' . $eqnotificadoramin . '@mail.caixa';

        $emails = $eqnotificadoramin . '@mail.caixa';

        Mail::send('Emails.abertura', ['data' => $data, 'notificadora' => $eqnotificadora, 'numnot' => $nd], function($message) use($nd, $emails) {
            $message->to($emails, 'CEPTIBR012')->subject('Autorização Abertura Notificação - SINOC - ' . $nd);
        });
//fim email
#Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Novo descumprimento de nível de serviço foi incluida com sucesso!')
                        ->with('tipo', 'success');
    }

    public function incluiredicao(Request $request) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Notificacao
        $n = Notificacao::find($request->input('idnotificacao'));

        $n->id_notificacao = $request->input('idnotificacao');
        $n->id_contrato = $request->input('id_contrato');
        $n->ds_ocorrencia = $request->input('ds_ocorrencia');
        $n->id_notificadora = $request->input('id_notificadora');
        $n->id_impactada = $request->input('id_impactada');
        $n->ds_ticket = $request->input('ds_ticket');
        $n->ds_notificacao = $request->input('ds_notificacao');
        $n->nu_horas = $request->input('nu_horas');
        $n->id_impactada = $request->input('id_impactada');
        $n->ds_ticket = $request->input('ds_ticket');
        $n->ma_cadastro = session('matricula');
        $n->id_indicador = $request->input('id_indicador');


        if ($request->file('nome_anexo')) {

            $doc = $request->file('nome_anexo');
            $prefix = Carbon::parse(Carbon::now())->format('Ymdhi');
            $destinationPath = storage_path() . '/uploads';

            if (!$doc->move($destinationPath, $prefix . '_' . $doc->getClientOriginalName())) {
                return $this->errors(['message' => 'Erro ao salvar o arquivo anexo.', 'code' => 400]);
            } else {
                $n->nome_anexo = $prefix . '_' . $doc->getClientOriginalName();
            }
        }

#Salvando formulário
        $n->save();

#Pegando o ID do novo registro criado
        $newId = $n->id_notificacao;

//------------------------------------------------------------------------------
#Fazendo a inclusão na tabela :Motivo
        $id_motivo = [];
        $id_motivo = $request->input('id_motivo');
        foreach ($id_motivo as $mot) {
            $datasetMot[] = [
                'id_notificacao' => $newId,
                'id_motivo' => $mot,
            ];
        }
        DB::table('NOTIFICACAO_MOTIVO')->where('id_notificacao', $newId)->update(['id_motivo' => $id_motivo[0]]);

#Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Notificação editada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function delete($id) {

        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

// #Notificacao sendo deletada
// #Esse metodo só irá ser disponibilizado para pessoas do RH / Logística  

        $n = Notificacao::find($id);
        $n->delete();

// #Redirecionando para a página principal
        return redirect()->action('NotificacaoController@index')
                        ->with('status', 'Notificação deletada com sucesso')
                        ->with('tipo', 'success');
    }

   
    public function gerarpdf() {

        $dados = (string) session('relatorio');
        $nomedoc = (string) session('nomedoc') . '.pdf';
        //echo $dados;
        $pdf = PDF::loadHtml($dados);

        return $pdf->stream($nomedoc);
    }

     public function gerarpdf2() {

        //dd(session('relatorio2'));
       $dados = (string) session('relatorios');
        //$nomedoc = (string) session('nomedoc') . '.pdf';
        $nomedoc = 'Relatorios.pdf';
        //echo $dados;
        $pdf = PDF::loadHtml($dados);

        return $pdf->stream($nomedoc);

        
    }

public function definirdatacorte(Request $request) {

        $dia_not = $request->input('dianot');
        DB::table('DIA_CORTE')->where('id', 1)->update(['dia' => $dia_not]);
        
        $dia_slm = $request->input('diaslm');
        DB::table('DIA_CORTE')->where('id', 2)->update(['dia' => $dia_slm]);
        
        $dia_desc = $request->input('diadesc');
        DB::table('DIA_CORTE')->where('id', 3)->update(['dia' => $dia_desc]);

        return redirect()->action('NotificacaoController@diacorte')
                        ->with('status', 'Seu novo dia de corte foi cadastrado com sucesso!')
                        ->with('tipo', 'success');
    }

    public function diacorte() {

        $diacortenot = DB::table('DIA_CORTE')->select('dia')->where('id',1)->limit(1)->get();
        foreach ($diacortenot as $d) {
            $dianot = $d->dia;
        }
        $diacorteslm = DB::table('DIA_CORTE')->select('dia')->where('id',2)->limit(1)->get();
        foreach ($diacorteslm as $d) {
            $diaslm = $d->dia;
        }
        $diacortedesc = DB::table('DIA_CORTE')->select('dia')->where('id',3)->limit(1)->get();
        foreach ($diacortedesc as $d) {
            $diadesc = $d->dia;
        }

        $matricula = session('matricula');
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        $Coordenacoes = Coordenacao::all();
        $Impactos = Impacto::all();
        $Motivos = Motivo::all();
        $Indicadores = Indicador::all();

//Buscando informa��es especificas do ID = $id
        $Notificacao = Notificacao::all();



//Carregando View e repassando as variaveis necess�rias
        return view('datacorte', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Contextos' => $Contextos,
            'Macrocelulas' => $Macrocelulas,
            'Celulas' => $Celulas,
            'Coordenacoes' => $Coordenacoes,
            'Impactos' => $Impactos,
            'Motivos' => $Motivos,
            'Indicadores' => $Indicadores,
            'Empresas' => $Empresas,
            'Notificacao' => $Notificacao,
            'dianot' => $dianot,
            'diaslm' => $diaslm,
            'diadesc' => $diadesc
        ]);
    }


       public function testarfuncoes() {

        // Abre o Arquvio no Modo r (para leitura)
        $arquivo = fopen('/var/www/html/notificacoes/app/lib/gestoresuni.txt', 'r');

// L� o conte�do do arquivo
        while (!feof($arquivo)) {

// Pega os dados da linha
            $linha = fgets($arquivo, 1024);

// Divide as Informa��es das celular para poder salvar
            $dados = explode(';', $linha);
            $dados2[] = explode(';', $linha);

            //var_dump($dados[1]);
// Verifica se o Dados N�o � o cabe�alho ou n�o esta em branco

            $ma = $dados[0];

            $nome = $dados[1];
            try {
                $gestor = Gestor::where('ma_gestor', $ma)->first();
                if ($gestor <> NULL) {
                    //echo $gestor . '<br>';
                    $gestor->no_gestor = utf8_encode($nome);
                    // echo $gestor . '<br>';
                    $gestor->save();
                }
            } catch (\Exception $e) {
                // do task when error
                echo $e->getMessage();   // insert query
            }
        }
        fclose($arquivo);


        /* $dtnow = Carbon::now();
          $dtfim = Carbon::now()->addMinute(15);
          echo $dtnow;
          echo '<br>' . $dtfim . '<br>';
          $diff = $dtnow->diffInMinutes($dtfim);
          echo $diff . '<br>';

          if ($diff <= 10) {
          echo 'teste <input type="text" disabled/> <br>';
          } else {
          echo 'teste <input type="text"/> <br>';
          } */

        /*
          $delimitador = ',';
          $cerca = '"';

          // Abrir arquivo para leitura
          $f = fopen('C:\xampp\htdocs\notifica\app\Lib\movimentos_financeiros.csv', 'r');
          if ($f) {

          // Ler cabecalho do arquivo
          $cabecalho = fgetcsv($f, 0, $delimitador, $cerca);

          // Enquanto nao terminar o arquivo
          while (!feof($f)) {

          // Ler uma linha do arquivo
          $linha = fgetcsv($f, 0, $delimitador, $cerca);
          if (!$linha) {
          continue;
          }

          // Montar registro com valores indexados pelo cabecalho
          $registro[] = array_combine($cabecalho, $linha);
          $registro2[] = $linha;
          }
          fclose($f);
          }
          echo count($registro);
          foreach ($registro as $reg):

          endforeach;
          /*


          /*
         * $dt_now = Carbon::now();
          echo 'dt now: '.$dt_now. '<br>';

          $dt_prazo =  $dt_now->addDay(7);

          echo 'dt prazo inicicial: '.$dt_prazo. '<br>';

          $dt_now = date('Y-m-d', strtotime($dt_now));
          $dt_prazo1 = date('Y-m-d', strtotime($dt_prazo));

          $ehferiado = DB::table('CALENDARIO')
          ->whereDate('dt_feriado', '>=', $dt_now)
          ->whereDate('dt_feriado', '<=', $dt_prazo1)
          ->count();

          echo 'eh feriado: ' .$ehferiado . '<br>';

          if ($ehferiado >= 1):
          $dt_prazo->addDay($ehferiado);
          endif;


          echo 'prazo final: ' . $dt_prazo;
         * -------------------------------------------------------------------------------
          $dt_now = Carbon::now()->addDay(-1);
          $dt_prazo = $dt_now->addDay(2);

          if ($dt_prazo->dayOfWeek == '6'):
          $dt_prazo->addDay(2);

          elseif ($dt_prazo->dayOfWeek == '0'):
          $dt_prazo->addDay(2);

          endif;
          $ehferiado = DB::table('CALENDARIO')
          ->where('dt_feriado', '>=', $dt_now)
          ->where('dt_feriado', '<=', $dt_prazo)
          ->count();

          if ($ehferiado >= 1):
          $dt_prazo->addDay(1);

          endif;
          echo '<br>';
          echo $dt_prazo;
         * */
    }
}
