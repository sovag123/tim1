@extends('layouts.layout')
@section('content')

<section class="w-screen h-screen pl-[80px] pb-2 text-gray-700">
    <!-- Heading of content -->
    <div class="heading">
        <div class="flex flex-row justify-between border-b-[1px] border-[#e4dfdf]">
            <div class="py-[10px] flex flex-row">
                <div class="w-[77px] pl-[30px]">
                    <img src="/img/tomsojer.jpg" alt="">
                </div>
                <div class="pl-[15px]  flex flex-col">
                    <div>
                        <h1>
                            {{$knjiga->Naslov}}
                        </h1>
                    </div>
                    <div>
                        <nav class="w-full rounded">
                            <ol class="flex list-reset">
                                <li>
                                    <a href="{{route('evidencija.index')}}" class="text-[#2196f3] hover:text-blue-600">
                                        Evidencija knjiga
                                    </a>
                                </li>
                                <li>
                                    <span class="mx-2">/</span>
                                </li>
                                <li>
                                    <a href="{{route('knjiga.show',$knjiga)}}"
                                        class="text-[#2196f3] hover:text-blue-600">
                                        KNJIGA-467
                                    </a>
                                </li>
                                <li>
                                    <span class="mx-2">/</span>
                                </li>
                                <li>
                                    <a href="izdavanjeDetalji.php"
                                        class="text-[#2196f3] hover:text-blue-600">
                                        IZDAVANJE-421
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="pt-[24px] mr-[30px]">
                <a href="{{route('knjiga.otpisi',$knjiga)}}" class="inline hover:text-blue-600">
                    <i class="fas fa-level-up-alt mr-[3px]"></i> 
                    Otpisi knjigu
                </a>
            <a href="{{route('knjiga.izdavanje',$knjiga)}}" class="inline hover:text-blue-600 ml-[20px] pr-[10px]">
                    <i class="far fa-hand-scissors mr-[3px]"></i>
                    Izdaj knjigu
                </a>
                <a href="{{route('knjiga.vracanje',$knjiga)}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                    <i class="fas fa-redo-alt mr-[3px] "></i>
                    Vrati knjigu
                </a>
                <a href="{{route('knjiga.rezervacija',$knjiga->id)}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                    <i class="far fa-calendar-check mr-[3px] "></i>
                    Rezervisi knjigu
                </a>
                <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-[#e4dfdf] dotsIzdavanjeDetalji hover:text-[#606FC7]">
                    <i
                        class="fas fa-ellipsis-v"></i>
                </p>
                <div
                    class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-izdavanje-detalji">
                    <div class="absolute right-0 w-56 mt-[7px] origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                        aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                        <div class="py-1">
                            <a href="{{route('knjiga.edit',$knjiga->id)}}" tabindex="0"
                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                role="menuitem">
                                <i class="fas fa-edit mr-[1px] ml-[5px] py-1"></i>
                                <span class="px-4 py-0">Izmijeni knjigu</span>
                            </a>
                            <a href="{{route('knjiga.destroy',$knjiga->id)}}" tabindex="0"
                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                role="menuitem">
                                <i class="fa fa-trash mr-[5px] ml-[5px] py-1"></i>
                                <span class="px-4 py-0">Izbrisi knjigu</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-row height-detaljiIzdavanje scroll pb-[20px]">
        <div class="">
            <!-- Space for content -->
            <div class="pl-[30px] section- mt-[20px]">
                <div class="flex flex-row justify-between">
                    <div class="mr-[30px]">
                        <div class="mt-[20px]">
                            <span class="text-gray-500">Tip transakcije</span><br>
                            <p
                                class="inline-block bg-blue-200 text-blue-800 rounded-[10px] text-center px-[6px] py-[2px]">
                                Izdavanje knjiga
                            </p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">{{$izdavanje->datumizdavanja}}</span>
                            <p class="font-medium">12.05.2020</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Trenutno zadrzavanje knjige</span>
                            <p class="font-medium">{{$days}} dana</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Prekoracenje</span>
                            <p class="font-medium">Nema prekoracenja</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Bibliotekar</span>
                            <a href="{{route('bibliotekar.show',$bibliotekar)}}"
                                class="block font-medium text-[#2196f3] hover:text-blue-600">{{$bibliotekar->ImePrezime}}</a>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Ucenik</span>
                            <a href="{{route('ucenik.show',$ucenik)}}"
                                class="block font-medium text-[#2196f3] hover:text-blue-600">{{$ucenik->ImePrezime}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 w-full">
        <div class="flex flex-row">
            <div class="inline-block w-full text-white text-right py-[7px] mr-[100px]">
                <button  href="{{route('knjiga.otpisi',$knjiga)}}"
                    class="btn-animation show-otpisiModal shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#FF470E] bg-[#FF5722]">
                    <i class="fas fa-level-up-alt mr-[4px] "></i> Otpisi knjigu
                </button>
                <button href="{{route('knjiga.vracanje',$knjiga)}}"
                    class="ml-[10px] btn-animation show-vratiModal shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#46A149] bg-[#4CAF50]">
                    <i class="fas fa-redo-alt mr-[4px] "></i> Vrati knjigu
                </button>
                <button type="button"
                    class="ml-[10px] btn-animation show-izbrisiModal shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                    <i class="fas fa-trash mr-[4px]"></i> Izbrisi zapis
                </button>
            </div>
        </div>
    </div>
</section>
@endsection