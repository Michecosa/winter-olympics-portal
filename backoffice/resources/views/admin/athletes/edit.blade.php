@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="mb-5 text-center">
                <i class="bi bi-person-gear text-dark display-4 mb-2"></i>
                <h1 class="fw-bold">Modifica Profilo Atleta</h1>
                <p class="text-muted">Aggiorna le informazioni di: <strong>{{ $athlete->first_name }} {{ $athlete->last_name }}</strong></p>
            </div>

            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('athletes.update', $athlete->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nome --}}
                            <div class="col-md-6 mb-4">
                                <label for="first_name" class="form-label fw-bold small text-uppercase">Nome</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="first_name" id="first_name" class="form-control border-start-0 @error('first_name') is-invalid @enderror" 
                                           value="{{ old('first_name', $athlete->first_name) }}" placeholder="Es: Mario">
                                </div>
                                @error('first_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Cognome --}}
                            <div class="col-md-6 mb-4">
                                <label for="last_name" class="form-label fw-bold small text-uppercase">Cognome</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="last_name" id="last_name" class="form-control border-start-0 @error('last_name') is-invalid @enderror" 
                                           value="{{ old('last_name', $athlete->last_name) }}" placeholder="Es: Rossi">
                                </div>
                                @error('last_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Nazione --}}
                            <div class="col-md-7 mb-4">
                                <label for="country_id" class="form-label fw-bold small text-uppercase">Nazione</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-globe text-muted"></i>
                                    </span>
                                    <select name="country_id" id="country_id" class="form-select border-start-0 @error('country_id') is-invalid @enderror">
                                        <option value="" disabled {{ old('country_id', $athlete->country_id) ? '' : 'selected' }}>
                                            Seleziona Nazione...
                                        </option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $athlete->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('country_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Data di Nascita --}}
                            <div class="col-md-5 mb-4">
                                <label for="birth_date" class="form-label fw-bold small text-uppercase">Data di Nascita</label>
                                <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       value="{{ old('birth_date', $athlete->birth_date) }}">
                                @error('birth_date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Biografia --}}
                            <div class="col-12 mb-4">
                                <label for="bio" class="form-label fw-bold small text-uppercase">Biografia</label>
                                <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" 
                                          placeholder="Inserisci una breve biografia...">{{ old('bio', $athlete->bio) }}</textarea>
                            </div>

                            {{-- Discipline --}}
                            <div class="col-12 mb-5">
                                <label class="form-label fw-bold small text-uppercase mb-3">
                                    Discipline
                                </label>
                                <div class="discipline-selector p-3 border rounded shadow-sm bg-light-subtle">
                                    <div class="row row-cols-1 row-cols-sm-2 g-2 overflow-auto" style="max-height: 250px;">
                                        @foreach($disciplines as $discipline)
                                            <div class="col">
                                                <div class="form-check athlete-card h-100 p-2 border rounded bg-white">
                                                    <input class="form-check-input ms-1" type="checkbox" name="disciplines[]" value="{{ $discipline->id }}" id="disc-{{ $discipline->id }}"
                                                          @if($errors->any())
                                                              {{ is_array(old('disciplines')) && in_array($discipline->id, old('disciplines')) ? 'checked' : '' }}
                                                          @else
                                                              {{ $athlete->disciplines->contains($discipline->id) ? 'checked' : '' }}
                                                          @endif
                                                    >
                                                    <label class="form-check-label ps-2 small fw-semibold" for="disc-{{ $discipline->id }}">
                                                        {{ $discipline->name }} <span class="text-muted small">({{ $discipline->sport }})</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('athletes.show', $athlete->id) }}" class="btn btn-link text-decoration-none text-muted p-0">
                                <i class="bi bi-x-circle me-2"></i>Annulla
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">
                                Aggiorna Profilo <i class="bi bi-save ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .athlete-card:hover {
        background-color: #f8f9fa !important;
        border-color: #0d6efd !important;
        transition: all 0.2s ease;
    }
    .input-group-text {
        color: #6c757d;
    }
</style>
@endsection