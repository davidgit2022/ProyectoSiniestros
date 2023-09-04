@extends('layouts.guest')

@section('content')
<!-- Login -->
<div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
    <div class="w-px-400 mx-auto">
        <!-- Logo -->
        
        <!-- /Logo -->
        <h3 class="mb-1 fw-bold"> Entregas de talleres</h3>
        <p class="mb-4">Ingrese credenciales.</p>

        <form class="mb-3" action="{{ url('login') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input
                    type="text"
                    class="form-control @error('email') is-invalid @enderror @if ( Session::has('credentials') ) is-invalid @endif " id="email" name="email" autofocus />

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ( Session::has('credentials') )
                    <div class="invalid-feedback">
                        {{ Session::get('credentials') }}
                    </div>
                @endif

            </div>

            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Contraseña</label>
                    <a href="#" class="d-none">
                        <small>¿Has olvidado tu contraseña?</small>
                    </a>
                </div>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" />
                    <span class="input-group-text cursor-pointer d-none">
                        <i class="ti ti-eye-off"></i>
                    </span>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" />
                    <label class="form-check-label" for="remember"> Recordar </label>
                </div>
            </div>

            <button class="btn btn-primary d-grid w-100">Ingresar</button>
        </form>

    </div>
</div>
<!-- /Login -->
@endsection
