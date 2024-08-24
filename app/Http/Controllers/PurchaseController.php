<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\User;

class PurchaseController extends Controller
{
    // Mostrar el formulario de pago
    public function show(Product $product)
    {
        return view('purchases.create', compact('product'));
    }

    // Procesar la compra
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'stripeToken' => 'required',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $product->price * 100, // Stripe utiliza centavos
                'currency' => 'usd',
                'description' => 'Compra del producto: ' . $product->name,
                'source' => $request->stripeToken,
                'metadata' => ['product_id' => $product->id],
            ]);

            // Guardar la compra en la base de datos
            Purchase::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'stripe_payment_id' => $charge->id,
                'amount' => $product->price,
            ]);

            return redirect()->route('products.index')->with('success', 'Compra realizada con éxito.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }

    // Listar todas las compras (para administradores)
    public function index()
    {
        $purchases = Purchase::with('product', 'user')->get();
        return view('purchases.index', compact('purchases'));
    }
    public function userPurchases($userId)
    {
        // Obtener el usuario
        $user = User::findOrFail($userId);

        // Obtener las compras del usuario
        $purchases = Purchase::where('user_id', $userId)->get();

        return view('purchases.user_purchases', compact('user', 'purchases'));
    }
}
