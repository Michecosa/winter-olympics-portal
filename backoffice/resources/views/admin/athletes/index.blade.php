@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="fw-bold">Atleti per Nazione</h1>
      <div><a href="{{ route('athletes.create') }}" class="btn btn-light px-3"> Aggiungi Atleta</a></div>
    </div>

    @forelse ($countries as $country)
        <div class="mb-5">
            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                <img src="https://flagsapi.com/{{ $country->code }}/flat/48.png" 
                    alt="{{ $country->name }}" 
                    style="width: 32px; height: 32px; object-fit: contain; filter: drop-shadow(0 0 0.1rem rgba(0, 0, 0, 0.269));">
                <span class="fi fi-{{ strtolower($country->code) }} me-3 fs-3"></span>
                <h2 class="h4 mb-0 fw-bold">{{ $country->name }} ({{ $country->code }})</h2>
                <span class="badge bg-secondary ms-auto">{{ $country->athletes->count() }} Atleti</span>
            </div>

            <div class="row g-3">
                @foreach ($country->athletes as $athlete)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 bg-light">
                            <a href="{{route('athletes.show', $athlete)}}" class="text-decoration-none text-dark">
                              <div class="card-body p-3">
                                  <div class="d-flex align-items-center">
                                      <div class="rounded-circle bg-white border me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; overflow: hidden;">
                                          @if($athlete->image_path)
                                              <img src="{{ asset('storage/' . $athlete->image_path) }}" class="img-fluid" alt="Foto">
                                          @else
                                              <i class="bi bi-person-fill text-secondary fs-4"></i>
                                          @endif
                                      </div>
                                      <div>
                                          <h6 class="mb-0 fw-bold">{{ $athlete->first_name }} {{ $athlete->last_name }}</h6>
                                          <small class="text-muted">Data di Nascita: {{ \Carbon\Carbon::parse($athlete->birth_date)->format('d/m/Y') }}</small>
                                      </div>
                                  </div>
                                  <div class="mt-3 d-flex justify-content-end gap-2">
                                      <a href="{{ route('athletes.edit', $athlete->id) }}" class="btn btn-sm border"><i class="bi bi-pencil"></i></a>
                                      <button type="button" class="btn btn-sm border text-danger" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#deleteModal{{ $athlete->id }}">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </div>
                              </div>
                            </a>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal{{ $athlete->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $athlete->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $athlete->id }}">Conferma Eliminazione</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    Sei sicuro di voler eliminare l'atleta <span class="fw-bold text-danger">{{ $athlete->first_name }} {{ $athlete->last_name }}</span>? 
                                    Tutti i dati associati verranno rimossi definitivamente.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annulla</button>
                                    <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-center text-muted py-5">Nessun atleta registrato nel sistema</p>
    @endforelse
</div>
@endsection