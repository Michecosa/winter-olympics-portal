@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('athletes.index') }}" class="text-decoration-none">Atleti</a></li>
            <li class="breadcrumb-item active">{{ $athlete->first_name }} {{ $athlete->last_name }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col p-4 p-md-5 d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="display-2 fw-bolder mb-2 text-uppercase ls-1">
                                {{ $athlete->first_name }} <span class="text-primary">{{ $athlete->last_name }}</span>
                            </h1>
                            <p class="text-muted lead">
                                <img src="https://flagsapi.com/{{ $athlete->country->code }}/flat/24.png" class="me-1" style="filter: drop-shadow(0 0 0.1rem rgba(0, 0, 0, 0.269));">
                                Nato il {{ \Carbon\Carbon::parse($athlete->birth_date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                          <a href="{{ route('athletes.edit', $athlete->id) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                              <i class="bi bi-pencil me-1"></i> Modifica
                          </a>
                          <button type="button" class="btn btn-danger px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAthleteModal">
                              <i class="bi bi-trash"></i>
                          </button>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <label class="small text-uppercase fw-bold text-dark ls-1">Biografia</label>
                        <p class="text-secondary mb-0">
                            {{ $athlete->bio ?? 'Questo atleta non ha ancora inserito una biografia ufficiale' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Medaglie --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h4 class="fw-bold mb-0 text-uppercase ls-1">Medaglie</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-5">
                        <div class="col-4">
                            <div class="text-center p-3 rounded-4 shadow-sm border-bottom border-4 border-warning">
                                <i class="bi bi-trophy-fill display-6 mb-2 text-warning"></i>
                                <div class="h2 fw-black mb-0">{{ $athlete->gold_count }}</div>
                                <div class="small text-uppercase fw-bold">Oro</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-3 rounded-4 shadow-sm border-bottom border-4 border-secondary">
                                <i class="bi bi-trophy-fill display-6 mb-2 text-secondary"></i>
                                <div class="h2 fw-black mb-0">{{ $athlete->silver_count }}</div>
                                <div class="small text-uppercase fw-boldtext-secondary">Argento</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-3 rounded-4 shadow-sm border-bottom border-4" style="border-color: #cd7f32 !important;">
                                <i class="bi bi-trophy-fill display-6 mb-2" style="color: #cd7f32"></i>
                                <div class="h2 fw-black mb-0">{{ $athlete->bronze_count }}</div>
                                <div class="small text-uppercase fw-bold">Bronzo</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 small text-uppercase text-dark ls-1 fs-6">Discipline</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-top">
                            <tbody>
                            @foreach($athlete->disciplines as $discipline)
                                <tr>
                                    <td class="ps-2 py-3">
                                        <div class="fw-bold text-muted">{{ $discipline->name }}</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        @php
                                            $medal = strtolower($discipline->pivot->medal_type);
                                            $badgeClass = match($medal) {
                                                'gold'   => 'bg-gold-subtle text-gold-dark',
                                                'silver' => 'bg-silver-subtle text-silver-dark',
                                                'bronze' => 'bg-bronze-subtle text-bronze-dark', 
                                                default  => 'bg-light text-muted'
                                            };
                                        @endphp
                                        @if($medal && $medal !== 'none')
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 border">
                                                <i class="bi bi-award-fill me-1"></i> {{ strtoupper($medal) }}
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic pe-3">Partecipante</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Discipline Attive --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h4 class="fw-bold mb-0">Discipline Attive</h4>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="list-group list-group-flush">
                        @forelse($athlete->disciplines as $discipline)
                            <a href="{{ route('disciplines.show', $discipline->id) }}" class="list-group-item list-group-item-action px-0 border-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $discipline->name }}</div>
                                    <small class="text-muted">{{ $discipline->sport }}</small>
                                </div>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-snow2 display-1 text-light mb-2"></i>
                                <p class="text-muted mb-0">Nessuna iscrizione</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteAthleteModal" tabindex="-1" aria-labelledby="deleteAthleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $athlete->id }}">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                Sei sicuro di voler eliminare l'atleta <span class="fw-bold text-danger">{{ $athlete->first_name }} {{ $athlete->last_name }}</span>? 
                Tutti i dati associati verranno rimossi definitivamente.
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Annulla</button>

                <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                        Elimina definitivamente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.ls-1 { letter-spacing: 1px; }
.bg-gold-subtle { background-color: #fff9e6; border-color: #ffe08a !important; }
.text-gold-dark { color: #856404; }
.bg-silver-subtle { background-color: #f8f9fa; border-color: #dee2e6 !important; }
.text-silver-dark { color: #383d41; }
.bg-bronze-subtle { background-color: #fff5ed; border-color: #f5c6ab !important; }
.text-bronze-dark { color: #7a401d; }
</style>
@endsection