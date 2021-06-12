<?php

namespace App\Http\Controllers;

use App\Models\Izdavanje;
use App\Models\Izdavanjestatusknjige;
use App\Models\Statusknjige;
use App\Models\Ucenik;
use Illuminate\Http\Request;
use App\Models\Tipkorisnika;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
class UcenikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipid=Tipkorisnika::where('Naziv','Učenik')->first()->id;
        $ucenici=User::where('tipkorisnika_id',$tipid)->get();
        return view('ucenik.index',['ucenici'=>$ucenici]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tip=Tipkorisnika::all();
        return view('ucenik.create',['tip'=>$tip]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'imePrezimeUcenik'=>'required',
            'jmbgUcenik'=>'required|max:13|min:13',
            'emailUcenik'=>'required|email',
            'usernameUcenik'=>'required',
            'pwUcenik'=>'required_with:pw2Ucenik|same:pw2Ucenik|min:8',
            'pw2Ucenik'=>'min:8',
            'tip_korisnika'=>'required'
            ]);
            // dd($request->tip_korisnika);
            $ucenik=new User;
            $ucenik->ImePrezime=$request->imePrezimeUcenik;
            
            $ucenik->JMBG=$request->jmbgUcenik;
            $ucenik->email=$request->emailUcenik;
            $ucenik->KorisnickoIme=$request->usernameUcenik;
            $ucenik->password=Hash::make($request->pwUcenik);
            $ucenik->tipkorisnika_id=$request->tip_korisnika;
//             $imageName = time().'.'.$request->image->extension();
// $request->image->move(public_path('images'), $imageName);
// $ucenik->Foto = $imageName;
// dd($imageName);
            $ucenik=$ucenik->save();
            if($ucenik){
              return redirect()->route('ucenik.index')->with('success','Ucenik je uspjesno dodat');
            }
              return redirect()->route('ucenik.index')->with('fail','Ucenik nije uspjesno dodat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ucenik  $ucenik
     * @return \Illuminate\Http\Response
     */
    public function show(User $ucenik)
    {
        $ucenik=User::where('id',$ucenik->id)->first();
    
        return view('ucenik.show',['ucenik'=>$ucenik]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ucenik  $ucenik
     * @return \Illuminate\Http\Response
     */
    public function edit(User $ucenik)
    {
        $uccenik=User::where('id',$ucenik->id)->first();
        $tip=Tipkorisnika::all();
        return view('ucenik.edit',['u'=>$ucenik,'tip'=>$tip]);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ucenik  $ucenik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $ucenik)
    {
        $request->validate([
            'imePrezimeUcenikEdit'=>'required',
            'jmbgUcenikEdit'=>'required|max:13',
            'emailUcenikEdit'=>'required|email',
            'usernameUcenikEdit'=>'required',
            'pwUcenikEdit'=>'required_with:pw2UcenikEdit|same:pw2UcenikEdit|min:8',
            'pw2UcenikEdit'=>'min:8',
            'tip_korisnika'=>'required'
            ]);
            $ucenik=new User;
            $ucenik->ImePrezime=$request->imePrezimeUcenikEdit;
            $ucenik->JMBG=$request->jmbgUcenikEdit;
            $ucenik->Email=$request->emailUcenikEdit;
            $ucenik->KorisnickoIme=$request->usernameUcenikEdit;
            $ucenik->password=Hash::make($request->pwUcenikEdit);
            $ucenik->tipkorisnika_id=$request->tip_korisnika;
            $imageName = time().'.'.$request->image->extension();
$request->image->move(public_path('images'), $imageName);
$ucenik->Foto = $imageName;
            $ucenik=$ucenik->save();
            if($ucenik){
              return redirect()->route('ucenik.index')->with('success','Ucenik je uspjesno azuriran');
            }
              return redirect()->route('ucenik.index')->with('fail','Ucenik nije uspjesno azuriran');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ucenik  $ucenik
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $ucenik)
    {
        $ucenik=User::where('id',$ucenik->id)->delete();
        if($ucenik){
            return redirect()->route('ucenik.index')->with('success','Ucenik je uspjesno obrisan');
          }else{
            return redirect()->route('ucenik.index')->with('fail','Ucenik nije uspjesno obrisan');
          }
  
    }
    public function evidencija(User $ucenik){

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


            $status  = Statusknjige::find($status_knjige)->Naziv;
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
        
 
      return view('ucenik.evidencija',['matrica_proba'=>$matrica_proba,'ucenik'=>$ucenik]);
    }
    public function evidencijaRezervisani($ucenik){
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


          $status  = Statusknjige::find($status_knjige)->Naziv;
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
      

    return view('ucenik.evidencijaRezervisani',['matrica_proba'=>$matrica_proba,'ucenik'=>$ucenik]);
    } 
}
