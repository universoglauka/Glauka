<div class="col-12 col-md-12 col-lg-6">
  <div class="card shadow-sm border-0 py-2 mb-3">
    <div class="card-header bg-white border-0">
      <h2 class="fs-2">Resumen de ventas</h2>
    </div>
    <div class="card-body">
      <div class="row d-flex justify-content-between">
        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="bg-resumen-r card-body">
              <h3 class="fs-6 text-muted text-uppercase small fw-bold mb-3">Recaudación</h3>
              <h4 class="fs-4 fw-bold mb-0">${{ number_format($recaudacionMes, 2, ',', '.') }}</h4>
              <p class="mt-2 small mb-0">Total de todas las obras</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
            <div class="bg-resumen-v card-body">
              <h3 class="fs-6 text-muted text-uppercase small fw-bold mb-3">Total de tickets vendidos</h3>
              <h4 class="fs-4 fw-bold mb-0">{{ number_format($ticketsMes) }}</h4>
              <p class="mt-2 text-muted small mb-0">Total de entradas emitidas este mes</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm border-0 py-2 mb-3">
    <div class="card-header bg-white border-0">
      <h2 class="fs-2">Top obras del mes</h2>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle border-1">
          <thead class="table-light">
            <tr>
              <th>Obra</th>
              <th class="text-center">Tickets vendidos</th>
              <th class="text-end">Total recaudado</th>
            </tr>
          </thead>
          <tbody>
            @forelse($topObras as $item)
            <tr>
              <td class="fw-bold">{{ $item->obra->nombre_obra }}</td>
              <td class="text-center">
                <span class="bg-tickets-dash badge rounded-pill">
                  {{ $item->total_tickets }}
                </span>
              </td>
              <td class="recaudado-dash text-end fw-bold">
                ${{ number_format($item->total_recaudado, 2, ',', '.') }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-center text-muted py-4">
                Aún no hay ventas registradas en este mes.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="col-12 col-md-12 col-lg-6">
  <div class="card shadow-sm border-0 py-2">
    <div class="card-header bg-white border-0">
      <h2 class="fs-2">Venta por clasificación</h2>
    </div>
    <div class="card-body p-4">
      <div class="chart-container" style="position: relative; height:250px;">
        <canvas id="categoryChart"
          data-labels="{{ json_encode($chartLabels) }}"
          data-values="{{ json_encode($chartValues) }}"
          data-colors="{{ json_encode($chartColors) }}">
        </canvas>
      </div>

      <div class="chart-legend mt-4">
        @forelse($ventasPorClasificacion as $index => $item)
        <div class="legend-item d-flex justify-content-between align-items-center mb-2">
          <div class="d-flex align-items-center">
            <div class="legend-dot chart-bg-{{ $index }}"></div>
            <div>
              <div class="fw-bold text-capitalize">{{ $item->name }}</div>
              <div class="text-muted small">${{ number_format($item->total, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="fw-bold">{{ number_format($item->percentage, 1) }}%
          </div>
        </div>
        @empty
        <p class="text-center text-muted small">Aún no hay datos disponibles</p>
        @endforelse
      </div>
    </div>
  </div>
</div>