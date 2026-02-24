@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="fw-bold text-uppercase">Discipline</h1>
      <p class="text-muted">Gestisci le discipline olimpiche e gli atleti collegati</p>
    </div>
    <a href="{{ route('disciplines.create') }}" class="btn btn-light px-4 shadow-sm">
      <i class="fas fa-plus me-2"></i>Nuova Disciplina
    </a>
  </div>
  <hr class="mb-4">
  <div class="filter-section mb-5">
    <form action="{{ route('disciplines.index') }}" method="GET" class="row g-3 align-items-end justify-content-center">

      <div class="col-12 col-md-6 col-lg-4">
        <label for="search" class="form-label small fw-bold text-uppercase">Cerca Nome o Sport</label>
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="search" id="search" class="form-control border-start-0" 
            placeholder="Es: Sci Alpino..." value="{{ request('search') }}">
        </div>
      </div>

      <div class="col-12 col-md-4 col-lg-3">
          <label for="sport" class="form-label small fw-bold text-uppercase">Categoria Sport</label>
          <select name="sport" id="sport" class="form-select">
              <option value="">Tutti gli sport</option>
              
              @foreach($availableSports as $sport)
                  <option value="{{ $sport }}" {{ request('sport') == $sport ? 'selected' : '' }}>
                      {{ $sport }}
                  </option>
              @endforeach
          </select>
      </div>

        <div class="col-12 col-md-2 col-lg-2">
          <div class="btn-group w-100">
            <button type="submit" class="btn btn-primary">Filtra</button>
            <a href="{{ route('disciplines.index') }}" class="btn btn-outline-secondary" title="Reset">
              <i class="bi bi-arrow-clockwise"></i>
            </a>
          </div>
        </div>
    </form>
  </div>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse ($disciplines as $discipline)
      <div class="col">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition">

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
              <a href="{{ route('disciplines.edit', $discipline->id) }}" class="btn btn-sm btn-light">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('disciplines.destroy', $discipline->id) }}" method="POST" class="d-inline">
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
      <div class="col-12 py-5 m-auto">
        <p class="text-muted text-center display-6">Nessuna disciplina trovata</p>
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