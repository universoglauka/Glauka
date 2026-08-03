<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
  public function index()
  {
    $planes = Plan::all();

    return view('profile.subscription',  compact('planes'));
  }

  public function activarPremium(int $userId, string $paymentId)
  {
    if (Subscription::where('payment_id', $paymentId)->exists()) {
      return;
    }
    
    $user = User::findOrFail($userId);

    if ($user->rol == "producer") {
      $plan = Plan::where(
        'nombre',
        'Premium producer'
      )->firstOrFail();
    } else {
      $plan = Plan::where(
        'nombre',
        'Premium user'
      )->firstOrFail();
    }


    $subscription = Subscription::create([
      'user_id'    => $user->id,
      'plan_id'    => $plan->id,
      'payment_id' => $paymentId,
      'starts_at'  => now(),
      'expires_at' => now()->addMonth(),
    ]);

    $user->update([
      'plan_id' => $plan->id
    ]);

    SubscriptionPayment::create([
      'subscription_id' => $subscription->id,
      'payment_id'       => $paymentId,
      'amount'           => $plan->precio,
      'status'           => 'approved',
      'paid_at'          => now(),
    ]);
  }

  public function subscriptionTodos()
  {
    $subcriptions = Subscription::with([
      'user',
      'plan',
      'payments'  => function ($query) {
        $query->latest()->take(10);
      }
    ])->latest()->get();

    return view('admin.subcriptions', compact('subcriptions'));
  }

  public function subscriptionHistorial(Subscription $sub)
  {
    $sub->load(['user', 'plan']);

    $payments = $sub->payments()
      ->orderByDesc('paid_at')
      ->paginate(10);

    return view('admin.subscription-payment', compact('sub', 'payments'));
  }
}
