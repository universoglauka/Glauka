<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Ticket;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentRefundClient;


class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // Hacer reembolso total por MercadoPago
    public function refundTicket(Ticket $ticket, ?int $performanceId = null,  ?int $obraId = null)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        $client = new PaymentRefundClient();

        $refund = $client->refund($ticket->payment_id, $ticket->total);

        $this->guardarResultado($ticket, $refund, $ticket->total, $performanceId, $obraId);

        return $refund;
    }

    // Hacer reembolso parcial por MercadoPago
    public function refundPartial(Ticket $ticket, float $amount,  ?int $performanceId = null,  ?int $obraId = null)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        $client = new PaymentRefundClient();

        $refund = $client->refund($ticket->payment_id, $amount);

        $this->guardarResultado($ticket, $refund, $amount, $performanceId, $obraId);

        return $refund;
    }

    public function calcularMonto(Ticket $ticket, int $performanceId)
    {
        return $ticket->ticketdetalles->where('performance_id', $performanceId)->sum('subtotal');
    }

    public function guardarResultado(Ticket $ticket, $refund, float $amount, ?int $performanceId = null,  ?int $obraId = null)
    {
        Refund::create([
            'ticket_id'      => $ticket->id,
            'performance_id' => $performanceId,
            'obra_id'        => $obraId,
            'payment_id'     => $ticket->payment_id,
            'refund_id'      => $refund->id,
            'amount'         => $amount,
            'status'         => $refund->status,
            'reason'         => 'Cancelación',
            'refunded_at'    => now(),
        ]);
    }

    public function  processRefund(Ticket $ticket, int $performanceId)
    {
        $existe = Refund::where('ticket_id', $ticket->id)
            ->where('performance_id', $performanceId)
            ->exists();

        if ($existe) {
            return;
        }

        $monto = $this->calcularMonto($ticket, $performanceId);

        if ($monto >= $ticket->total) {
            return $this->refundTicket($ticket, $performanceId);
        }

        return $this->refundPartial($ticket, $monto, $performanceId);
    }

    public function processRefundObra(Ticket $ticket, int $obraId)
    {
        $existe = Refund::where('ticket_id', $ticket->id)
            ->where('obra_id', $obraId)
            ->exists();

        if ($existe) {
            return;
        }

        $monto = $ticket->ticketdetalles->where('obra_id', $obraId)->sum('subtotal');

        if ($monto >= $ticket->total) {
            return $this->refundTicket($ticket, null, $obraId);
        }

        return $this->refundPartial($ticket, $monto, null, $obraId);
    }
}
