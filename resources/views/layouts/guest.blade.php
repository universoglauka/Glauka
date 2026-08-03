<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Glauka') }}</title>

  <link rel="shortcut icon" href="{{ asset('storage/imagenes/favicon.png') }}" type="image/x-icon">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <!-- Css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <nav>
    <div class="container-xl px-3 px-sm-4 px-lg-5">
      <div class="d-flex justify-content-between align-items-center" style="height: 4rem;">
        <div class="d-flex align-items-center">
          @if(auth()->check() && auth()->user()->rol === "admin")
          <div class="navigationLinks d-none d-sm-flex ms-sm-4">
            <a href="/admin/obras" class="text-decoration-none">
              <i class="bi bi-arrow-left-circle-fill fs-2"></i>
            </a>
          </div>
          @else
          <div class="navigationLinks d-none d-sm-flex ms-sm-4">
            <a href="/" class="text-decoration-none">
              <i class="bi bi-arrow-left-circle-fill fs-2"></i>
            </a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </nav>
  <main>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
      <div class="w-full sm:max-w-md px-6 py-5 overflow-hidden sm:rounded-lg">
        {{ $slot }}
      </div>
      <div>
        <a href="/">
          <x-application-logo class="w-25 fill-current" />
        </a>
      </div>
    </div>
  </main>
  <footer class="pt-4">
    <p class="text-white text-center"> Lara Florian y Mayra Yañez</p>
  </footer>
</body>

</html>