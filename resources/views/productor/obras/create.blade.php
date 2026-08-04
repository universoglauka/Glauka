@extends('layouts.app')
@section('content')
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
    <h1 class="fs-1">Subir una obra</h1>
  </div>
  <p>Llená todos los espacios para una mejor experiencia tanto para ustedes y como para los usuarios que deseen ver esta obra.</p>

  <form action="{{route('obras.store')}}" method="post" enctype="multipart/form-data">
    @csrf
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
        <h2 class="burbujaTitulo position-absolute top-0 start-50 translate-middle sec-form borde rounded-5">Fechas y
          horario </h2>
        <div class="row mt-3">
          <h3 class="fw-bold mt-3">Fecha 1</h3>
          <div class="row my-2 p-0">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra1" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra1" id="fechaObra1" class="form-control" value="{{ old('fechaObra1') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra1')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra1" class="mb-2">Horario</label>
              <input type="time" name="horaObra1" id="horaObra1" class="form-control" value="{{ old('horaObra1') }}">
              @error('horaObra1')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra1" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra1" id="stockEntradasObra1" class="form-control" value="{{ old('stockEntradasObra1') }}">
              @error('stockEntradasObra1')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual1" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual1">

                <label for="funcionVirtual1" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual1">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual1" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual1" id="linkVirtual1" class="form-control" value="{{ old('linkVirtual1') }}">
                    @error('linkVirtual1')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row pt-3">
          <span class="fw-bold mt-3">Fecha 2 (opcional)</span>

          <div class="row my-2 p-0">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra2" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra2" id="fechaObra2" class="form-control" value="{{ old('fechaObra2') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra2')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra2" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra2" id="horaObra2" class="form-control" value="{{ old('horaObra2') }}">
              @error('horaObra2')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra2" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra2" id="stockEntradasObra2" class="form-control" value="{{ old('stockEntradasObra2') }}">
              @error('stockEntradasObra2')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual2" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual2">

                <label for="funcionVirtual2" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual2">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual2" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual2" id="linkVirtual2" class="form-control" value="{{ old('linkVirtual2') }}">
                    @error('linkVirtual2')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row pt-3">
          <span class="fw-bold mt-3">Fecha 3 (opcional)</span>

          <div class="row my-2 p-0">
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra3" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra3" id="fechaObra3" class="form-control" value="{{ old('fechaObra3') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra3')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra3" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra3" id="horaObra3" class="form-control" value="{{ old('horaObra3') }}">
              @error('horaObra3')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra3" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra3" id="stockEntradasObra3" class="form-control" value="{{ old('stockEntradasObra3') }}">
              @error('stockEntradasObra3')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual3" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual3">

                <label for="funcionVirtual3" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual3">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual3" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual3" id="linkVirtual3" class="form-control" value="{{ old('linkVirtual3') }}">
                    @error('linkVirtual3')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
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
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra4" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra4" id="fechaObra4" class="form-control" value="{{ old('fechaObra4') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra4" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra4" id="horaObra4" class="form-control" value="{{ old('horaObra4') }}">
              @error('horaObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra4" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra4" id="stockEntradasObra4" class="form-control" value="{{ old('stockEntradasObra4') }}">
              @error('stockEntradasObra4')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual4" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual4">

                <label for="funcionVirtual4" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual4">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual4" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual4" id="linkVirtual4" class="form-control" value="{{ old('linkVirtual4') }}">
                    @error('linkVirtual4')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
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
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra5" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra5" id="fechaObra5" class="form-control" value="{{ old('fechaObra5') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra5" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra5" id="horaObra5" class="form-control" value="{{ old('horaObra5') }}">
              @error('horaObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra5" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra5" id="stockEntradasObra5" class="form-control" value="{{ old('stockEntradasObra5') }}">
              @error('stockEntradasObra5')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual5" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual5">

                <label for="funcionVirtual5" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual5">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual5" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual5" id="linkVirtual5" class="form-control" value="{{ old('linkVirtual5') }}">
                    @error('linkVirtual5')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
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
            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="fechaObra6" class="mb-2">Día que se realiza</label>
              <input type="date" name="fechaObra6" id="fechaObra6" class="form-control" value="{{ old('fechaObra6') }}"
                min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}">
              @error('fechaObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="horaObra6" class="mb-2">Horario en que se realiza</label>
              <input type="time" name="horaObra6" id="horaObra6" class="form-control" value="{{ old('horaObra6') }}">
              @error('horaObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3">
              <label for="stockEntradasObra6" class="mb-2">Cantidad de entradas</label>
              <input type="number" name="stockEntradasObra6" id="stockEntradasObra6" class="form-control" value="{{ old('stockEntradasObra6') }}">
              @error('stockEntradasObra6')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>

            <div class="mt-1">
              <div class="form-check form-switch">
                <input id="funcionVirtual6" class="form-check-input" type="checkbox"
                  data-bs-toggle="collapse"
                  data-bs-target="#virtual6">

                <label for="funcionVirtual6" class="form-check-label">
                  Función virtual
                </label>
              </div>

              <div class="collapse" id="virtual6">
                <div class="mt-3 row">
                  <div class="col-12 col-md-4 col-lg-4 mt-1 mb-3 p-0">
                    <label for="linkVirtual6" class="mb-2">Link de acceso</label>
                    <input type="text" name="linkVirtual6" id="linkVirtual6" class="form-control" value="{{ old('linkVirtual6') }}">
                    @error('linkVirtual6')
                    <div class="alert text-danger px-0 py-3">{{$message}}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        @endif

        <div class="mt-5 px-3">
          <div class="mt-5">
            <input type="checkbox" name="solo_compartido" id="solo_compartido">
            <label for="solo_compartido">Obra privada</label>
          </div>
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
            <input type="text" name="nombre_obra" id="nombre_obra" class="form-control" value="{{ old('nombre_obra') }}">
            @error('nombre_obra')
            <div class="alert text-danger px-0 py-3">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="precio" class="mb-2">Precio</label>
            <span>
              $<input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio') }}">
              @error('precio')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </span>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="ubicacion" class="mb-2">Ubicación o plataforma virtual</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
            @error('ubicacion')
            <div class="alert text-danger px-0 py-3">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-lg-6 my-3">
            <label for="sinopsis" class="mb-2">Sinopsis</label>
            <textarea rows="6" cols="50" name="sinopsis" id="sinopsis" class="form-control">{{ old('sinopsis') }}</textarea>
            @error('sinopsis')
            <div class="alert text-danger px-0 py-3">{{$message}}</div>
            @enderror
          </div>

          <div class="col-12 col-lg-6 genero my-3">
            <span>Géneros</span>
            <div class="row mt-2">
              @foreach($genres as $genre)

              <div class="col-12 col-md-4 col-lg-6 mb-3 p-0">
                <input type="checkbox" name="genres[]" value="{{ $genre->id }}" id="genre_{{ $genre->id }}" {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                <label for="genre_{{ $genre->id }}">
                  {{ $genre->name }}
                </label>

              </div>
              @endforeach

              @error('genres')
              <div class="alert text-danger px-0 py-3">{{$message}}</div>
              @enderror
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="clasificacion" class="mb-2">Clasificación</label>
            <select name="clasificacion" id="clasificacion" class="form-control">
              <option value="todo publico" @selected(old('clasificacion')=='todo publico' )>Todo público</option>
              <option value="adultos" @selected(old('clasificacion')=='adultos' )>adultos</option>
              <option value="infantil" @selected(old('clasificacion')=='infantil' )>infantil</option>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-4 my-3">
            <label for="autor" class="mb-2">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" value="{{ old('autor') }}">
            @error('autor')
            <div class="alert text-danger px-0 py-3">{{$message}}</div>
            @enderror
            <small class="info">*Este campo es opcional</small>
          </div>

          <div class="col-12 col-md-4 col-lg-4 my-3">
            <label for="imagen" class="mb-2">Imagen de la obra</label>
            <input type="file" name="imagen" id="imagen" class="form-control p-2">
            @error('imagen')
            <div class="alert text-danger px-0 py-3">{{$message}}</div>
            @enderror
            <small class="info">*Este campo es opcional</small>
          </div>

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
          <input type="hidden" id="members-old" value='@json(old("members", []))'>

          @foreach($labels as $label)
          <div class="col-12 col-md-4 col-lg-4 my-3">

            <p class="mb-2">{{ $label->name }}</p>

            <div id="label-{{ $label->id }}">
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary agregar-miembro" data-label="{{ $label->id }}">
              Agregar {{ strtolower($label->name) }}
            </button>
          </div>
          @endforeach
        </div>
      </fieldset>
    </div>

    <div class="mt-5">
      <fieldset class="p-3 pt-4 borde rounded-3 position-relative">
        <h2 class="position-absolute top-0 start-50 translate-middle sec-form borde rounded-5 ">
          Adaptaciones
        </h2>

        <div class="row mt-3 pb-3">
          @foreach($adaptations as $adaptation)
          <div class="col-12 col-md-4 col-lg-4 mt-3">
            <label for="adaptation_{{ $adaptation->id }}" class="me-2">
              <input type="checkbox" name="adaptations[]"
                value="{{ $adaptation->id }}" id="adaptation_{{ $adaptation->id }}"
                {{ in_array($adaptation->id, old('adaptations', [])) ? 'checked' : '' }}>{{ ($adaptation->name) }}</label>
          </div>
          @endforeach

          @error('adaptations')
          <div class="alert text-danger px-0 py-3">{{$message}}</div>
          @enderror
        </div>
      </fieldset>
      <span class="info">*Marcá únicamente las adaptaciones disponibles para personas con discapacidad en tu obra o en el espacio donde se presenta</span>
    </div>

    <div class="mt-5">
      <div class="row mb-4 mt-4">
        <button type="submit" class="btnCreate text-center btn borde rounded-5 m-auto">Subir obra</button>
      </div>
    </div>
  </form>
</section>
@endsection
