<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Izdavanje extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function statusknjiges(){
        return $this->belongsToMany(Statusknjige::class,'izdavanjestatusknjiges','izdavanje_id','statusknjige_id');
    }

    /* Kako povezati users i knjigas preko izdavanjes
    public function izdataOd(){
        return $this->hasManyThrough(Knjiga::class,User::class,'izdavanjes','knjiga_id','izdaokorisnik_id');
    }

    public function izdataZa(){
        return $this->hasManyThrough(Knjiga::class,User::class,'izdavanjes','knjiga_id','pozajmiokorisnik_id');
    }
    public function izdaoKnjigu(){
        return $this->hasManyThrough(User::class,Knjiga::class,'izdavanjes','izdaokorisnik_id','knjiga_id');
    }
    public function pozajmioKnjigu(){
        return $this->hasManyThrough(User::class,Knjiga::class,'izdavanjes','pozajmiokorisnik_id','knjiga_id');
    }
    */
    //korisnicke metode
    public function izdato_od($id){
        $zapis=DB::table('izdavanjes')
        ->where('izdavanjes.id','=',$id)
        ->join('knjigas','knjigas.id','=','knjiga_id')
        ->join('users','users.id','=','izdaokorisnik_id')
        ->select('users.*')
        ->get();
        return $zapis;
    }
    public function izdato_za($id){
        $zapis=DB::table('izdavanjes')
        ->where('izdavanjes.id','=',$id)
        ->join('knjigas','knjigas.id','=','knjiga_id')
        ->join('users','users.id','=','pozajmiokorisnik_id')
        ->select('users.*')
        ->get();
        return $zapis;
    }
    public function izdato_knjiga($id){
        $zapis=DB::table('izdavanjes')
        ->where('izdavanjes.id','=',$id)
        ->join('knjigas','knjigas.id','=','knjiga_id')
        ->join('users','users.id','=','izdaokorisnik_id')
        ->select('knjigas.*')
        ->first();
        return $zapis;
    }
    public function zadrzavanje($id){
        $izdavanje=self::where('id',$id)->first();
        $datumizdavanja=$izdavanje->datumizdavanja;
        $zadrzavanje=time()-strtotime($datumizdavanja);
        $dana=floor($zadrzavanje/86400);
        $rezultat=[];
        if($dana==0){
           return $rezultat=['check'=>false,'dana'=>'Krace od 1 dana','mjeseci'=>'','nedjelja'=>'','danan'=>''];
        }
        $mjeseci=floor($zadrzavanje/(30*86400));
        $nedjelja=floor(($zadrzavanje-30*$mjeseci*86400)/(7*86400));
        $danan=$dana%7;
        $rezultat=['check'=>true,'dana'=>$dana,'mjeseci'=>"$mjeseci mjesec ",'nedjelja'=>"i $nedjelja nedjelje ",'danan'=>"i $danan dana "];
        return $rezultat;
    }
    public function prekoracenje($id){
        $izdavanje=self::where('id',$id)->first();
        $datumizdavanja=$izdavanje->datumizdavanja;
        $zadrzavanje=time()-strtotime($datumizdavanja);
        $dana=floor($zadrzavanje/86400);
        if($dana<=30){
            return 'Nema prekoracenja';
        }
        return ($dana-30).' dana ';
       
    }
    public function knjigas() {
        return $this->belongsTo(Knjiga::class,'id');
        }
    public function knji() {
            return Knjiga::find($this->knjiga_id);
        }

        public function getIzdaoUser () {
            $izdaoUser = User::find($this->izdaokorisnik_id);
            return $izdaoUser;
        }

        public function uzeoUser () {
            $pozajmio_korisnik = User::find($this->pozajmiokorisnik_id);
            return $pozajmio_korisnik;
        }
}
