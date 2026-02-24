@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold text-uppercase">Discipline</h1>
            <p class="text-muted">Gestisci le discipline olimpiche e gli atleti collegati</p>
        </div>
        <a href="{{-- {{ route('admin.disciplines.create') }} --}}" class="btn btn-light px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i>Nuova Disciplina
        </a>
    </div>
    <hr class="mb-5">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($disciplines as $discipline)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    {{-- Immagine Placeholder basata sullo sport --}}
                    <img src="https://placehold.co/600x400?text={{ urlencode($discipline->sport) }}" 
                         class="card-img-top" 
                         alt="{{ $discipline->name }}">
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-secondary-subtle text-secondary border">
                                {{ $discipline->sport }}
                            </span>
                            <small class="text-muted">ID: #{{ $discipline->id }}</small>
                        </div>
                        
                        <h5 class="card-title fw-bold">{{ $discipline->name }}</h5>
                        
                        <p class="card-text text-muted">
                            {{ Str::limit($discipline->description, 120) }}
                        </p>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between pb-3">
                        <a href="{{ route('disciplines.show', $discipline->id) }}" class="btn btn-sm btn-outline-primary">
                            Dettagli
                        </a>
                        <div class="btn-group">
                            <a href="{{-- {{ route('admin.disciplines.edit', $discipline->id) }} --}}" class="btn btn-sm btn-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{-- {{ route('admin.disciplines.destroy', $discipline->id) }} --}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" onclick="return confirm('Vuoi eliminare questa disciplina?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">Nessuna disciplina presente nel database.</h3>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: scale(1.015);
    }
    .transition {
        transition: all 0.2s ease;
    }
</style>
@endsection