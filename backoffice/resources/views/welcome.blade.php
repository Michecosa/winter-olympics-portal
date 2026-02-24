@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-dark text-white rounded-0 shadow-lg position-relative" 
     style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1602521519812-01bbc9ab135a?q=80&w=1174&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; min-height: 91.3vh; display: flex; align-items: center;">
    
    <div class="container py-5 text-center">
        <div class="mb-4">
            {{-- HANDCRAFTED BY ME SO PAY SOME RESPECT --}}
            <svg width="300" height="200" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                <g transform="translate(275, 100) scale(23, 18)">
                    <path 
                        d="M8.012,1.062 L4.035,8.87 L2.709,7.569 -0.305,14 M15.965,14 L15.965,13.998 L12.627,6.898 L11.644,7.51 L8.012,1.062" 
                        fill="none" 
                        stroke="white" 
                        stroke-width="0.7" 
                        stroke-linejoin="round"
                        stroke-linecap="round"
                    />
                </g>
                <g fill="none" stroke="white" stroke-width="12">
                    <circle cx="330" cy="400" r="55" />
                    <circle cx="455" cy="400" r="55" />
                    <circle cx="580" cy="400" r="55" />
                    <circle cx="392.5" cy="460" r="55" />
                    <circle cx="517.5" cy="460" r="55" />
                </g>
            </svg>
        </div>

        <h1 class="display-2 fw-bold text-uppercase tracking-widest">
            Winter Games <span class="text-primary">2026</span>
        </h1>

        <p class="col-md-8 mx-auto fs-4 text-light opacity-75 mb-5">
            L'eccellenza sportiva incontra lo spirito delle vette. Benvenuti sulla piattaforma ufficiale dedicata alle discipline e agli atleti che sfidano i limiti del ghiaccio e della neve.
        </p>

        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 gap-3 rounded-pill shadow">Accedi all'Area Privata</a>
            <a href="#discover" class="btn btn-outline-light btn-lg px-5 rounded-pill">Scopri di più</a>
        </div>
    </div>
</div>

<div id="discover" class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-8">
            <h2 class="display-5 fw-bold mb-4">Lo Spirito Olimpico</h2>
            <p class="lead"><strong>Non è solo una competizione, è il momento in cui il mondo si ferma per ammirare la forza, la grazia e la dedizione assoluta.</strong> Dallo Sci Alpino al Curling, ogni disciplina porta con sé una storia di sacrificio e gloria. Esplora il nostro archivio per conoscere i dettagli tecnici e i protagonisti di questa edizione.</p>
        </div>
        <div class="col-lg-4">
            <div class="row g-3">
                <div class="col-12 text-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/2026_Winter_Olympics_logo.svg/960px-2026_Winter_Olympics_logo.svg.png" class="img-fluid" alt="Milano Cortina 2025" style="max-height: 240px">
                </div>
        </div>
    </div>
</div>

@endsection

<style>
    .tracking-widest {
        letter-spacing: 0.15em;
    }
    .jumbotron {
        border-bottom: 5px solid #0d6efd;
    }
</style>