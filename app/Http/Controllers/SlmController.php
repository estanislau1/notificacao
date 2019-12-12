<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Contexto as Contexto;
use App\Models\Coordenacao as Coordenacao;
use App\Models\Impacto as Impacto;
use App\Models\Motivo as Motivo;
use App\Models\Indicador as Indicador;
use Carbon\Carbon as Carbon;
use Crypt as Crypt;
use Illuminate\Http\Request;
use DB;
use App\Models\Slm;
use App\Http\Requests\SlmEmpresaRequest;
use App\Http\Requests\SlmCaixaRequest;

date_default_timezone_set('America/Sao_Paulo');

class SlmController extends Controller {

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
        $Slm = DB::table('SLM')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'SLM.id_contrato')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('SLM.deleted_at', null)
                ->select('CONTRATOS.*', 'SLM.*', 'EMPRESA.*')
                ->orderBy('SLM.id_slm', 'desc')
                ->limit(1000)
                ->get();


        //Carregando View e repassando as variáveis necessárias
        return view('slm', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm
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
        $Slm = Slm::find(Crypt::decrypt($id));

        //Carregando View e repassando as variaveis necessárias
        return view('slmVer', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm
        ]);
    }

    public function incluirslm() {
       // if (session('matricula') == null) {
        //    return view('notificacaoLogin', ['status' => 'expirado']);
        //    die();
        //}
        $data = Carbon::now();
        $dia = $data->format('d');
        $mes = $data->format('m');
        $ano = $data->format('Y');
        $arq = 'slm_' . $dia . $mes . $ano;
        $arq_existe = '/var/www/html/notificacoes/storage/slm/new/' . $arq . '.csv';
        echo $arq_existe;

        if (file_exists($arq_existe)) {

            $arquivo = fopen($arq_existe, 'r');

            while (!feof($arquivo)) {

                $linha = fgets($arquivo, 1024);

                if ($linha) {

                    $dados = explode(';', $linha);
                    $status = 1;
                    $incidente = utf8_encode($dados[0]);
                    $atrasou = utf8_encode($dados[1]);
                    $tempo = utf8_encode($dados[2]);
                    $ic = utf8_encode($dados[3]);
                    $sumario = utf8_encode($dados[4]);
                    $id_mot = 4; //nao conforme de acordo com prazo
                    $string = utf8_encode($dados[5]); //Service Target traz indicador e contrato
                    $hora_reportada = utf8_encode($dados[6]);

                    if (strlen($hora_reportada) == 20) {
                        $hora = Carbon::create(2018, 1, 1, substr($hora_reportada, 10, 2), substr($hora_reportada, 13, 2), substr($hora_reportada, 16, 2));
                    } elseif (strlen($hora_reportada) == 21) {
                        $hora = Carbon::create(2018, 1, 1, substr($hora_reportada, 11, 2), substr($hora_reportada, 14, 2), substr($hora_reportada, 17, 2));
                    } else {
                        $hora = Carbon::create(2018, 1, 1, 7, 0, 0); //se nao for nada passo pro dia
                    }

                    if ($hora->between(Carbon::create(2018, 1, 1, 6, 15, 0), Carbon::create(2018, 1, 1, 15, 15, 0))) {
                        $equipe = 1; //DIA
                    } elseif ($hora->between(Carbon::create(2018, 1, 1, 15, 16, 0), Carbon::create(2018, 1, 1, 23, 15, 0))) {
                        $equipe = 2; //NOITE
                    } else {
                        $equipe = 3; //MADRUGADA
                    }

                    if (preg_match('/ResolucaoD/', $string)) {
                        $id_indicador = 8;
                    } else {
                        $id_indicador = 11;
                    }
                    if (preg_match('/12247/', $string)) {
                        $id_contrato = 17; //hitss
                    } elseif (preg_match('/00547/', $string)) {
                        $id_contrato = 18; //ctis
                    } else {
                        $id_contrato = 19; //cpm
                    }
                    $existe = DB::table('SLM')->where('incidente', $incidente)->where('id_contrato', $id_contrato)->exists();
                    try {
                        #Criando o objeto Slm
                        if (!$existe && $atrasou == 'Atrasou') {
                            $s = new Slm;

                            $s->id_contrato = $id_contrato;
                            $s->status = $status;
                            $s->incidente = $incidente;
                            $s->tempo = $tempo;
                            $s->ic = $ic;
                            $s->sumario = $sumario;
                            $s->id_indicador = $id_indicador;
                            $s->equipe = $equipe;

                            $dt_now = Carbon::now();

                            $dt_prazo = $dt_now->addDay(7);

                            $ehferiado = DB::table('CALENDARIO')
                                    ->where('dt_feriado', '>=', $dt_now)
                                    ->where('dt_feriado', '<=', $dt_prazo)
                                    ->count();

                            if ($ehferiado >= 1):
                                $dt_prazo->addDay($ehferiado);

                            endif;

                            $s->dt_prazo = $dt_prazo->endOfDay();

				$mes_atual = Carbon::now()->month;
                            $diac = DB::table('DIA_CORTE')->select('dia')->where('id', 2)->limit(1)->get();
                            foreach ($diac as $d) {
                                $dia = $d->dia;
                            }
                            $no_days = array();
                            for ($i = $dia; $i <= 31; $i++) {
                                $no_days[] = $i;
                            }

                           if (in_array($dt_now->day, $no_days)) {

                                $dt_final = Carbon::now()->addMonth()->firstOfMonth();
                                //$dt_final = $dt_final->subMonth();

                                $s->created_at = $dt_final;
                            }

                            #Salvando formulário
                            $s->save();

                            #Pegando o ID do novo registro criado
                            $newId = $s->id_slm;

                            #Criando o número da notificação baseado no ID recém criado.
                            $dd = "S" . Carbon::parse(Carbon::now())->format('Ym') . $newId;
                            $scj = Slm::find($newId);
                            $scj->nu_slm = $dd;
                            $scj->save();
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
            fclose($arquivo);
            // $fileold = 'C:\xampp\htdocs\notifica\app\Lib\slm_cpm.csv';
            // $filenew = 'C:\xampp\htdocs\notifica\app\Lib\slm_cpm_old.csv';
            // rename($fileold, $filenew);
        } else {
            echo 'Arquivo não existe!!!';
            die;
        }
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
        $Slm = Slm::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('slmCaixa', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm
        ]);
    }

    public function incluiravaliacao(SlmCaixaRequest $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $dij = Slm::find($request->input('id_slm'));

        $dij->bit_aceito_caixa = $request->input('bit_aceito_caixa');
        $dij->ds_caixa = $request->input('ds_caixa');
        $dij->ma_caixa = $matricula;
        $dij->dt_caixa = Carbon::now();

        if ($dij->bit_aceito_caixa == 1) {
            $dij->status = 3; //SLM acatado
        } else {
            $dij->status = 4; //SLM nao acatado
        }

        $dij->save();

        return redirect()->action('SlmController@index')
                        ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function justificar($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informações do usuário que está acessando o sistema
        $matricula = session('matricula');
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        //Buscando informações especificas do ID = $id
        $Slm = Slm::find(Crypt::decrypt($id));


        //Carregando View e repassando as variaveis necessárias
        return view('slmTerceirizada', [
            'matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm
        ]);
    }

    public function incluirjustificativa(SlmEmpresaRequest $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        $matricula = session('matricula');

        $dij = Slm::find($request->input('id_slm'));

        $dij->bit_aceito_terceiro = $request->input('bit_aceito_terceiro');
        $dij->ds_terceiro = $request->input('ds_terceiro');
        $dij->ma_terceiro = $matricula;
        $dij->dt_terceiro = Carbon::now();
        $dij->id_coordenacao = $request->input('id_coordenacao');

        if ($dij->bit_aceito_terceiro == 0) {
            $dij->status = 2; //vai para caixa
        } else {
            $dij->status = 4; //SLM Não acatado
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

        $dij->dt_prazo = $dt_prazo->endOfDay();

        $dij->save();

        return redirect()->action('SlmController@index')
                        ->with('status', 'Sua justificativa foi cadastrada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function addequipe(Request $request) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

#Criando o objeto Slm
        $s = Slm::find($request->input('id_slm'));

        $s->equipe = $request->input('equipe');

        $s->save();

        return redirect()->action('SlmController@index')
                        ->with('status', 'Equipe alterada com sucesso!')
                        ->with('tipo', 'success');
    }

    public function delete($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }
        // #Slm sendo deletada
        // #Esse metodo só irá ser disponibilizado para pessoas do RH / Logística  

        $s = Slm::find($id);
        $s->delete();

        // #Redirecionando para a página principal
        return redirect()->action('SlmController@index')
                        ->with('status', 'Slm deletado com sucesso')
                        ->with('tipo', 'danger');
    }

    public function devolverempresa($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('SlmController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $s = Slm::find(Crypt::decrypt($id));

        $s->status = 1;

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $s->dt_prazo = $dt_prazo->endOfDay();

        #Salvando formulário
        $s->save();

        $s->dt_prazo = $dt_prazo->endOfDay();

        $s->save();

        return redirect()->action('SlmController@index')
                        ->with('status', 'SLM Devolvido para empresa. Novo prazo de 2 dias úteis!')
                        ->with('tipo', 'success');
    }

    public function devolvercaixa($id) {
        if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        if (session('isgestor') != 1) {
            if (session('issupervisor') != 1) {

                return redirect()->action('SlmController@index')
                                ->with('status', 'você tentou acessar uma área restrita')
                                ->with('tipo', 'danger');
            }
        }


        $matricula = session('matricula');

        $s = Slm::find(Crypt::decrypt($id));

        $s->status = 2;

        $dt_now = Carbon::now();

        $dt_prazo = $dt_now->addDay(7);

        $ehferiado = DB::table('CALENDARIO')
                ->where('dt_feriado', '>=', $dt_now)
                ->where('dt_feriado', '<=', $dt_prazo)
                ->count();

        if ($ehferiado >= 1):
            $dt_prazo->addDay($ehferiado);

        endif;

        $s->dt_prazo = $dt_prazo->endOfDay();

        #Salvando formulário
        $s->save();

        $s->dt_prazo = $dt_prazo->endOfDay();

        $s->save();

        return redirect()->action('SlmController@index')
                        ->with('status', 'SLM Devolvido para Caixa. Novo prazo de 2 dias úteis!')
                        ->with('tipo', 'success');
    }

    public function buscarmesslm(Request $request) {
        
          if (session('matricula') == null) {
            return view('notificacaoLogin', ['status' => 'expirado']);
            die();
        }

        //Pegando informa��es do usu�rio que est� acessando o sistema
        $matricula = session('matricula');

        //Itens do menu esquerda de busca
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();
        
        $mes = $request->input('mes');
        $ano = $request->input('ano');


        //Listando todos os contratos v�lidos do sistema     
        $Slm = DB::table('SLM')
                ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'SLM.id_contrato')
                ->join('EMPRESA', 'EMPRESA.id_empresa', '=', 'CONTRATOS.id_empresa')
                ->where('SLM.deleted_at', null)
                ->WhereRaw('EXTRACT(Month from "SLM".created_at) = ' . $mes)
                ->WhereRaw('EXTRACT(Year from "SLM".created_at) = ' . $ano)
                ->select('CONTRATOS.*', 'SLM.*', 'EMPRESA.*')
                ->orderBy('SLM.id_slm', 'desc')
                ->limit(1000)//1000
                ->get();


        //Carregando View e repassando as vari�veis necess�rias
        return view('slm', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Slm' => $Slm
        ]);

    }

    public function validarslm() {

        $slm = Slm::where('dt_prazo', '<', Carbon::now())->where('dt_prazo', '>', Carbon::now()->addDay(-15))->orderBy('created_at', 'desc')->get();

        foreach ($slm as $s):

            if (Carbon::parse($s->dt_prazo) < Carbon::now()):
                $diff = Carbon::now()->diffInDays(Carbon::parse($s->dt_prazo));
                $diff = $diff + 1;

                echo $diff;
                echo ' | ' . Carbon::now() . ' | ' . $s->dt_prazo . ' | ' . $s->nu_slm;
                echo "<br>";


//Fazer mais uma validaçao para verificar se não ja foi respondido, ou seja, se não respondeu e  diff > 2 e status X então...

                if ($diff >= 1 && $s->status == 1):

                    $s->status = 44;
                    $s->bit_aceito_terceiro = 1;
                    $s->ds_terceiro = 'SLM não acatado devido ao prazo limite excedido!';
                    $s->save();
                endif;
                if ($diff >= 1 && $s->status == 2):

                    $s->status = 33;
                    $s->bit_aceito_caixa = 1;
                    $s->ds_caixa = 'SLM acatado devido ao prazo limite excedido!';
                    $s->save();
                endif;
            endif;


        endforeach;
    }

}
