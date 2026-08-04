@extends('layouts.app')
@section('content')
@php
$funciones = $obra->performance->sortBy('id')->values();
$f1 = $funciones->get(0);
$f2 = $funciones->get(1);
$f3 = $funciones->get(2);
$f4 = $funciones->get(3);
$f5 = $funciones->get(4);
$f6 = $funciones->get(5);

@endphp
<section class="espacio">
  <div class="d-flex align-items-center mb-4 ml-2">
    <div class="d-flex justify-content-between align-items-center me-3" style="height: 4rem;">
      <div class="d-flex align-items-center">
        <div class="d-none d-sm-flex">
          <a href="{{ url()->previous() }}" class="volverBtn text-decoration-none">
            <i class="bi bi-arrow-left-circle-fill fs-2"></i>
          </a>
        </div>
      </div>
    </div>
    <h1 class="fs-1">Editar una obra</h1>
  </div>
  <p>Llená todos los espacios para una mejor experiencia para ustedes y los usuarios al encontrar su obra.</p>

  <form action="{{route('obras.update', $obra)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if(auth()->user()->rol === "admin")
    <p>A nombre de..</p>
    <select name="productor_id" class="form-control">
      @foreach($productores as $productor)
      <option value="{{$productor->id}}">
        {{$productor->user->name}}
      </option>
      @endforeach
    </select>
    @endif
    <div class="mt-5">
      <fieldset class="p-3 borde rounded-3 position-relative obra-entradas">
        <h2 class="burbujaTitulo position-absolute top-0 start-50 translate-middle sec-form borde rounded-5 ">Fechas y
          horario </h2>
        <div class="row mt-3">
          <p>Puedes añadir funciones nuevas a la obra, pero no puedes editar los horarios y fechas de las funciones que ya tenía.</p>
          <h3 class="fw-bold mt-3">Fecha 1</h3>
          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id1" value="{{ $f1?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra1" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra1" id="fechaObra1" class="form-control"
                value="{{ old('fechaObra1', $f1 ? \Carbon\Carbon::parse($f1->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f1) readonly @endif>
              @error('fechaObra1')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra1" class="mb-2">Horario</label>
              <input type="time" name="horaObra1" id="horaObra1" class="form-control" value="{{ old('horaObra1', $f1 ? $f1->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f1) readonly @endif>
              @error('horaObra1')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra1" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra1" id="stockEntradasObra1" class="form-control" value="{{ old('stockEntradasObra1', $f1 ? $f1->stock : '') }}">
              @error('stockEntradasObra1')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual1" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual1"
                  {{ old('linkVirtual1', $f1?->linkVirtual) ? 'checked' : '' }}>

                <label for="funcionVirtual1" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse {{ old('linkVirtual1', $f1?->linkVirtual) ? 'show' : '' }}" id="virtual1">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual1" class="mb-2">Link de acceso</label>

                    <input type="text" name="linkVirtual1" id="linkVirtual1" class="form-control" value="{{ old('linkVirtual1', $f1?->linkVirtual) }}">

                    @error('linkVirtual1')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <span class="fw-bold mt-3">Fecha 2 (opcional)</span>
          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id2" value="{{ $f2?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra2" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra2" id="fechaObra2" class="form-control" value="{{ old('fechaObra2', $f2 ? \Carbon\Carbon::parse($f2->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f2) readonly @endif>
              @error('fechaObra2')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra2" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra2" id="horaObra2" class="form-control" value="{{ old('horaObra2', $f2 ? $f2->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f2) readonly @endif>
              @error('horaObra2')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra2" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra2" id="stockEntradasObra2" class="form-control" value="{{ old('stockEntradasObra2', $f2 ? $f2->stock : '') }}">
              @error('stockEntradasObra2')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual2" class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#virtual2"
                  {{ old('linkVirtual2', $f2?->linkVirtual) ? 'checked' : '' }}>

                <label for="funcionVirtual2" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse {{ old('linkVirtual2', $f2?->linkVirtual) ? 'show' : '' }}"
                id="virtual2">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual2" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual2" id="linkVirtual2" class="form-control" value="{{ old('linkVirtual2', $f2?->linkVirtual) }}">

                    @error('linkVirtual2')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <span class="fw-bold mt-3">Fecha 3 (opcional)</span>

          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id3" value="{{ $f3?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra3" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra3" id="fechaObra3" class="form-control" value="{{ old('fechaObra3', $f3 ? \Carbon\Carbon::parse($f3->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f3) readonly @endif>
              @error('fechaObra3')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra3" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra3" id="horaObra3" class="form-control" value="{{ old('horaObra3', $f3 ? $f3->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f3) readonly @endif>
              @error('horaObra3')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra3" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra3" id="stockEntradasObra3" class="form-control" value="{{ old('stockEntradasObra3', $f3 ? $f3->stock : '') }}">
              @error('stockEntradasObra3')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual3" class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#virtual3"
                  {{ old('linkVirtual3', $f3?->linkVirtual) ? 'checked' : '' }}>
                <label for="funcionVirtual3" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div
                class="collapse {{ old('linkVirtual3', $f3?->linkVirtual) ? 'show' : '' }}"
                id="virtual3">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual3" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual3" id="linkVirtual3" class="form-control" value="{{ old('linkVirtual3', $f3?->linkVirtual) }}">

                    @error('linkVirtual3')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        @if(auth()->user()->plan_id === 4 || auth()->user()->plan_id === 1)
        <div class="row pt-3">
          <span class="fw-bold mt-3">Fecha 4 (opcional)</span>
          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id4" value="{{ $f4?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra4" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra4" id="fechaObra4" class="form-control" value="{{ old('fechaObra4', $f4 ? \Carbon\Carbon::parse($f4->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f4) readonly @endif
              >
              @error('fechaObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra4" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra4" id="horaObra4" class="form-control" value="{{ old('horaObra4', $f4 ? $f4->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f4) readonly @endif>
              @error('horaObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra4" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra4" id="stockEntradasObra4" class="form-control" value="{{ old('stockEntradasObra4', $f4 ? $f4->stock : '') }}">
              @error('stockEntradasObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual4" class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#virtual4"
                  {{ old('linkVirtual4', $f4?->linkVirtual) ? 'checked' : '' }}>
                <label for="funcionVirtual4" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div
                class="collapse {{ old('linkVirtual4', $f4?->linkVirtual) ? 'show' : '' }}"
                id="virtual4">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual4" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual4" id="linkVirtual4" class="form-control" value="{{ old('linkVirtual4', $f4?->linkVirtual) }}">
                    @error('linkVirtual4')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row pt-3">
          <span class="fw-bold mt-3">Fecha 5 (opcional)</span>
          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id5" value="{{ $f5?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra5" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra5" id="fechaObra5" class="form-control" value="{{ old('fechaObra5', $f5 ? \Carbon\Carbon::parse($f5->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f5) readonly @endif>
              @error('fechaObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra5" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra5" id="horaObra5" class="form-control" value="{{ old('horaObra5', $f5 ? $f5->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f5) readonly @endif>
              @error('horaObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra5" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra5" id="stockEntradasObra5" class="form-control" value="{{ old('stockEntradasObra5', $f5 ? $f5->stock : '') }}">
              @error('stockEntradasObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual5" class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#virtual5"
                  {{ old('linkVirtual5', $f5?->linkVirtual) ? 'checked' : '' }}>

                <label for="funcionVirtual5" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div
                class="collapse {{ old('linkVirtual5', $f5?->linkVirtual) ? 'show' : '' }}"
                id="virtual5">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual5" class="mb-2">Link de acceso</label>

                    <input id="linkVirtual5" type="text" name="linkVirtual5" class="form-control" value="{{ old('linkVirtual5', $f5?->linkVirtual) }}">

                    @error('linkVirtual5')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row pt-3">
          <span class="fw-bold mt-3">Fecha 6 (opcional)</span>
          <div class="row my-2 p-0">
            <input type="hidden" name="performance_id6" value="{{ $f6?->id }}">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra6" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra6" id="fechaObra6" class="form-control" value="{{ old('fechaObra6', $f6 ? \Carbon\Carbon::parse($f6->fechaObra)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                @if(auth()->user()->rol !== 'admin' && $f6) readonly @endif>
              @error('fechaObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra6" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra6" id="horaObra6" class="form-control" value="{{ old('horaObra6', $f6 ? $f6->horaObra : '') }}"
                @if(auth()->user()->rol !== 'admin' && $f6) readonly @endif>
              @error('horaObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra6" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra6" id="stockEntradasObra6" class="form-control" value="{{ old('stockEntradasObra6', $f6 ? $f6->stock : '') }}">
              @error('stockEntradasObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual6" class="form-check-input" type="checkbox" data-bs-toggle="collapse" data-bs-target="#virtual6"
                  {{ old('linkVirtual6', $f6?->linkVirtual) ? 'checked' : '' }}>

                <label for="funcionVirtual6" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div
                class="collapse {{ old('linkVirtual6', $f6?->linkVirtual) ? 'show' : '' }}"
                id="virtual6">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual6" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual6" id="linkVirtual6" class="form-control" value="{{ old('linkVirtual6', $f6?->linkVirtual) }}">

                    @error('linkVirtual6')
                    <div class="alert text-danger px-0 py-3">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        @endif
        <div class="mt-5">
          <input type="checkbox" name="solo_compartido" id="solo_compartido"
            {{ $obra->solo_compartido ? 'checked' : '' }}>
          <label for="solo_compartido">Obra privada</label>
        </div>

      </fieldset>
    </div>




    <div class="mt-5">
      <fieldset class="p-3 borde rounded-3 position-relative">
        <h2 class="position-absolute top-0 start-50 translate-middle sec-form borde rounded-5 ">Detalle
        </h2>
        <div class="row py-3">
          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="nombre_obra" class="mb-2">Nombre de la obra</label>
            <input type="text" name="nombre_obra" id="nombre_obra" class="form-control" value="{{ old('nombre_obra', $obra->nombre_obra) }}">
            @error('nombre_obra')
            <div class="alert text-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="precio" class="mb-2">Precio</label>
            <span>
              $<input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio', $obra->precio) }}">
              @error('precio')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </span>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="ubicacion" class="mb-2">Ubicación o plataforma virtual</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion', $obra->ubicacion) }}">
            @error('ubicacion')
            <div class="alert text-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-lg-6 my-3">
            <label for="sinopsis" class="mb-2">Sinopsis</label>
            <textarea rows="6" cols="50" name="sinopsis" id="sinopsis" class="form-control">{{ old('sinopsis', $obra->sinopsis) }}</textarea>
            @error('sinopsis')
            <div class="alert text-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-lg-6 genero my-3">
            <span>Géneros</span>
            <div class="row mt-2">
              @foreach($genres as $genre)
              <div class="col-12 col-md-4 col-lg-6 mb-3 p-0">
                <input type="checkbox" name="genres[]" value="{{ $genre->id }}" id="genre_{{ $genre->id }}" {{ (isset($obra) && $obra->genres->contains($genre->id)) ? 'checked' : '' }}>
                <label for="genre_{{ $genre->id }}">
                  {{ $genre->name }}
                </label>
              </div>
              @endforeach

              @error('genres')
              <div class="alert text-danger">{{$message}}</div>
              @enderror
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="clasificacion" class="mb-2">Clasificación</label>
            <select name="clasificacion" id="clasificacion" class="form-control">
              <option value="todo publico" @selected(old('clasificacion', $obra->clasificacion) =='todo público' )>Todo público</option>
              <option value="adultos" @selected(old('clasificacion', $obra->clasificacion) =='adultos' )>adultos</option>
              <option value="infantil" @selected(old('clasificacion', $obra->clasificacion ) =='infantil' )>infantil</option>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="autor" class="mb-2">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" value="{{ old('autor', $obra->autor) }}">
            @error('autor')
            <div class="alert text-danger">{{$message}}</div>
            @enderror
            <small class="info">*Este campo es opcional</small>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="imagen" class="mb-2">Imagen de promoción</label>
            <input type="file" name="imagen" id="imagen" class="form-control p-2">
            @error('imagen')
            <div class="alert text-danger">{{$message}}</div>
            @enderror
            <small class="info">*Este campo es opcional</small>
          </div>


          @if($obra->imagen)
          <div class="col-12 col-md-6 col-lg-6 my-3">
            <p class="mb-3">Imagen actual</p>
            <img
              src="{{ asset('storage/imagenes/' . $obra->imagen) }}"
              alt="Imagen actual"
              class="imgEdit w-100 rounded">
          </div>
          @endif


        </div>
      </fieldset>
    </div>
    <div class="mt-5">
      <fieldset class="p-3 borde rounded-3 position-relative">
        <h2 class="position-absolute top-0 start-50 translate-middle sec-form borde rounded-5 ">
          Participantes
        </h2>

        <div class="row py-3">
          <small class="info">*Esta sección es opcional.</small>
          @php
          $members = old( 'members', $obra->membersProduction ->map(fn($m) => [
          'label_id' => $m->label_id,
          'name' => $m->name,
          ])->toArray());
          @endphp

          <input
            type="hidden"
            id="members-old"
            value='@json($members)'>
          @foreach($labels as $label)
          <div class="col-12 col-md-4 col-lg-4 my-3">

            <p>{{ $label->name }}</p>

            <div id="label-{{ $label->id }}">
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary agregar-miembro" data-label="{{ $label->id }}">
              Agregar {{ strtolower($label->name) }}
            </button>
          </div>
          @endforeach
        </div>
      </fieldset>
      <span class="info">*Este campo es opcional.</span>
    </div>

    <div class="mt-5">
      <fieldset class="p-3 pt-4 borde rounded-3 position-relative">
        <h2 class="position-absolute top-0 start-50 translate-middle sec-form borde rounded-5 ">
          Adaptaciones
        </h2>

        <div class="row mt-3 pb-3">
          @foreach($adaptations as $adaptation)
          <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
            <label for="adaptation_{{ $adaptation->id }}">
              <input type="checkbox" name="adaptations[]"
                value="{{ $adaptation->id }}" id="adaptation_{{ $adaptation->id }}" {{ (isset($obra) && $obra->adaptations->contains($adaptation->id)) ? 'checked' : '' }}>{{ ($adaptation->name) }}</label>
          </div>
          @endforeach
        </div>
      </fieldset>
      <span class="info">*Marcá únicamente las adaptaciones disponibles en tu obra o en el espacio donde se presenta</span>
    </div>

    <div class="mt-5">
      <div class="row mb-4 mt-4">
        <button type="submit" class="btnCreate text-center btn borde rounded-5 m-auto">Actualizar obra</button>
      </div>
    </div>
  </form>
</section>
@endsection
