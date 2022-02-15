@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Falta pouco agora! Precisamos apenas que você valide seu e-mail.</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                           Enviamos para você um e-mail de validação.
                        </div>
                    @endif

                    Antes de acessar os recursos da aplicação, por favor valide seu e-mail. <br><br>
                    Se você não recebeu o e-mail,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">clique aqui para enviarmos outro.</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
