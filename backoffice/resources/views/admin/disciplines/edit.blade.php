@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="mb-4 text-center">
                <i class="bi bi-pencil-square text-warning display-4 mb-2"></i>
                <h1 class="fw-bold">Modifica Disciplina</h1>
                <p class="text-muted">Aggiorna i dettagli per: <strong>{{ $discipline->name }}</strong></p>
            </div>

            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-12">
                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('disciplines.update', $discipline->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    {{-- Nome --}}
                                    <div class="col-md-7 mb-4">
                                        <label for="name" class="form-label fw-bold small text-uppercase">Nome Disciplina</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-tag"></i></span>
                                            <input type="text" name="name" id="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $discipline->name) }}" placeholder="Es: Slalom Gigante">
                                        </div>
                                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Sport --}}
                                    <div class="col-md-5 mb-4">
                                        <label for="sport" class="form-label fw-bold small text-uppercase">Sport</label>
                                        <select name="sport" id="sport" class="form-select @error('sport') is-invalid @enderror">
                                            <option value="" disabled>Scegli...</option>
                                            
                                            @foreach($availableSports as $sportName)
                                                <option value="{{ $sportName }}" 
                                                    {{ old('sport', $discipline->sport) == $sportName ? 'selected' : '' }}>
                                                    {{ $sportName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sport') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Immagine --}}
                                    <div class="col-12 mb-4">
                                        <label for="cover_image" class="form-label fw-bold small text-uppercase">Immagine di Copertina</label>
                                        
                                        {{-- Anteprima immagine attuale --}}
                                        @if($discipline->cover_image)
                                            <div class="mb-2">
                                                <small class="d-block text-muted mb-1">Immagine attuale:</small>
                                                <img src="{{ asset('storage/' . $discipline->cover_image) }}" class="img-thumbnail" style="height: 100px;">
                                            </div>
                                        @endif

                                        <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror">
                                        <div class="form-text">Lascia vuoto per mantenere l'immagine attuale</div>
                                    </div>

                                    {{-- Descrizione --}}
                                    <div class="col-12 mb-4">
                                        <label for="description" class="form-label fw-bold small text-uppercase">Descrizione Tecnica</label>
                                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Descrivi brevemente la disciplina...">{{ old('description', $discipline->description) }}</textarea>
                                    </div>

                                    {{-- Atleti --}}
                                    <div class="col-12 mb-5">
                                        <label class="form-label fw-bold small text-uppercase mb-3">
                                            <i class="bi bi-people-fill me-2"></i>Gestisci Atleti Partecipanti
                                        </label>

                                        @error('athletes')
                                            <div class="alert alert-danger border-0 shadow-sm mb-3 d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                                <div>{{ $message }}</div>
                                            </div>
                                        @enderror

                                        <div class="athlete-selector p-3 border rounded shadow-sm bg-light-subtle">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2 overflow-auto" style="max-height: 250px;">
                                            @foreach($athletes as $athlete)
                                                <div class="col">
                                                    <div class="form-check athlete-card h-100 p-2 border rounded bg-white shadow-sm">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <input class="form-check-input ms-1" type="checkbox" name="athletes[{{ $athlete->id }}][id]" value="{{ $athlete->id }}" id="athlete-{{ $athlete->id }}"
                                                                @if($errors->any())
                                                                    {{ is_array(old('athletes')) && isset(old('athletes')[$athlete->id]) ? 'checked' : '' }}
                                                                @else
                                                                    {{ $discipline->athletes->contains($athlete->id) ? 'checked' : '' }}
                                                                @endif
                                                            >
                                                            <label class="form-check-label ps-2 small fw-semibold" for="athlete-{{ $athlete->id }}">
                                                                {{ $athlete->first_name }} {{ $athlete->last_name }}
                                                            </label>
                                                        </div>
                                                        
                                                        <select name="athletes[{{ $athlete->id }}][medal_type]" class="form-select form-select-sm mt-1">
                                                            @php
                                                                $currentMedal = $discipline->athletes->find($athlete->id)?->pivot->medal_type ?? 'none';
                                                            @endphp
                                                            <option value="none" {{ old("athletes.$athlete->id.medal_type", $currentMedal) == 'none' ? 'selected' : '' }}>Nessuna</option>
                                                            <option value="gold" {{ old("athletes.$athlete->id.medal_type", $currentMedal) == 'gold' ? 'selected' : '' }}>Oro</option>
                                                            <option value="silver" {{ old("athletes.$athlete->id.medal_type", $currentMedal) == 'silver' ? 'selected' : '' }}>Argento</option>
                                                            <option value="bronze" {{ old("athletes.$athlete->id.medal_type", $currentMedal) == 'bronze' ? 'selected' : '' }}>Bronzo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('disciplines.show', $discipline->id) }}" class="btn btn-link text-decoration-none text-muted p-0">
                                        <i class="bi bi-x-circle me-2"></i>Annulla
                                    </a>
                                    <button type="submit" class="btn btn-warning px-5 py-2 fw-bold rounded-pill shadow">
                                        Aggiorna Disciplina <i class="bi bi-arrow-repeat ms-2"></i>
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

<script>
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('form-select-sm')) {
            const allSelects = document.querySelectorAll('.form-select-sm');
            const selectedValues = Array.from(allSelects)
                .map(s => s.value)
                .filter(v => v !== 'none');

            allSelects.forEach(select => {
                const options = select.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value !== 'none') {
                        const isSelectedElsewhere = selectedValues.includes(option.value) && select.value !== option.value;
                        option.disabled = isSelectedElsewhere;
                    }
                });
            });
        }
    });
</script>
@endsection