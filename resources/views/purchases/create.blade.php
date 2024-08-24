@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Compra de Producto</h1>
    
    <h2>{{ $product->name }}</h2>
    <p>Precio: ${{ number_format($product->price, 2) }}</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store', $product->id) }}" method="POST" id="payment-form">
        @csrf
        <div class="form-group">
            <label for="card-element">Tarjeta de Crédito</label>
            <div id="card-element">
                <!-- Elemento de tarjeta de Stripe -->
            </div>
            <div id="card-errors" role="alert"></div>
        </div>

        <button class="btn btn-primary mt-3">Pagar ${{ number_format($product->price, 2) }}</button>
        <input type="hidden" name="stripeToken" id="stripeToken">
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                document.getElementById('stripeToken').value = result.token.id;
                form.submit();
            }
        });
    });
</script>
@endsection
