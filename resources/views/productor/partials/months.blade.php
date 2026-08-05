<div class="col-md-12">
  <div class="card shadow-sm border-0 py-2 rounded-3">
    <div class="card-header bg-white border-0">
      <h2 class="fs-2">Resumen de ventas mensuales</h2>
    </div>

    <div class="card-body">
      <div class="table-responsive d-flex align-items-center">
        <table class="table table-hover align-middle border-1">
          <thead>
            <tr>
              <th>Año</th>
              <th>Mes</th>
              <th>Tickets</th>
              <th>Recaudación</th>
            </tr>
          </thead>
          <tbody>
            @forelse($monthlyStats as $stat)
            <tr>
              <td data-label="Año"><strong>{{ $stat->year }}</strong></td>
              <td data-label="Mes">{{ $meses[$stat->month] ?? $stat->month }}</td>
              <td data-label="Tickets">{{ $stat->total_tickets }}</td>
              <td data-label="Recaudación">${{ number_format($stat->total_revenue, 2, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4"> No hay estadísticas disponibles.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
