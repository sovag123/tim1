<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervacija extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function zaKorisnika(){
        return User::find($this->zakorisnik_id);
    }
    public function rezervisaoKorisnika(){
        return User::find($this->rezervisaokorisnik_id);
    }

    public function knjiga(){
        return Knjiga::find($this->knjiga_id);
    }
}
