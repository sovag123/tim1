<?php

namespace App\Http\Controllers;

use App\Models\Izdavanje;
use App\Models\Knjiga;
use App\Models\Rezervacija;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $listaIzdanja = Izdavanje::all();
        $datetime1 = new DateTime(Carbon::now());
        // $datetime2 = new DateTime($izdavanje->datumizdavanja);
        // $interval = $datetime1->diff($datetime2);
        // $days = $interval->format('%a');
        // $dani;
        $rezervacije = Rezervacija::paginate(4);
        $knjige = Knjiga::all();
        $brojac = 0;
        $brojac1 = 0;
        foreach($knjige as $knjiga){
            $brojac+=$knjiga->IzdatoPrimjeraka;
            $brojac1+=$knjiga->RezervisanoPrimjeraka;
        }
        // ddd($brojac);
        
        return view('dashboard.index',['listaIzdanja'=>$listaIzdanja,'datetime1'=>$datetime1,'rezervacije'=>$rezervacije,'knjige'=>$knjige,'brojac'=>$brojac,'brojac1'=>$brojac1]);
    }
}
