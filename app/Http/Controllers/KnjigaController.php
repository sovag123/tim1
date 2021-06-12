<?php

namespace App\Http\Controllers;

use App\Models\Knjiga;
use App\Models\KnjigaZanr;
use App\Models\AutorKnjiga;
use App\Models\Autor;
use App\Models\Zanr;
use App\Models\Jezik;
use App\Models\Pismo;
use App\Models\Format;
use App\Models\Povez;
use App\Models\User;
use App\Models\Kategorija;
use App\Models\KategorijaKnjiga;
use App\Models\Izdavanje;
use Illuminate\Http\Request;
use App\Models\Izdavac;
use App\Models\Rezervacija;
use App\Models\Statusknjige;
use App\Models\Izdavanjestatusknjige;
use App\Models\Rzrezervacije;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KnjigaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        // if($autori != null)  
            // dd($autori);

        $kategorije = Kategorija::all();
        // if($request == NULL){
            $autori = Autor::all();
            $knjige=Knjiga::with(['autors','zanrs','kategorijas'])->get();
            return view('knjiga.index',['knjige'=>$knjige,'autori'=>$autori,'kategorije'=>$kategorije]);
        // }
        // else{
        // dd($request);

        //     $checkboxArr = $request->input('check_box');
        // $autori_arr = [];
        // foreach ($checkboxArr as $element) {
        //     array_push($autori_arr, Autor::find($element));
        // }

        // $knjigice=[];
        // foreach($autori_arr as $autir){
        //     $temp_id = AutorKnjiga::firstWhere('autor_id',$autir);
        //     array_push($knjigice, Knjiga::find($temp_id->knjiga_id));
        // }
        // dd($knjigice);
        // }
        
    }
     /*
       Start test
    */
        public function create0(){
            $kategorije=Kategorija::all();
        $zanri=Zanr::all();
        $autori=Autor::all();
        $izdavaci=Izdavac::all();
        $pisma=Pismo::all();
        $formati=Format::all();
        $jezici=Jezik::all();
        $povezi=Povez::all();
        return view('knjiga.create0',compact(
        'zanri',
        'autori',
        'kategorije',
        'pisma',
        'formati',
        'jezici',
        'povezi',
        'izdavaci'
        ));
        }

     /* kraj test*/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategorije=Kategorija::all();
        $zanri=Zanr::all();
        $autori=Autor::all();
        $izdavaci=Izdavac::all();
        $pisma=Pismo::all();
        $formati=Format::all();
        $jezici=Jezik::all();
        $povezi=Povez::all();
        return view('knjiga.create',compact(
        'zanri',
        'autori',
        'kategorije',
        'pisma',
        'formati',
        'jezici',
        'povezi',
        'izdavaci'
        ));
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
         'nazivKnjiga'=>'required',
         'kategorije'=>'required',
         'zanrovi'=>'required',
         'autori'=>'required',
         'izdavac'=>'required',
         'godina'=>'required',
         'knjigaKolicina'=>'required',
         'brStrana'=>'required',
         'pismo'=>'required',
         'jezik'=>'required',
         'format'=>'required',
         'povez'=>'required',
         'pismo'=>'required',
         'isbn'=>'required|min:20|max:20'
        ]);
        
        $autori=explode(',',$request->autori);
        $zanri=explode(',',$request->zanrovi);
        $kategorije=explode(',',$request->kategorije);
        $knjiga=Knjiga::create([
            'Naslov'=>$request->nazivKnjiga,
            'izdavac_id'=>$request->izdavac,
            'pismo_id'=>$request->pismo,
            'jezik_id'=>$request->jezik,
            'format_id'=>$request->format,
            'povez_id'=>$request->povez,
            'BrojStrana'=>$request->brStrana,
            'DatumIzdavanja'=>$request->godina,
            'UkupnoPrimjeraka'=>$request->knjigaKolicina,
            'IzdatoPrimjeraka'=>$request->izdato,
            'RezervisanoPrimjeraka'=>$request->rezervisano,
            'Sadrzaj'=>$request->kratki_sadrzaj,
            'ISBN'=>$request->isbn
           ]);
          
           foreach($autori as $autor):
           $knjiga->autors()->attach($autor);
           endforeach;
           foreach($zanri as $zanr):
           $knjiga->zanrs()->attach($zanr);
           endforeach;
           foreach($kategorije as $kategorija):
           $knjiga->kategorijas()->attach($kategorija);
          endforeach;
         if($knjiga){
            return redirect()->route('knjiga.index')->with('success','Nova knjiga je uspjesno dodata');
           }
            return redirect()->route('knjiga.index')->with('fail','Nova knjiga nije uspjesno dodata');
           
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Knjiga  $knjiga
     * @return \Illuminate\Http\Response
     */
    public function show(Knjiga $knjiga)
    {  
        $knjiga=Knjiga::with('autors','zanrs','kategorijas')->where('id',$knjiga->id)->first();
        $listaIzdanja = Izdavanje::all();
        $datetime1 = new DateTime(Carbon::now());
        // $datetime2 = new DateTime($izdavanje->datumizdavanja);
        // $interval = $datetime1->diff($datetime2);
        // $days = $interval->format('%a');
        // $dani;
        $rezervacije = Rezervacija::paginate(4);
        $knjige = Knjiga::all();
        // ddd($rezervacije);

       
        return view('knjiga.show',['knjiga'=>$knjiga,'listaIzdanja'=>$listaIzdanja,'datetime1'=>$datetime1,'rezervacije'=>$rezervacije]);
    }
   public function spec(Knjiga $knjiga){
        $knjiga=Knjiga::with('autors','zanrs','kategorijas')->where('id',$knjiga->id)->first();
    
        return view('knjiga.spec',compact('knjiga'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Knjiga  $knjiga
     * @return \Illuminate\Http\Response
     */
    public function edit(Knjiga $knjiga)
    {
        $knjiga=Knjiga::where('id',$knjiga->id)->with('autors','zanrs','kategorijas')->first();
        $kategorije=Kategorija::all();
        $zanri=Zanr::all();
        $autori=Autor::all();
        $izdavaci=Izdavac::all();
        $pisma=Pismo::all();
        $formati=Format::all();
        $jezici=Jezik::all();
        $povezi=Povez::all();
        return view('knjiga.edit',compact(
            'knjiga',
            'zanri',
            'autori',
            'kategorije',
            'pisma',
            'formati',
            'jezici',
            'povezi',
            'izdavaci'
     ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Knjiga  $knjiga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Knjiga $knjiga)
    {
       
        $request->validate([
            'nazivKnjigaEdit'=>'required',
            'kategorije'=>'required',
            'zanrovi'=>'required',
            'autori'=>'required',
            'izdavacEdit'=>'required',
            'godinaIzdavanjaEdit'=>'required',
            'knjigaKolicinaEdit'=>'required',
            'brStranaEdit'=>'required',
            'pismo'=>'required',
            'jezik'=>'required',
            'format'=>'required',
            'povez'=>'required',
            'isbnEdit'=>'required|min:20|max:20'
        ]);
    
        $autori=explode(',',$request->autori);
        $zanri=explode(',',$request->zanrovi);
        $kategorije=explode(',',$request->kategorije);
       
        $knjiga1=Knjiga::find($knjiga->id);
        $knjiga1->Naslov=$request->nazivKnjigaEdit;
        $knjiga1->izdavac_id=$request->izdavacEdit;
        $knjiga1->pismo_id=$request->pismo;
        $knjiga1->jezik_id=$request->jezik;
        $knjiga1->format_id=$request->format;
        $knjiga1->povez_id=$request->povez;
        $knjiga1->BrojStrana=$request->brStranaEdit;
        $knjiga1->DatumIzdavanja=$request->godinaIzdavanjaEdit;
        $knjiga1->UkupnoPrimjeraka=$request->knjigaKolicinaEdit;
        $knjiga1->Sadrzaj=$request->kratki_sadrzaj;
        $knjiga1->ISBN=$request->isbnEdit;
        $knjiga=$knjiga1->save();
        
        $knjiga1->autors()->sync(array_values($autori));
        $knjiga1->zanrs()->sync(array_values($zanri));
        $knjiga1->kategorijas()->sync(array_values($kategorije));
        if($knjiga){
            return redirect()->route('knjiga.index')->with('success','Knjiga je uspjesno azurirana');
           }else{
            return redirect()->route('knjiga.index')->with('fail','Knjiga nije uspjesno azurirana');
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Knjiga  $knjiga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Knjiga $knjiga)
    {
        $knjiga=Knjiga::where('id',$knjiga->id)->delete();
        if($knjiga){
            return redirect()->route('knjiga.index')->with('success','Knjiga je uspjesno obrisana');
           }else{
            return redirect()->route('knjiga.index')->with('fail','Knjiga nije uspjesno obrisana');
           }

    }
    //funkcija za frontend izdaj knjigu 
    public function izdavanje(Knjiga $knjiga){
        $knjiga=Knjiga::findOrFail($knjiga->id);
        $ucenici=User::ucenici();
          return view('knjiga.izdavanje',compact('knjiga','ucenici'));
    }

    //evidencija iznajmljene knjige

    public function iznajmljena(Knjiga $knjiga){
        $knjiga=Knjiga::findOrFail($knjiga->id);
        $izdate=Izdavanje::where('knjiga_id',$knjiga->id)->get();
        return view('knjiga.evidencija_iznajmljena',compact('knjiga','izdate'));
        }
    // funkcija za akciju izdaj knjigu
    public function izdaj(Request $request,Knjiga $knjiga){
         $request->validate([
            'ucenik'=>'required',
           'datumIzdavanja'=>'required',
           'datumVracanja'=>'required',
         ]);
        $datumVracanja=explode('/',$request->datumVracanja);
         $datumVracanja="$datumVracanja[2]-$datumVracanja[1]-$datumVracanja[0]";
         $id = Auth::user()->id;
        //  dd($id);
         $izdavanje=Izdavanje::create([
          'knjiga_id'=>$knjiga->id,
          'izdaokorisnik_id'=>$id,
          'pozajmiokorisnik_id'=>$request->ucenik,
          'datumizdavanja'=>$request->datumIzdavanja,
          'datumvracanja'=>$datumVracanja
         ]);
        /* $izdavanje->izdataOd('knjiga_id','izdaokorisnik_id');
         $izdavanje->izdataZa('knjiga_id','pozajmiokorisnik_id');
         $izdavanje->izdaoKnjigu('izdaokorisnik_id','knjiga_id');
         $izdavanje->pozajmioKnjigu('pozajmiokorisnik_id','knjiga_id');*/
        //  $id=Statusknjige::firstWhere('Naziv','Izdata')->id;
        //  $izdavanje->statusknjiges()->attach($id);
        

        //  dd($request->datumIzdavanja);
        $izdavanjeStatusKnjige = new Izdavanjestatusknjige();
        $izdavanjeStatusKnjige->izdavanje_id = $izdavanje->id;
        $izdavanjeStatusKnjige->statusknjige_id = Statusknjige::firstWhere('Naziv', 'Izdata')->id;
        $izdavanjeStatusKnjige->datum = $request->datumIzdavanja;
        $izdavanjeStatusKnjige->save();
        
        if($izdavanje){
            $knjiga1=Knjiga::find($knjiga->id);
             // Kako da ubacimo tri parametra $knjiga1->iznajmili_ucenici()->attach($request->ucenik);
             $knjiga1->IzdatoPrimjeraka=$knjiga1->IzdatoPrimjeraka+1;
             $knjiga2=$knjiga1->save();
             if($knjiga2){
                 return  redirect()->route('knjiga.index')->with('success','Knjiga je uspjesno izdata');
               }
             }
         return redirect()->route('knjiga.index')->with('fail','Knjiga nije uspjesno izdata');
    }
    //funcija za frontend rezervacija knjige
    public function rezervacija(Knjiga $knjiga){
        $knjiga=Knjiga::findOrFail($knjiga->id);
        $ucenici=User::ucenici();
        return view('knjiga.rezervacija',compact('knjiga','ucenici'));

    }
    // fukcija za akciju rezervacije
    public function rezervisi(Request $request, Knjiga $knjiga){
     $request->validate([
      'ucenik'=>'required',
      'datumRezervisanja'=>'required'
     ]);
      $rezervacija=Rezervacija::create([
      'knjiga_id'=>$knjiga->id,
      'rezervisaokorisnik_id'=>Auth::user()->id,
      'zakorisnik_id'=>$request->ucenik,
      'razlogzatvaranja_id'=>1,
      'datumpodnosenja'=>$request->datumRezervisanja,
      'datumrezervacije'=>$request->datumRezervisanja,
      'datumzatvaranja'=>$request->datumRezervisanja
     ]);
     if($rezervacija){
         $knjiga1=Knjiga::find($knjiga->id);
         $knjiga1->RezervisanoPrimjeraka=$knjiga1->RezervisanoPrimjeraka+1;
         $knjiga2=$knjiga1->save();
         if($knjiga2){
             return  redirect()->route('knjiga.index')->with('success','Knjiga je uspjesno rezervisana');
           }
         }
     return redirect()->route('knjiga.index')->with('fail','Knjiga nije uspjesno rezervisana');

    }
// funkcija koja vraca podatke za frontend vrati knjigu
    public function vracanje(Knjiga $knjiga){
        $knjiga=Knjiga::findOrFail($knjiga->id);
        $sizdata=Statusknjige::where('Naziv','Izdata')->first()->id;
        $izdate=Izdavanje::where('knjiga_id',$knjiga->id)
                ->join('izdavanjestatusknjiges','izdavanjes.id','=','izdavanje_id')
                ->where('izdavanjestatusknjiges.statusknjige_id','=',$sizdata)
                ->get();
        return view('knjiga.vracanje',compact('knjiga','izdate'));

    }
    public function vrati(Request $request,Knjiga $knjiga){
        $request->validate([
            'vrati'=>'required'
        ]);
        $vracanje=[];
        for($i=0;$i<count($request->vrati);$i++):
            $j=$request->vrati[$i];
            $k='prekoracenje'.$j;
        if($request->$k=="0"):
        $vracanje[$i]=Izdavanjestatusknjige::where('izdavanje_id',$request->vrati[$i])->update([
            'statusknjige_id'=>DB::table('statusknjiges')->where('Naziv','Vracena')->first()->id
        ]);
        
        endif;
        if($request->$k=="1"):
        $vracanje[$i]=Izdavanjestatusknjige::where('izdavanje_id',$request->vrati[$i])->update([
                'statusknjige_id'=>DB::table('statusknjiges')->where('Naziv','Vracena sa prekoracenjem')->first()->id
        ]);
        endif;
        endfor;
            $trenutnoIzdato=$knjiga->IzdatoPrimjeraka-count($vracanje);
            $uknjiga=Knjiga::where('id',$knjiga->id)->update([
            'IzdatoPrimjeraka'=>$trenutnoIzdato
            ]);
            if(count($vracanje) && $uknjiga){
                return redirect()->route('knjiga.index')->with('success','Knjiga(e) uspjesno vracen(a)e');
            }
            return redirect()->route('knjiga.index')->with('fail','Knjiga(e) nije uspjesno vracen(a)e');
           
    }
    public function otpisi(Knjiga $knjiga){
        $knjiga=Knjiga::findOrFail($knjiga->id);
        $knjiga->UkupnoPrimjeraka =   $knjiga->UkupnoPrimjeraka-1;
        $knjiga->save();
        if($knjiga){
            return redirect()->route('knjiga.index')->with('success','Knjiga je uspjesno azurirana');
           }else{
            return redirect()->route('knjiga.index')->with('fail','Knjiga nije uspjesno azurirana');
           }
    }

    public function Filteric(Request $request){

        $checkboxArr = $request->input('check_box');
        $autori_arr = [];

        foreach ($checkboxArr as $element) {
            array_push($autori_arr, Autor::find($element));
        }
        // dd($autori_arr);

        // return view('knjiga.index',['autori'=>$autori_arr]);
        $kategorije = Kategorija::all();
        // if($request == NULL){
            $autori = Autor::all();
            $knjige=Knjiga::with(['autors','zanrs','kategorijas'])->get();
            return view('knjiga.index',['knjige'=>$knjige,'autori' => $autori, 'autori_filter'=>$autori_arr,'kategorije'=>$kategorije]);
        // return redirect()->route('knjiga.filteri', ['autori' => $autori_arr]);
    }
    public function rezervacijePocetna(Request $request){
        $rez = Rezervacija::find($request->rez);
        if($request->action == 1){
            return redirect()->route('knjiga.izdavanje', [$rez->knjiga_id]);
        }else {
            $razlogZatvaranje = new Rzrezervacije();
            $razlogZatvaranje->Naziv = 'Odbijena rezervacija';
            $razlogZatvaranje->save();
            $rez->razlogzatvaranja_id = $razlogZatvaranje->id;
            return redirect('/');
        }
    }
}
