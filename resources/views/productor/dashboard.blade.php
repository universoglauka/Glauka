@php
$meses = [
1 => 'Enero',
2 => 'Febrero',
3 => 'Marzo',
4 => 'Abril',
5 => 'Mayo',
6 => 'Junio',
7 => 'Julio',
8 => 'Agosto',
9 => 'Septiembre',
10 => 'Octubre',
11 => 'Noviembre',
12 => 'Diciembre',
];
@endphp

@extends('layouts.app')

@section('content')
<div class="espacio">
  <div class="row">
    <div class="col-12 mb-4">
      <h1 class="fs-1">Hola, {{ auth()->user()->name }}!</h1>
      <p class="text-muted fs-5">Aquí puedes ver un resumen de tus ventas y estadísticas.</p>
    </div>

    <div>
      <ul id="profileTabs" role="tablist">
        <li class="btn btn-primary mb-1">
          <button
            class="nav-link active"
            id="mesActual-tab"
            data-bs-toggle="tab"
            data-bs-target="#mesActual"
            type="button"
            role="tab">
            Mes actual
          </button>
        </li>
        <li class="btn btn-primary mb-1">
          <button
            class="nav-link"
            id="mensual-tab"
            data-bs-toggle="tab"
            data-bs-target="#mensual"
            type="button"
            role="tab">
            Mensual
          </button>
        </li>
        <li class="btn btn-primary mb-1">
          <button
            class="nav-link"
            id="anual-tab"
            data-bs-toggle="tab"
            data-bs-target="#anual"
            type="button"
            role="tab">
            Anual
          </button>
        </li>
      </ul>

      <div class="pt-3 rounded-4">
        <div class="tab-content" id="profileTabsContent">
          <div class="tab-pane fade show active" id="mesActual" role="tabpanel">
            <div class="row">
              @include('productor.partials.current-month')
            </div>
          </div>

          <div class="tab-pane fade" id="mensual" role="tabpanel">
            <div class="row">
              @include('productor.partials.months')
            </div>
          </div>

          <div class="tab-pane fade" id="anual" role="tabpanel">
            <div class="row">
              @include('productor.partials.annual')
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('categoryChart');
    if (!canvas) return;

    try {
      let labels = JSON.parse(canvas.dataset.labels);
      let values = JSON.parse(canvas.dataset.values);
      let colors = JSON.parse(canvas.dataset.colors);

      if (values.length === 0 || values.every(v => v === 0)) {
        labels = ['Sin ventas'];
        values = [1];
        colors = ['#e9ecef'];
      }

      new Chart(canvas, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: values,
            backgroundColor: colors,
            borderWidth: 0,
            hoverOffset: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              enabled: values[0] !== 1 || labels[0] !== 'Sin ventas'
            }
          }
        }
      });
    } catch (e) {
      console.error("Error al obetener datos del gráfico:", e);
    }
  });
</script>
@endsection