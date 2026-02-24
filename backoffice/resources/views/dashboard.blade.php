@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <div class="flex-shrink-0">
            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="-8 3 40 19" fill="white">
                    <g>
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M12 14v8H4a8 8 0 0 1 8-8zm0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm9 4h1v5h-8v-5h1v-1a3 3 0 0 1 6 0v1zm-2 0v-1a1 1 0 0 0-2 0v1h2z"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="ms-4">
            <h2 class="fw-bold mb-0">Ciao {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">Admin ufficiale delle Olimpiadi Invernali 2026</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5 bg-light">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-3 py-2 py-md-0">
                    <span class="text-muted">Database:</span>
                    <span class="text-success fw-bold ms-1">Online</span>
                </div>
                <div class="col-md-3 py-2 py-md-0 border-start-md">
                    <span class="text-muted">Discipline attive:</span>
                    <span class="fw-bold ms-1">15</span>
                </div>
                <div class="col-md-6 text-md-end fst-italic opacity-75">
                    <small>"Citius, Altius, Fortius &ndash; Communiter"</small>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
        </div>
    @endif

    <div class="row g-4 justify-content-center">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="mb-4 text-primary">
                        <i class="fas fa-skating fa-4x"></i>
                    </div>
                    <h4 class="card-title fw-bold">Discipline</h4>
                    <p class="card-text text-muted mb-4">Gestisci l'elenco delle discipline, aggiungi nuovi sport o modifica le descrizioni esistenti.</p>
                    <a href="{{ route('disciplines.index') }}" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
                        Vai alle Discipline
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="mb-4 text-success opacity-50">
                        <i class="fas fa-user-ninja fa-4x"></i>
                    </div>
                    <h4 class="card-title fw-bold">Atleti</h4>
                    <p class="card-text text-muted mb-4">Visualizza l'elenco degli atleti olimpici e assegna loro le discipline di gara ufficiali.</p>
                    <a href="{{route('athletes.index')}}" class="btn btn-outline-success btn-lg w-100 rounded-pill">
                        Vai agli Atleti
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 768px) {
        .border-start-md {
            border-left: 1px solid rgba(0,0,0,0.1);
        }
    }
</style>
@endsection