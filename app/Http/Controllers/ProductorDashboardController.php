<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketDetalle;
use App\Models\Performance;
use App\Models\ProductorStatistic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductorDashboardController extends Controller
{
  public function index()
  {
    $productor = $this->getProductor();
    $monthlyStats = $this->getMonthlyStats();
    $annualStats = $this->getAnnualStats();

    if (!$productor) {
      return redirect(route('admin.usuarios'));
    }

    $obrasIds = $productor->obras->pluck('id');

    $fechas = $this->getRangoMes();

    $totales = $this->getTotalesMes($obrasIds, $fechas);
    $recaudacionMes = $totales->total_recaudado;
    $ticketsMes = $totales->total_tickets;
    $topObras = $this->getTopObras($obrasIds, $fechas);

    $ventasPorClasificacion = $this->getVentasPorClasificacion($obrasIds, $fechas);

    $ventasPorClasificacion = $this->calcularPorcentajes($ventasPorClasificacion);

    $chartData = $this->getChartData($ventasPorClasificacion);

    return view('productor.dashboard', [
      'recaudacionMes' => $recaudacionMes,
      'ticketsMes' => $ticketsMes,
      'topObras' => $topObras,
      'ventasPorClasificacion' => $ventasPorClasificacion,
      'chartLabels' => $chartData['labels'],
      'chartValues' => $chartData['values'],
      'chartColors' => $chartData['colors'],
      'monthlyStats' => $monthlyStats,
      'annualStats' => $annualStats,
    ]);
  }


  // Estadistica mensual
  private function getMonthlyStats()
  {
    return ProductorStatistic::where('user_id', Auth::id())
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->get();
  }

  // Estadistica anual
  private function getAnnualStats()
  {
    return ProductorStatistic::where('user_id', Auth::id())
      ->select(
        'year',
        DB::raw('SUM(total_revenue) as revenue'),
        DB::raw('SUM(total_tickets) as tickets')
      )
      ->groupBy('year')
      ->orderBy('year', 'desc')
      ->get();
  }


  private function getProductor()
  {
    return Auth::user()->productor;
  }

  //  Obtiene el rango de fechas del mes actual pra poder usarlo en las estadísticas del dashboard.
  private function getRangoMes()
  {
    return [
      'inicio' => Carbon::now()->startOfMonth(),
      'fin' => Carbon::now()->endOfMonth(),
    ];
  }

  // Obtiene la recaudación y cantidad de entradas vendidas durante el mes
  private function getTotalesMes($obrasIds, $fechas)
  {
    return TicketDetalle::whereIn('obra_id', $obrasIds)
      ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
      ->selectRaw('SUM(subtotal) as total_recaudado, SUM(cantidad) as total_tickets')
      ->first();
  }

  // Obtiene las cuatro obras que mas ventas tuvieron
  private function getTopObras($obrasIds, $fechas)
  {
    return TicketDetalle::whereIn('obra_id', $obrasIds)
      ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
      ->select(
        'obra_id',
        DB::raw('SUM(cantidad) as total_tickets'),
        DB::raw('SUM(subtotal) as total_recaudado')
      )
      ->groupBy('obra_id')
      ->orderBy('total_tickets', 'desc')
      ->take(4)
      ->with('obra')
      ->get();
  }

  // Obtiene las recaudacion mensual por clasificación de obras
  private function getVentasPorClasificacion($obrasIds, $fechas)
  {
    return TicketDetalle::whereIn('obra_id', $obrasIds)
      ->whereBetween('ticketdetalles.created_at', [$fechas['inicio'], $fechas['fin']])
      ->join('obras', 'ticketdetalles.obra_id', '=', 'obras.id')
      ->select(
        'obras.clasificacion as name',
        DB::raw('SUM(ticketdetalles.subtotal) as total')
      )
      ->groupBy('obras.clasificacion')
      ->get();
  }

  // Calcula el porcentaje de cada clasificación sobre el total de ventas del mes
  private function calcularPorcentajes($ventasPorClasificacion)
  {
    $totalGeneral = $ventasPorClasificacion->sum('total');

    $ventasPorClasificacion->transform(function ($item) use ($totalGeneral) {

      $item->percentage = $totalGeneral > 0
        ? round(($item->total / $totalGeneral) * 100, 2)
        : 0;
      return $item;
    });

    return $ventasPorClasificacion;
  }

  // Prepara los datos para el gráfico de las ventas por clasificación
  private function getChartData($ventasPorClasificacion)
  {
    return [
      'labels' => $ventasPorClasificacion->pluck('name'),
      'values' => $ventasPorClasificacion->pluck('total'),
      'colors' => ['#694686', '#edd1ff', '#ac84ca', '#6c757d'],
    ];
  }
}
