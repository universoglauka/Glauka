<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\Auth\ProductorRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProductorDashboardController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FavoriteController as ControllersFavoriteController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TicketEntryController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PaymentsProducerController;

Route::get('/', function () {
  return view('landing');
});

Route::get('/inicio', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/catalogo', [CatalogController::class, 'catalog'])->name('catalog');

Route::resource('/grupos-de-ensayo', AnnouncementController::class)->names('announcements')->parameters(['grupos-de-ensayo' => 'announcement',]);
Route::post('/webhook/mercadopago', [MercadoPagoController::class, 'webhook'])->name('webhook.mp');

Route::middleware('auth')->group(function () {
  Route::get('/perfil', [ProfileController::class, 'index'])->name('profile');
  Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');

  Route::patch('/perfil/editar', [ProfileController::class, 'update'])->name('profile.update');
  Route::patch('/perfil/editar/productor', [ProfileController::class, 'updateProducer'])->name('profile.producer.update');
  Route::delete('/perfil/eliminar', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::get('/perfil/producerPremium', [SubscriptionController::class, 'index'])->name('producerPremium');
  Route::post('/favoritos/{obra}', [ControllersFavoriteController::class, 'toggle'])->name('favorite.toggle');

  Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
  Route::post('/carrito/agregar/{id}', [CartController::class, 'agregar'])->name('cart.agregar');
  Route::get('/carrito/eliminar/{itemKey}', [CartController::class, 'eliminar'])->name('cart.eliminar');
  Route::get('/carrito/sumar/{itemKey}', [CartController::class, 'sumar'])->name('cart.sumar');
  Route::get('/carrito/restar/{itemKey}', [CartController::class, 'restar'])->name('cart.restar');
  Route::get('/carrito/vaciar', [CartController::class, 'vaciar'])->name('cart.vaciar');

  Route::get('/checkout/ticket', [MercadoPagoController::class, 'checkout'])->name('checkout.ticket');
  Route::get('/checkout/premium', [MercadoPagoController::class, 'checkoutPremium'])->name('checkout.premium');

  Route::get('/checkout', [MercadoPagoController::class, 'checkout'])->name('checkout');
  Route::get('/pagos/success', [MercadoPagoController::class, 'success'])->name('pagos.success');
  Route::get('/pagos/pending', [MercadoPagoController::class, 'pending'])->name('pagos.pending');
  Route::get('/pagos/failure', [MercadoPagoController::class, 'failure'])->name('pagos.failure');

  Route::resource('/obras', ObraController::class)->middleware(['productor'])->except(['show']);
  Route::get('/obras/{obra}', [ObraController::class, 'show'])->name('obras.show');
  Route::get('/obra/{slug}', [ObraController::class, 'showPrivado'])->name('obras.privadas.show');
  Route::patch('/obras/{obra}/cancel', [ObraController::class, 'cancel'])->middleware(['productor'])->name('obras.cancel');

  Route::patch('/performances/{performance}/cancel', [PerformanceController::class, 'cancel'])->name('performance.cancel');

  Route::get('/obra/listado/{performance}', [TicketEntryController::class, 'index'])->middleware(['productor'])->name('listado');
  Route::post('/ticket-entries/{entry}/checkin', [TicketEntryController::class, 'checkIn'])->name('ticket-entries.checkin');
  Route::post('/ticket-entries/{entry}/undo', [TicketEntryController::class, 'undo'])->name('ticket-entries.undo');

  Route::get('/dashboard', [ProductorDashboardController::class, 'index'])->middleware(['auth', 'productor'])->name('dashboard');
  Route::get('/preguntas-frecuentes', [QuestionsController::class, 'index'])->name('questions');
});

Route::middleware(['auth', 'admin'])->group(function () {
  Route::get('/admin/pagos-productores', [PaymentsProducerController::class, 'index'])->name('admin.producer-payment');
  Route::patch('/admin/pagos-productores/{performance}/estado', [PaymentsProducerController::class, 'changeStatus'])->name('admin.producer-payment.changeStatus');
  Route::patch('/admin/pagos-productores/{performance}/ocultar', [PaymentsProducerController::class, 'hide'])->name('admin.producer-payment.hide');

  Route::get('/admin/obras', [ObraController::class, 'obrasAll'])->name('admin.obras');
  Route::get('/admin/subscripciones', [SubscriptionController::class, 'subscriptionTodos'])->name('admin.subcriptions');
  Route::get('/admin/subscripciones/{sub}', [SubscriptionController::class, 'subscriptionHistorial'])->name('admin.subscription-payment');

  Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
  Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
  Route::delete('/genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');

  Route::get('/admin/usuarios', [UserController::class, 'usuariosTodos'])->name('admin.usuarios');
  Route::get('/admin/crear-usuario', [RegisteredUserController::class, 'create'])->name('admin.crear-usuario');
  Route::post('/admin/crear-usuario', [RegisteredUserController::class, 'store'])->name('admin.store-usuario');

  Route::post('/labels', [LabelController::class, 'store'])->name('labels.store');
  Route::put('/labels/{label}', [LabelController::class, 'update'])->name('labels.update');
  Route::delete('/labels/{label}', [LabelController::class, 'destroy'])->name('labels.destroy');

  Route::get('/admin/crear-productor', [ProductorRegisterController::class, 'create'])->name('admin.crear-productor');
  Route::post('/admin/crear-productor', [ProductorRegisterController::class, 'store'])->name('admin.store-productor');
  Route::get('/admin/productores', [ProductorController::class, 'productoresTodos'])->name('admin.productores');

  Route::get('/admin/{user}', [ProfileController::class, 'show'])->name('admin.profile.user');
  Route::get('/admin/editar/{user}', [ProfileController::class, 'editByAdmin'])->name('admin.profile.edit');
  Route::patch('/perfil/editar/productor/{user}', [ProfileController::class, 'updateProducerByAdmin'])->name('admin.profile.producer.update');
  Route::patch('/admin/editar/{user}', [ProfileController::class, 'updateByAdmin'])->name('admin.profile.update');
  Route::delete('/admin/usuario/{user}', [ProfileController::class, 'destroyByAdmin'])->name('admin.user.destroy');
});

require __DIR__ . '/auth.php';
