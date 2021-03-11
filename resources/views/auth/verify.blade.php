@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Su cuenta no esta verificada.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Le hemos vuelto a enviar otro email de verificación. Por favor revise su bandeja de correos.') }}
                        </div>
                    @endif

                   <p> {{ __('Por favor revise su email y haga click en el link para verificar su cuenta.') }}</p>
                    {{ __('Si no ha recibido ningun email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Haga click aqui y le enviaremos otro.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
