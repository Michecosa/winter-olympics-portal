@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="mb-4 text-center">
                <i class="bi bi-trophy text-primary display-4 mb-2"></i>
                <h1 class="fw-bold">Nuova Disciplina</h1>
                <p class="text-muted">Inserisci i dettagli tecnici per i Winter Games 2026</p>
            </div>

            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-12">
                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('disciplines.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    {{-- Nome --}}
                                    <div class="col-md-7 mb-4">
                                        <label for="name" class="form-label fw-bold small text-uppercase">Nome Disciplina</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-tag"></i></span>
                                            <input type="text" name="name" id="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                                   value="{{ old('name') }}" placeholder="Es: Slalom Gigante">
                                        </div>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Sport --}}
                                    <div class="col-md-5 mb-4">
                                        <label for="sport" class="form-label fw-bold small text-uppercase">Sport</label>
                                        <select name="sport" id="sport" class="form-select @error('sport') is-invalid @enderror">
                                            <option value="" selected disabled>Scegli...</option>
                                            
                                            {{-- Usiamo la variabile dinamica --}}
                                            @foreach($availableSports as $sportName)
                                                <option value="{{ $sportName }}" {{ old('sport') == $sportName ? 'selected' : '' }}>
                                                    {{ $sportName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sport') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Immagine --}}
                                    <div class="col-12 mb-4">
                                        <label for="cover_image" class="form-label fw-bold small text-uppercase">Immagine di Copertina</label>
                                        <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror">
                                        <div class="form-text">Carica un'immagine rappresentativa della disciplina</div>
                                    </div>

                                    {{-- Descrizione --}}
                                    <div class="col-12 mb-4">
                                        <label for="description" class="form-label fw-bold small text-uppercase">Descrizione Tecnica</label>
                                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Descrivi brevemente la disciplina...">{{ old('description') }}</textarea>
                                    </div>

                                    {{-- Atleti --}}
                                    <div class="col-12 mb-5">
                                        <label class="form-label fw-bold small text-uppercase mb-3">
                                            <i class="bi bi-people-fill me-2"></i>Seleziona Atleti Partecipanti
                                        </label>
                                        <div class="athlete-selector p-3 border rounded shadow-sm bg-light-subtle">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2 overflow-auto" style="max-height: 250px;">
                                                @foreach($athletes as $athlete)
                                                    <div class="col">
                                                        <div class="form-check athlete-card h-100 p-2 border rounded bg-white transition shadow-sm-hover">
                                                            <input class="form-check-input ms-1" type="checkbox" name="athletes[]" value="{{ $athlete->id }}" id="athlete-{{ $athlete->id }}"
                                                                  {{ is_array(old('athletes')) && in_array($athlete->id, old('athletes')) ? 'checked' : '' }}>
                                                            <label class="form-check-label ps-2 small fw-semibold" for="athlete-{{ $athlete->id }}">
                                                                {{ $athlete->first_name }} {{ $athlete->last_name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('disciplines.index') }}" class="btn btn-outline-light text-decoration-none text-muted">
                                        <i class="bi bi-x-circle me-2"></i>Annulla
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">
                                        Crea Disciplina <i class="bi bi-check2-circle ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection