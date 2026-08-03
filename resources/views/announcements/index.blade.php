@extends('layouts.app')
@section('title', 'Grupos de ensayo')
@section('content')
<div class="espacio">
  @if(session('success'))
  <div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 3000)"
    class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  @if($errors->any())
  <div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    class="alert alert-danger">
    <strong>No se pudo crear la publicación. Inténtalo nuevamente.</strong>
  </div>
  @endif
  <div class="mb-4">
    <h1 class="fs-1 mb-1">Grupos de ensayo</h1>
    <p class="text-muted">Aqui puedes encontrar castings, información de ensayos y más.</p>
    @auth
    @if(auth()->user()->rol === 'producer')
    <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#anadirPublicacion">
      Añadir publicación
    </button>

    <!-- Modal -->
    <div class="modal fade" id="anadirPublicacion" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fs-4" id="anadirPublicacionLabel">Nueva publicación</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{route('announcements.store')}}" method="post">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="createTitle" class="mb-2">Título</label>
                <input type="text" name="title" id="createTitle" class="form-control" value="{{ old('title') }}">
                @error('title')
                <div class="alert text-danger px-0 py-1">{{$message}}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="createContent" class="mb-2">Contenido:</label>
                <textarea rows="7" cols="50" name="content" id="createContent" class="form-control">{{ old('content') }}</textarea>
                @error('content')
                <div class="alert text-danger px-0 py-1">{{$message}}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="createExpires_at" class="mb-2">Disponible hasta:</label>
                <input type="date" name="expires_at" id="createExpires_at" class="form-control" value="{{ old('expires_at') }}"
                  min="{{ now()->format('Y-m-d') }}">
                <span class="mt-4"><small>Si no elijes una fecha límite, la publicación estará disponible durante <strong>30 días</strong> .</small></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Publicar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endif
    @endauth
  </div>

  @if($announcements->isEmpty())
  <div class="alert alert-warning text-center py-5">
    <i class="bi bi-chat-dots display-4 mb-3 d-block"></i>
    <h2 class="mb-0 mt-2">No hay anuncios disponibles en este momento.</h2>
  </div>
  @else

  <div class="mt-5">
    <fieldset class="p-3 border-1 rounded-3 position-relative">
      <h2 class="burbujaTitulo position-absolute top-0 start-50 translate-middle sec-form borde rounded-5">Publicaciones activas</h2>
      <div class="list-group p-3 pt-5">
        <div class="row" data-masonry='{"percentPosition": true }'>
          @foreach($announcements as $announcement)
          <div class="col-12 col-md-6">
            <div class="list-group-item p-3 border-1 shadow-sm mb-3 rounded-3">
              <div class="d-flex announcementHeader">
                <div class="flex-shrink-0 ">
                  @if(isset($announcement->productor->user->userIcon) && $announcement->productor->user->userIcon)
                  <img src="{{ asset('storage/imagenes/userIcon/' . $announcement->productor->user->userIcon) }}"
                    class="iconUserMini img-fluid rounded-circle" alt="Avatar de {{ $announcement->productor->user->name }}">
                  @else
                  <img src="{{ asset('storage/imagenes/default/userDefaultIcon.jpeg') }}"
                    class="iconUserMini img-fluid rounded-circle" alt="Avatar default de {{ $announcement->productor->user->name }}">
                  @endif
                </div>

                <div class="flex-grow-1 ms-3 d-flex justify-content-between align-items-center">
                  <h3 class="fs-6 mb-0 fw-bold">{{ $announcement->productor->name_group ?? $announcement->productor->user->name }}</h3>
                </div>
              </div>

              <div class="mt-3 pt-4 border-top border-light-subtle">
                <h4 class="fs-6 text-break mb-3 border-bottom-1">{{ $announcement->title }}</h4>
                <p class="mb-0 mt-2 text-secondary text-break">{!! nl2br(e($announcement->content), false) !!}</p>
              </div>

              <div class="mt-4 pt-3 border-top border-light-subtle">
                @if($announcement->expires_at)
                <small class="text-muted">
                  <i class="bi bi-calendar"></i>
                  hasta {{ $announcement->expires_at->format('d/m/Y') }}
                </small>
                @endif
              </div>

              @if(auth()->user()->rol === 'admin')

              <div class="my-1">
                <a href="{{ route('admin.profile.user', $announcement->productor->user->id) }}" class="btn btn-primary btnYellow btn-sm rounded-pill mt-4 me-1">Ver perfil</a>

                <button type="button" class="btn btn-primary btn-sm rounded-pill mt-4 me-1" data-bs-toggle="modal" data-bs-target="#editarPublicacion{{ $announcement->id }}">
                  Editar
                </button>

                <!-- Modal -->
                <div class="modal fade" id="editarPublicacion{{ $announcement->id }}" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title fs-4" id="editarPublicacion{{ $announcement->id }}Label">Editar</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form action="{{route('announcements.update',$announcement)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="title{{ $announcement->id }}" class="mb-2">Título</label>
                            <input type="text" name="title" id="title{{ $announcement->id }}" class="form-control" value="{{ old('title',$announcement->title) }}">
                            @error('title')
                            <div class="alert text-danger px-0 py-1">{{$message}}</div>
                            @enderror
                          </div>

                          <div class="mb-3">
                            <label for="content{{ $announcement->id }}" class="mb-2">Contenido:</label>
                            <textarea rows="7" cols="50" name="content" id="content{{ $announcement->id }}" class="form-control">{{ old('content',$announcement->content) }}</textarea>
                            @error('content')
                            <div class="alert text-danger px-0 py-1">{{$message}}</div>
                            @enderror
                          </div>

                          <div class="mb-3">
                            <label for="expires_at{{ $announcement->id }}" class="mb-2">Disponible hasta:</label>
                            <input type="date" name="expires_at" id="expires_at{{ $announcement->id }}" class="form-control" min="{{ now()->format('Y-m-d') }}"
                              value="{{ old('expires_at', optional($announcement->expires_at)->format('Y-m-d')) }}">
                            <span class="mt-4"><small>Si no elijes una fecha límite, la publicación estará disponible durante <strong>30 días</strong> .</small></span>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-4" data-bs-toggle="modal" data-bs-target="#eliminarPublicacion{{ $announcement->id }}" title="Eliminar cuenta">
                  Eliminar
                </button>

                <div class="modal fade" id="eliminarPublicacion{{ $announcement->id }}" role="dialog"
                  aria-modal="true" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                      <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center pb-5 px-5">
                        <div class="mb-3 text-danger">
                          <i class="bi bi-exclamation-circle display-3"></i>
                        </div>

                        <div>
                          <h3 class="fs-3 fw-bold mb-2">¿Estás seguro?</h3>
                          <p class="text-muted mb-4">Esta acción eliminará la publicación y no se puede deshacer.</p>

                          <form method="POST" action="{{ route('announcements.destroy',$announcement) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-primary mb-1 me-1" data-bs-dismiss="modal">Cancelar</button>
                            <button
                              class="btn btn-secondary mb-1" type="submit">
                              Eliminar
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </fieldset>
  </div>
  @endif
</div>
@endsection