@extends('layouts.layout')
@section('content')
     <!-- Content -->
     <section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
            <!-- Heading of content -->
            <div class="heading mt-[7px]">
                <h1 class="pl-[30px] pb-[21px]  border-b-[1px] border-[#e4dfdf] ">
                    {{ Auth::user()->name }}
                </h1>
            </div>
            <!-- Space for content -->
            <div class="pl-[30px] scroll height-dashboard overflow-auto mt-[20px] pb-[30px]">
                <div class="flex flex-row justify-between">
                    <div class="mr-[30px]">
                        <h3 class="uppercase mb-[20px]">Aktivnosti</h3>
                        <!-- Activity Cards -->
                        @foreach ($listaIzdanja as $listaIzdanje)
                            
                       
                        <div class="activity-card flex flex-row mb-[30px]">
                            <div class="w-[60px] h-[60px]">
                                <img class="rounded-full" src="/images/{{ $listaIzdanje->getIzdaoUser()->Foto }}" alt="">
                            </div>
                            <div class="ml-[15px] mt-[5px] flex flex-col">
                                <div class="text-gray-500 mb-[5px]">
                                    <p class="uppercase">
                                        Izdavanje knjige
                                        <span class="inline lowercase">
                                           <?php
                                            $datetime2 = new DateTime($listaIzdanje->datumizdavanja);
                                            $interval = $datetime1->diff($datetime2);
                                            $days = $interval->format('%a');
                                           echo $days;?> days ago
                                        </span>
                                    </p>
                                </div>
                                <div class="">
                                    <p>
                                        <a href="{{ route('bibliotekar.show', $listaIzdanje->getIzdaoUser()->id )}}" class="text-[#2196f3] hover:text-blue-600">
                                            {{$listaIzdanje->getIzdaoUser()->ImePrezime}}
                                        </a>
                                        je izdao/la knjigu <span class="font-medium">{{ $listaIzdanje->knji()->Naslov}} </span>
                                        <a href="{{route('ucenik.show',  $listaIzdanje->uzeoUser()->id) }}" class="text-[#2196f3] hover:text-blue-600">
                                            {{$listaIzdanje->uzeoUser()->ImePrezime }}
                                        </a>
                                        dana <span class="font-medium">{{ $listaIzdanje->datumizdavanja }} </span>
                                        <a href="izdavanjeDetalji.php" class="text-[#2196f3] hover:text-blue-600">
                                            pogledaj detaljnije >>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                       
                       
                        <div class="inline-block w-full mt-4">
                            <a href="dashboardAktivnost.php"
                                class="btn-animation block text-center w-full px-4 py-2 text-sm tracking-wider text-gray-600 transition duration-300 ease-in border-[1px] border-gray-400 rounded hover:bg-gray-200 focus:outline-none focus:ring-[1px] focus:ring-gray-300">
                                Show
                            </a>
                        </div>
                    </div>
                    <div class="mr-[50px] ">
                        <h3 class="uppercase mb-[20px] text-left">
                            Rezervacije knjiga
                        </h3>
                        <div>
                            <table class="w-[560px] table-auto">
                                <tbody class="bg-gray-200">
                                    @foreach ($rezervacije as $rezervacija)
                                        
                                    <tr class="bg-white border-b-[1px] border-[#e4dfdf]">
                                        <td class="flex flex-row items-center px-2 py-4">
                                            <img class="object-cover w-8 h-8 rounded-full "
                                                src="/images/{{ $rezervacija->zaKorisnika()->Foto}}" alt="" />
                                            <a href="ucenikProfile.php" class="ml-2 font-medium text-center">{{ $rezervacija->zaKorisnika()->ImePrezime}}</a>
                                        <td>
                                        </td>
                                        <td class="px-2 py-2">
                                            <a href="knjigaOsnovniDetalji.php">
                                            {{ $rezervacija->knjiga()->Naslov}}
                                            </a>
                                        </td>
                                        <td class="px-2 py-2">
                                            <form action="{{ route('knjiga.rezervacijePocetna') }}" method="POST">
                                                @csrf
                                                <button type="submit" name="action" value="1">
                                                    <i class="fas fa-check hover:text-green-500 mr-[5px]"></i>
                                                </button>
                                                <button type="submit" name="action" value="2">
                                                    <i class="fas fa-times hover:text-red-500"></i>
                                                </button>
                                                <input type="hidden" value="{{ $rezervacija->id }}" name="rez">
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
                            <div class="text-right mt-[5px]">
                                <a href="aktivneRezervacije.php" class="text-[#2196f3] hover:text-blue-600">
                                    <i class="fas fa-calendar-alt mr-[4px]" aria-hidden="true"></i>
                                    Prikazi sve
                                </a>
                            </div>
                        </div>
                        <div class="relative">
                            <h3 class="uppercase mb-[20px] text-left py-[30px]">
                                Statistika
                            </h3>
                            <div class="text-right">
                                <div class="flex pb-[30px]">
                                    <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="izdateKnjige.php">
                                        Izdate knjige
                                    </a>
                                    <div class="ml-[30px] bg-green-600 transition duration-200 ease-in  hover:bg-green-900 stats-bar-green h-[26px]">

                                    </div>
                                    <p class="ml-[10px] number-green text-[#2196f3] hover:text-blue-600">
                                   
                                          {{$brojac}}
                                    
                                    </p>
                                </div>
                                <div class="flex pb-[30px]">
                                    <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="aktivneRezervacije.php">
                                        Rezervisane knjige
                                    </a>
                                    <div class="ml-[30px] bg-yellow-600 transition duration-200 ease-in  hover:bg-yellow-900 stats-bar-yellow  h-[26px]">

                                    </div>
                                    <p class="ml-[10px] text-[#2196f3] hover:text-blue-600 number-yellow">
                                        {{ $rezervacije->count()}}
                                    </p>
                                </div>
                                <div class="flex pb-[30px]">
                                    <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="knjigePrekoracenje.php">
                                        Knjige u prekoracenju
                                    </a>
                                    <div class="ml-[30px] bg-red-600 transition duration-200 ease-in hover:bg-red-900 stats-bar-red h-[26px]">

                                    </div>
                                    <p class="ml-[10px] text-[#2196f3] hover:text-blue-600 number-red">
                                      {{$brojac1}}
                                    </p>
                                </div>
                            </div>
                            <div class="absolute h-[220px] w-[1px] bg-black top-[78px] left-[174px]">
                            </div>
                            <div class="absolute flex conte left-[175px] border-t-[1px] border-[#e4dfdf] top-[248px] pr-[87px]">
                                <p class="ml-[-13px]">
                                    0
                                </p>
                                <p class="ml-[57px]">
                                    20
                                </p>
                                <p class="ml-[57px]">
                                    40
                                </p>
                                <p class="ml-[57px]">
                                    60
                                </p>
                                <p class="ml-[57px]">
                                    80
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            
        </section>
        <!-- End Content -->
@endsection
