<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Models\Preposto as Prep;
use App\Models\Gestor as Gest;
use App\Models\Rh as R;

class Controller extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct() {

        $this->gravaSession();
    }

    public function gravaSession() {

       /*
        if (session('ispreposto')) {
            //Session já existe, nada a fazer
        } else {
            $prep = Prep::where('ma_preposto', getenv('USERNAME'))->get();
            if (!is_null(@$prep[0]->ma_preposto)) {
                session()->put('ispreposto', 1);
            } else {
                session()->put('ispreposto', 0);
            }
        }


        //Verificação de perfil do usuário - GESTOR
        if (session('isgestor')) {
            //Session já existe, nada a fazer
        } else {
            $gest = Gest::where('ma_gestor', getenv('USERNAME'))->get();
            if (!is_null(@$gest[0]->ma_gestor)) {
                session()->put('isgestor', 1);
            } else {
                session()->put('isgestor', 0);
            }
        }


        //Verificação de perfil do usuário - RH
        if (session('isrh')) {
            //Session já existe, nada a fazer
        } else {
            $rh = R::where('ma_rh', getenv('USERNAME'))->get();
            if (!is_null(@$rh[0]->ma_rh)) {
                session()->put('isrh', 1);
            } else {
                session()->put('isrh', 0);
            }
        }
        */
    }

}
