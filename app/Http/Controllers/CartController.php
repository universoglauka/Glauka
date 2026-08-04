<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Carts;
use App\Models\Obra;
use App\Models\Performance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index()
  {
    // mostrar el carrito desde la base de datos
    $carrito = Carts::firstOrCreate(['user_id' => Auth::id()]);
    $carrito->load('items.obra', 'items.performance');
    return view('cart.index', compact('carrito'));
  }

  public function agregar(Request $request, $id)
  {
    $obra = Obra::findOrFail($id);

    $performanceId = $request->input('performance_id');
    $performance = Performance::findOrFail($performanceId);

    $cantidad = (int) $request->input('cantidad_entradas', 1);
    
    $emails = $request->input('emails_virtuales', []);

    $stock = $performance->stock;

    if ($stock < $cantidad) {
      return redirect()->back()->with('error', "Stock insuficiente. Solo quedan {$stock} entradas para esa función.");
    }

    if ($request->filled('cart_item_id')) {

      $item = CartItems::findOrFail($request->cart_item_id);

      if ($item->cart->user_id != Auth::id()) {
        abort(403);
      }

      $item->update([
        'performance_id'   => $performance->id,
        'cantidad'         => $cantidad,
        'emails_virtuales' => $emails,
        'stock_alert_sent' => false,
      ]);

      return redirect()
        ->route('cart.index')
        ->with('success', 'Entradas actualizadas.');
    }

    $carrito = Carts::firstOrCreate(['user_id' => Auth::id()]);

    $item = CartItems::where('cart_id', $carrito->id)->where('performance_id', $performance->id)->first();

    if ($item) {
      $nuevaCantidad = $item->cantidad + $cantidad;

      if ($nuevaCantidad > $stock) {
        return redirect()->back()->with('error', "Stock insuficiente. Solo quedan {$stock} entradas para esa función.");
      }

      $emailsActuales = $item->emails_virtuales ?? [];

      $item->update([
        'cantidad' => $nuevaCantidad,
        'emails_virtuales' => array_merge($emailsActuales, $emails),
        'stock_alert_sent' => false,
      ]);
    } else {
      CartItems::create([
        'cart_id' => $carrito->id,
        'obra_id' => $obra->id,
        'performance_id' => $performance->id,
        'cantidad' => $cantidad,
        'emails_virtuales' => $emails,
      ]);
    }
    
    return redirect()->back()->with('success', "¡{$cantidad} entradas para '{$obra->nombre_obra}' añadidas al carrito!");
  }

  public function eliminar($id)
  {

    $item = CartItems::findOrFail($id);

    if ($item->cart->user_id != Auth::id()) {
      abort(403);
    }

    $item->delete();
  
    return redirect()->route('cart.index')->with('success', 'Entrada eliminada exitosamente.');
  }

  public function sumar($id)
  {

    $item = CartItems::findOrFail($id);

    if ($item->cart->user_id != Auth::id()) {
      abort(403);
    }

    $performance = Performance::find($item->performance_id);

    if ($item->cantidad < $performance->stock) {
      $item->update([
        'cantidad' => $item->cantidad + 1,
        'stock_alert_sent' => false,
      ]);
     
    }

    return redirect()->route('cart.index');
  }

  public function restar($id)
  {
    $item = CartItems::findOrFail($id);

    if ($item->cantidad > 1) {
      $item->update([
        'cantidad' => $item->cantidad - 1,
        'stock_alert_sent' => false,
      ]);
    } else {
      $item->delete();
    }

    return redirect()->route('cart.index');
  }

  // Posiblemente eliminar esta funcion
  public function preference()
  {
    $carrito = Carts::firstOrCreate(['user_id' => Auth::id()]);
    $carrito->load('items.obra', 'items.performance');

    if ($carrito->items->isEmpty()) {
      return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
    }

    return view('cart.preference', compact('carrito'));
  }
  
  public function vaciar()
  {
    $carrito = Carts::where('user_id', Auth::id())->first();

    if ($carrito) {
      $carrito->items()->delete();
    }
    return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
  }
}
