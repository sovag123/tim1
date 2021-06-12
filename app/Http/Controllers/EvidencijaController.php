<?php

namespace App\Http\Controllers;

use App\Models\Bibliotekar;
use App\Models\Izdavanje;
use App\Models\Izdavanjestatusknjige;
use App\Models\Knjiga;
use App\Models\Statusknjige;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidencijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        // $knjige = Knjiga::all();
        // $knjiga_ids = [];
        // $izdavanja = [];
        // foreach($knjige as $knjiga){
        //     array_push($knjiga_ids,$knjiga->id);
        // }
        // foreach($knjiga_ids as $knjiga_id){
        //     array_push($izdavanja,DB::table('users')->where('izdavanjes', $knjiga_id));
        // }
        // // Izdavanje::where('knjiga_id', $knjiga_id)->firstOrFail()
        // ddd($izdavanja);

        // $izdavanje = Izdavanje::all();
        // $knjige = [];
        // $korisnici = [];
        // $brojac = -1;
        // $izdatoKorisnicima = [];
        // $statusiKnjiga = Izdavanjestatusknjige::all();
        // foreach($izdavanje as $izdaj){
        //     array_push($knjige,Knjiga::findOrFail($izdaj->knjiga_id) );
        //     array_push($korisnici,User::findOrFail($izdaj->izdaokorisnik_id));
        //     array_push($izdatoKorisnicima,User::findOrFail($izdaj->pozajmiokorisnik_id));
        // }
        // return view('evidencija.index', 
        // [
        //     'knjige'=>$knjige,
        // 'korisnici'=>$korisnici,
        // 'brojac'=>$brojac,
        // 'izdavanje'=>$izdavanje,
        // 'izdatoKorisnicima'=>$izdatoKorisnicima,
        // 'statusiKnjiga'=>$statusiKnjiga,
        // ]);

        $izdavanja = Izdavanje::all();
        $matrica_proba = [];
        $niz_proba = [];
        foreach ($izdavanja as $izdavanje){

            $imena_knjiga = $izdavanje->knji();
// ovaj sto izdaje 
            $izdavac_id = $izdavanje->izdaokorisnik_id;
            $izdavac =  User::find($izdavac_id);
// ucenik koji uzima knjigu 
            $ucenik_id = $izdavanje->pozajmiokorisnik_id;
            $ucenik = User::find($ucenik_id);
            // dump($imena_knjiga->Naslov,$izdavac->ImePrezime,$ucenik->ImePrezime);
           
            $status_knjige_id =  Izdavanjestatusknjige::firstWhere('izdavanje_id', $izdavanje->id);

            // dd($status_knjige_id);
            $status_knjige = $status_knjige_id->statusknjige_id;


            $status  = StatusKnjige::find($status_knjige)->Naziv;
            array_push($niz_proba, $imena_knjiga->Naslov);
            array_push($niz_proba, $status);
            array_push($niz_proba, $izdavac->ImePrezime);
            array_push($niz_proba, $ucenik->ImePrezime);
            array_push($niz_proba, $izdavanje->datumizdavanja);
            $datetime1 = new DateTime(Carbon::now());
        $datetime2 = new DateTime($izdavanje->datumizdavanja);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        // $nedelje = floor($days/7);
        // $dani = $days%7;
            array_push($niz_proba,$days);
            array_push($niz_proba, $izdavanje->id);
            array_push($matrica_proba, $niz_proba);
            
            $niz_proba = [];

            // ddd($nedelje,$dani);
        }
        
        
        return view('evidencija.index', ['matrica_proba'=>$matrica_proba]);
// foreach($izdavanje as $izd) {
//     array_push($knjige, $izd->knjigas);
// }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $izdavanja = Izdavanje::all();
        $matrica_proba = [];
        $niz_proba = [];
        foreach ($izdavanja as $izdavanje){

            $imena_knjiga = $izdavanje->knji();
// ovaj sto izdaje 
            $izdavac_id = $izdavanje->izdaokorisnik_id;
            $izdavac =  User::find($izdavac_id);
// ucenik koji uzima knjigu 
            $ucenik_id = $izdavanje->pozajmiokorisnik_id;
            $ucenik = User::find($ucenik_id);
            // dump($imena_knjiga->Naslov,$izdavac->ImePrezime,$ucenik->ImePrezime);
           
            $status_knjige_id =  Izdavanjestatusknjige::firstWhere('izdavanje_id', $izdavanje->id);

            // dd($status_knjige_id);
            $status_knjige = $status_knjige_id->statusknjige_id;


            $status  = StatusKnjige::find($status_knjige)->Naziv;
            array_push($niz_proba, $imena_knjiga->Naslov);
            array_push($niz_proba, $status);
            array_push($niz_proba, $izdavac->ImePrezime);
            array_push($niz_proba, $ucenik->ImePrezime);
            array_push($niz_proba, $izdavanje->datumizdavanja);
            array_push($niz_proba, $imena_knjiga->Foto);
            $datetime1 = new DateTime(Carbon::now());
        $datetime2 = new DateTime($izdavanje->datumizdavanja);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        // $nedelje = floor($days/7);
        // $dani = $days%7;
            array_push($niz_proba,$days);
            array_push($niz_proba, $izdavanje->id);
           
            array_push($matrica_proba, $niz_proba);
            
            $niz_proba = [];

            // ddd($nedelje,$dani);
        }
        
        
        return view('evidencija.vracene', ['matrica_proba'=>$matrica_proba]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $izdavanja = Izdavanje::all();
        $matrica_proba = [];
        $niz_proba = [];
        foreach ($izdavanja as $izdavanje){

            $imena_knjiga = $izdavanje->knji();
// ovaj sto izdaje 
            $izdavac_id = $izdavanje->izdaokorisnik_id;
            $izdavac =  User::find($izdavac_id);
// ucenik koji uzima knjigu 
            $ucenik_id = $izdavanje->pozajmiokorisnik_id;
            $ucenik = User::find($ucenik_id);
            // dump($imena_knjiga->Naslov,$izdavac->ImePrezime,$ucenik->ImePrezime);
           
            $status_knjige_id =  Izdavanjestatusknjige::firstWhere('izdavanje_id', $izdavanje->id);

            // dd($status_knjige_id);
            $status_knjige = $status_knjige_id->statusknjige_id;


            $status  = StatusKnjige::find($status_knjige)->Naziv;
            array_push($niz_proba, $imena_knjiga->Naslov);
            array_push($niz_proba, $status);
            array_push($niz_proba, $izdavac->ImePrezime);
            array_push($niz_proba, $ucenik->ImePrezime);
            array_push($niz_proba, $izdavanje->datumizdavanja);
            array_push($niz_proba, $imena_knjiga->Foto);
            $datetime1 = new DateTime(Carbon::now());
        $datetime2 = new DateTime($izdavanje->datumizdavanja);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        // $nedelje = floor($days/7);
        // $dani = $days%7;
            array_push($niz_proba,$days);
            array_push($niz,$izdavanje->id);
            array_push($matrica_proba, $niz_proba);
            
            
            $niz_proba = [];

            // ddd($nedelje,$dani);
        }
        
        
        return view('evidencija.vracene', ['matrica_proba'=>$matrica_proba]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $izdavanje = Izdavanje::find($id);
        $knjiga =$izdavanje->knji();
        $datetime1 = new DateTime(Carbon::now());
        $datetime2 = new DateTime($izdavanje->datumizdavanja);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        $bibliotekar = $izdavanje->getIzdaoUser();
        $ucenik = $izdavanje->uzeoUser();
        return view('evidencija.show',['izdavanje'=>$izdavanje,'knjiga'=>$knjiga,'days'=>$days,'bibliotekar'=>$bibliotekar,'ucenik'=>$ucenik]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function vracene(){
      
    }
}
