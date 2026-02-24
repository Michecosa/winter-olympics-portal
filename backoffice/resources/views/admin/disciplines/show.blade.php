@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('disciplines.index') }}" class="text-decoration-none">Discipline</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $discipline->name }}</li>
                </ol>
            </nav>
            <h1 class="fw-bold">{{ $discipline->name }}</h1>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('disciplines.edit', $discipline->id) }}" class="btn btn-outline-dark px-4">
                <i class="bi bi-pencil me-2"></i>Modifica
            </a>
            
            <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModalShow">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm overflow-hidden">
                @if($discipline->cover_image)
                    <img src="{{ asset('storage/' . $discipline->cover_image) }}" 
                        class="img-fluid w-100" 
                        style="height: 400px; object-fit: cover;" 
                        alt="{{ $discipline->name }}">
                @else
                    <img src="https://placehold.co/600x400?text={{ urlencode($discipline->sport) }}" 
                        class="img-fluid w-100" 
                        style="height: 400px; object-fit: cover;" 
                        alt="{{ $discipline->name }}">
                @endif
                
                <div class="card-body bg-dark text-white text-center py-2">
                    <small class="text-uppercase tracking-wider">Categoria: {{ $discipline->sport }}</small>
                </div>
            </div>
        </div>

        {{-- Colonna Dettagli --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Informazioni Generali</h5>
                    
                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-muted d-block">Descrizione</label>
                        <p class="lead text-dark">{{ $discipline->description }}</p>
                    </div>

                    <div class="row g-3">
                        @foreach ($discipline->getAttributes() as $chiave => $valore)
                            @if(!in_array($chiave, ['id','cover_image', 'created_at', 'updated_at', 'name', 'sport', 'description']))
                                <div class="col-md-6">
                                    <label class="text-uppercase small fw-bold text-muted d-block">{{ str_replace('_', ' ', $chiave) }}</label>
                                    <p class="fw-semibold text-dark">{{ $valore }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sezione Atleti --}}
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-users me-2 text-primary"></i>
                        Atleti Iscritti <span class="badge bg-primary ms-2">{{ $discipline->athletes->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($discipline->athletes->isNotEmpty())
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
                            @foreach ($discipline->athletes as $atleta)
                                <div class="col">
                                    <div class="d-flex align-items-center p-2 border rounded-pill bg-light hover-bg-white transition shadow-sm h-100">
                                        <div class="mx-3">
                                            @if($atleta->country)
                                                <img src="https://flagsapi.com/{{ $atleta->country->code }}/flat/48.png" 
                                                    alt="{{ $atleta->country->name }}" 
                                                    style="width: 32px; height: 32px; object-fit: contain;">
                                            @else
                                                <div class="bg-secondary rounded-circle" style="width: 32px; height: 32px;"></div>
                                            @endif
                                        </div>
                                        
                                        <div class="overflow-hidden flex-grow-1">
                                            <p class="mb-0 fw-bold text-truncate" style="font-size: 0.9rem;">
                                                {{ $atleta->first_name }} {{ $atleta->last_name }}
                                            </p>
                                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">
                                                {{ $atleta->country->code }}
                                            </small>
                                        </div>

                                        <div class="col-auto text-end pe-3">
                                            @if($atleta->pivot->medal_type === 'gold')
                                                <i class="bi bi-trophy-fill h5 mb-0" style="color: #FFD700;" title="Oro"></i>
                                            @elseif($atleta->pivot->medal_type === 'silver')
                                                <i class="bi bi-trophy-fill h5 mb-0" style="color: #C0C0C0;" title="Argento"></i>
                                            @elseif($atleta->pivot->medal_type === 'bronze')
                                                <i class="bi bi-trophy-fill h5 mb-0" style="color: #CD7F32;" title="Bronzo"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Nessun atleta attualmente assegnato a questa disciplina</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModalShow" tabindex="-1" aria-labelledby="deleteModalShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteModalShowLabel">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                Stai per eliminare definitivamente la disciplina <span class="fw-bold text-danger">{{ $discipline->name }}</span>. 
                Questa operazione rimuoverà tutti i dati associati e non può essere annullata.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annulla</button>
                
                <form action="{{ route('disciplines.destroy', $discipline->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Elimina definitivamente</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.1rem; }
    .hover-bg-white:hover { background-color: white !important; cursor: default; }
    .transition { transition: all 0.3s ease; }
    .breadcrumb-item a { color: #6c757d; }
    .breadcrumb-item.active { color: #0d6efd; font-weight: bold; }
</style>
@endsection