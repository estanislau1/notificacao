<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa as Empresa;
use App\Models\Contrato as Contrato;
use App\Models\Preposto as Preposto;
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


class NotificacaoController extends Controller
{
    public function index()
    {

        //Pegando informações do usuário que está acessando o sistema
        $matricula = getenv('USERNAME');

        //Listando as empresas
        $Empresas = Empresa::all();

        //Listando os contratos    
        //$Contratos = Contrato::all();
        $Contratos = Contrato::orderBy('nu_contrato', 'asc')->get();
        //$Coordenacoes = Coordenacao::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();

        //Listando todos os contratos válidos do sistema     
        $Notificacoes = DB::table('NOTIFICACAO')
            ->join('CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
            ->where('NOTIFICACAO.deleted_at', null)
            ->where('CONTRATOS.deleted_at', null)
            ->select('CONTRATOS.*', 'NOTIFICACAO.*')
            ->get();


        //Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Empresas' => $Empresas,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);

    }

    public function nova()
    {

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = getenv('USERNAME');

        //Carregando modulos
        $Empresas = Empresa::all();
        $Contratos = Contrato::all();
        $Contextos = Contexto::all();
        $Macrocelulas = Macrocelula::all();
        $Celulas = Celula::all();
        //$Coordenacoes = Coordenacao::all();
        $Coordenacoes = Coordenacao::orderBy('nu_coordenacao', 'asc')->get();
        $Impactos = Impacto::all();
        $Motivos = Motivo::orderBy('no_motivo', 'asc')->get();
        $Indicadores = Indicador::all();

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


    public function avaliar($id)
    {
        if (session('isrh') == 1 OR session('isgestor') == 1) {

        } else {
            return redirect()->action('NotificacaoController@index')
                ->with('status', 'você tentou acessar uma área restrita')
                ->with('tipo', 'danger');
        }

        //Pegando informações do usuário que está acessando o sistema 
        $matricula = getenv('USERNAME');
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


    public function justificar($id)
    {


        if (session('isrh') == 1 OR session('ispreposto') == 1) {

        } else {
            return redirect()->action('NotificacaoController@index')
                ->with('status', 'você tentou acessar uma área restrita')
                ->with('tipo', 'danger');
        }


        //Pegando informações do usuário que está acessando o sistema 
        $matricula = getenv('USERNAME');
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


    public function ver($id)
    {


        //Pegando informações do usuário que está acessando o sistema 
        $matricula = getenv('USERNAME');
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


    public function autorizar($id)
    {


        //Pegando informações do usuário que está acessando o sistema 
        $matricula = getenv('USERNAME');
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


    public function incluirautorizacao(Request $request)
    {

        $matricula = getenv('USERNAME');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->bit_aceito = $request->input('bit_aceito');
        $nij->ds_naoautorizado = $request->input('ds_naoautorizado');
        $nij->ma_autorizador = $matricula;
        $nij->dt_autorizacao = Carbon::now();
        
        $dt_prazo_old = Carbon::createFromFormat('Y-m-d H:i:s',$nij->dt_fim_justificativa);

        $dt_prazo = $dt_prazo_old->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_prazo_old)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

            endif;

        $nij->dt_fim_justificativa = $dt_prazo->endOfDay();


        $nij->save();

        //Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
            ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
            ->with('tipo', 'success');


    }


    public function incluirjustificativa(Request $request)
    {

        $matricula = getenv('USERNAME');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->ds_justificativa = $request->input('ds_justificativa');
        $nij->ma_justificativa = $matricula;
        $nij->dt_justificativa = Carbon::now();
        $nij->bit_aceito = 3;
        
        $dt_prazo_old = Carbon::createFromFormat('Y-m-d H:i:s',$nij->dt_fim_justificativa);

        $dt_prazo = $dt_prazo_old->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_prazo_old)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

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

        //Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                ->with('status', 'Sua justificativa foi cadastrada com sucesso!')
                ->with('tipo', 'success');


    }

    public function validarnotificacao()
    {
        $notificacao = Notificacao::orderBy('created_at', 'desc')->get();

        foreach ($notificacao as $n):

            if(Carbon::parse($n->dt_fim_justificativa) < Carbon::now()):
            $diff = Carbon::now()->diffInDays(Carbon::parse($n->dt_fim_justificativa));
            echo $diff;
            echo "<br>";


                //Fazer mais uma validaçao para verificar se não ja foi respondido, ou seja, se não respondeu e  diff > 2 e bit_aceito X então...

                if ($diff > 2 && $n->bit_aceito == 1):

                    $n->bit_aceito = 99;
                    $n->save();
                endif;
                 if ($diff > 2 && $n->bit_aceito == 3):

                    $n->bit_aceito = 44;
                    $n->save();
                endif;
                if ($diff > 2 && $n->bit_aceito == 2):

                    $n->bit_aceito = 55;
                    $n->save();
                endif;
            endif;


        endforeach;

    }


    public function incluiravaliacao(Request $request)
    {

        $matricula = getenv('USERNAME');


        $nij = Notificacao::find($request->input('id_notificacao'));

        $nij->bit_aceito = $request->input('bit_aceito');
        $nij->ds_naoacatado = $request->input('ds_naoacatado');
        $nij->ma_avaliador = $matricula;
        $nij->dt_naoacatado = Carbon::now();
        
        $dt_prazo_old = Carbon::createFromFormat('Y-m-d H:i:s',$nij->dt_fim_justificativa);

        $dt_prazo = $dt_prazo_old->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_prazo_old)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

            endif;

        $nij->dt_fim_justificativa = $dt_prazo->endOfDay();



        $nij->save();

        //Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
            ->with('status', 'Sua avaliação foi cadastrada com sucesso!')
            ->with('tipo', 'success');


    }
    public function devolverpreposto($id){
        $matricula = getenv('USERNAME');

        $ncj = Notificacao::find(Crypt::decrypt($id));

        $ncj->dt_naoacatado = NULL;
        $ncj->ds_naoacatado = NULL;
        $ncj->ma_avaliador = NULL;
        $ncj->ds_justificativa = NULL;
        $ncj->ma_justificativa = NULL;
        $ncj->dt_justificativa = NULL;
        
        $ncj->bit_aceito = 2;
        
        $dt_now = Carbon::now();

        $dt_prazo = Carbon::now()->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_now)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

            endif;

        $ncj->dt_fim_justificativa = $dt_prazo->endOfDay();


        $ncj->save();

        #Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
            ->with('status', 'A notificação foi devolvida! O preposto já pode incluir nova justificativa.')
            ->with('tipo', 'success');
        
    }

    public function corrigir($id)
    {

        $matricula = getenv('USERNAME');

        $ncj = Notificacao::find(Crypt::decrypt($id));

        $ncj->dt_naoacatado = NULL;
        $ncj->ds_naoacatado = NULL;
        $ncj->ma_avaliador = NULL;
        $ncj->bit_aceito = 3;
        
        $dt_now = Carbon::now();

        $dt_prazo = Carbon::now()->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_now)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

            endif;

        $ncj->dt_fim_justificativa = $dt_prazo->endOfDay();


        $ncj->save();

        #Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
            ->with('status', 'O descumprimento de nível de serviço já pode ser corrigido!')
            ->with('tipo', 'success');

    }

    public function buscarmes(Request $request){

        $matricula = getenv('USERNAME');

        $mes = $request->input('mes');

        //Listando os contratos    
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Listando todos os contratos válidos do sistema     
        //$Notificacoes = DB::select(DB::raw("select * from NOTIFICACAO join CONTRATOS"))

        $Notificacoes = DB::table('NOTIFICA.NOTIFICACAO')
            ->join('NOTIFICA.CONTRATOS', 'CONTRATOS.id_contrato', '=', 'NOTIFICACAO.id_contrato')
            ->Where('NOTIFICACAO.deleted_at', null)
            ->Where('CONTRATOS.deleted_at', null)
            ->WhereRaw('EXTRACT(Month from "NOTIFICACAO".created_at) = '.$mes)
            ->select('CONTRATOS.*', 'NOTIFICACAO.*')
            ->get();

        //Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);
    }


    public function buscar(Request $request)
    {

        $matricula = getenv('USERNAME');

        $n_notificacao = $request->input('n_notificacao');
        $palavra_chave = $request->input('palavra_chave');
        $id_notificadora = $request->input('id_notificadora');
        $id_contrato = $request->input('id_contrato');
        $datainicio = $request->input('datainicio');
        $datafinal = $request->input('datafinal');

        //Listando os contratos    
        $Contratos = Contrato::all();
        $Coordenacoes = Coordenacao::all();

        //Listando todos os contratos válidos do sistema     
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
            ->select('CONTRATOS.*', 'NOTIFICACAO.*')
            ->get();

        //Carregando View e repassando as variáveis necessárias
        return view('notificacao', ['matricula' => $matricula,
            'Contratos' => $Contratos,
            'Coordenacoes' => $Coordenacoes,
            'Notificacoes' => $Notificacoes
        ]);

    }


    public function incluir(Request $request)
    {

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
        $n->ma_cadastro = getenv('USERNAME');
        $n->id_indicador = $request->input('id_indicador');
        $n->bit_aceito = 1;

        $dt_now = Carbon::now();

        $dt_prazo = Carbon::now()->addDay(2);
        $ehferiado = DB::table('CALENDARIO')
        ->where('dt_feriado','>=',$dt_now)
        ->where('dt_feriado','<=',$dt_prazo)
        ->count();

        if($ehferiado >= 1):
                $dt_prazo->addDay(1);
            
        endif;
                
        if($dt_prazo->dayOfWeek == '6'):
            $dt_prazo->addDay(2);

        elseif($dt_prazo->dayOfWeek == '0'):
            $dt_prazo->addDay(2);

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

        #Redirecionandopara a página principal
        return redirect()->action('NotificacaoController@index')
                ->with('status', 'Novo descumprimento de nível de serviço foi incluida com sucesso!')
                ->with('tipo', 'success');
    }


    public function delete($id)
    {
        // #Notificacao sendo deletada
        // #Esse metodo só irá ser disponibilizado para pessoas do RH / Logística  

        $n = Notificacao::find($id);
        $n->delete();

        // #Redirecionando para a página principal
        return redirect()->action('NotificacaoController@index')
                ->with('status', 'Notificação deletada com sucesso')
                ->with('tipo', 'success');
    }

     public function testarfuncoes(){
        $dt_now = Carbon::now()->addDay(4);
        $no_days = array(25,26,27,28,29,30,31);
        
        if( in_array($dt_now->day, $no_days)):

           echo $dt_now->addMonth()->firstOfMonth()->next(Carbon::MONDAY)->format('d/m/Y H:i');
           echo $dt_prazo = $dt_now->addDay(2)->format('d/m/Y H:i');

            endif;

    }



}
