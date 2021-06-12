<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Knjiga extends Model
{
    use HasFactory;
    protected $fillable=[
        'Naslov',
        'Sadrzaj',
        'pismo_id',
        'format_id',
        'jezik_id',
        'povez_id',
        'izdavac_id',
        'BrojStrana',
        'DatumIzdavanja',
        'UkupnoPrimjeraka',
        'IzdatoPrimjeraka',
        'RezervisanoPrimjeraka',
        'ISBN'
        ];
    protected $guarded=[];
    //korisnicki metodi 
    //protected $appends=['izdatoKnjiga','rezervisanoKnjiga'];
    /*public function getIzdatoKnjigaAttribute(){
     /* Knjiga::query()
           ->whereIn('id',function($query){
           $query->from('izdavanjes')
           ->select(['izdavanjes.knjiga_id']);
           })->count();*/
        /*   return DB::table('izdavanjes')
           ->join('knjigas','knjigas.id','=','izdavanjes.knjiga_id')
           ->select('izdavanjes.knjiga_id')
           ->count();
    }*/
    /*public function getRezervisanoKnjigaAttribute(){
        return DB::table('rezervacijas')
        ->join('knjigas','knjigas.id','=','rezervacijas.knjiga_id')
        ->select('rezervacijas.knjigas_id')
        ->count();
    }*/
    //kraj korisnickih metoda
    public function jezik(){
        return $this->belongsTo(Jezik::class);
    }

    public function pismo(){
        return $this->belongsTo(Pismo::class);
    }

    public function format(){
        return $this->belongsTo(Format::class);
    }

    public function izdavac(){
        return $this->belongsTo(Izdavac::class);
    }
    public function povez(){
        return $this->belongsTo(Povez::class);
    }
    public function autors(){
        return $this->belongsToMany(Autor::class);
        
    }
    public function zanrs(){
        return $this->belongsToMany(Zanr::class);
        
    
    }
    public function kategorijas(){
        return $this->belongsToMany(Kategorija::class);
        
    }
    public function izdataOd(){
        return $this->hasManyThrough(User::class,Izdavanje::class,'izdavanjes','knjiga_id','izdaokorisnik_id');
    }

    public function izdataZa(){
        return $this->hasManyThrough(User::class,Izdavanje::class,'izdavanjes','knjiga_id','pozajmiokorisnik_id');
    }
    
    
    
    
}
