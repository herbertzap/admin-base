<x-layout bodyClass="bg-gray-200">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container mt-5">
                <div class="row signin-margin">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="shadow-primary border-radius-lg py-3 pe-1" style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%);">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Iniciar Sesión</h4>
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <i class="fas fa-shield-alt text-white text-lg" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #0f1b2a;">
                                <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                    @csrf
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label text-white">Correo Electrónico</label>
                                        <input type="email" class="form-control" name="email" value="" style="color: #ffffff; background-color: rgba(255,255,255,0.15); border: 1px solid rgba(231,80,52,0.5);" placeholder="correo@ejemplo.com">
                                    </div>
                                    @error('email')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label text-white">Contraseña</label>
                                        <input type="password" class="form-control" name="password" value='' style="color: #ffffff; background-color: rgba(255,255,255,0.15); border: 1px solid rgba(231,80,52,0.5);" placeholder="••••••••">
                                    </div>
                                    @error('password')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="form-check form-switch d-flex align-items-center my-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                        <label class="form-check-label mb-0 ms-2 text-white" for="rememberMe">Recordarme</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn w-100 my-4 mb-2" style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%); color: white; border: none;">Iniciar Sesión</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center text-white">
                                        ¿No tienes una cuenta?
                                        <a href="{{ route('register') }}"
                                            class="font-weight-bold" style="color: #e75034;">Registrarse</a>
                                    </p>
                                    <p class="text-sm text-center text-white">
                                        ¿Olvidaste tu contraseña? Restablece tu contraseña
                                        <a href="{{ route('verify') }}"
                                            class="font-weight-bold" style="color: #e75034;">aquí</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('components.footers.guest')
            </div>
        </div>
    </main>
    @push('css')
<style>
    /* Estilos para mejorar la visibilidad de los inputs en el login */
    .input-group input.form-control {
        color: #ffffff !important;
        background-color: rgba(255,255,255,0.15) !important;
        border: 1px solid rgba(231,80,52,0.5) !important;
        font-weight: 500 !important;
    }
    
    .input-group input.form-control:focus {
        color: #ffffff !important;
        background-color: rgba(255,255,255,0.2) !important;
        border: 1px solid #e75034 !important;
        box-shadow: 0 0 0 0.2rem rgba(231,80,52,0.25) !important;
    }
    
    .input-group input.form-control::placeholder {
        color: rgba(255,255,255,0.5) !important;
    }
    
    /* Asegurar que el autofill sea visible */
    .input-group input.form-control:-webkit-autofill,
    .input-group input.form-control:-webkit-autofill:hover,
    .input-group input.form-control:-webkit-autofill:focus {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px rgba(255,255,255,0.15) inset !important;
        transition: background-color 5000s ease-in-out 0s !important;
    }
    
    .input-group label.form-label {
        color: rgba(255,255,255,0.8) !important;
    }
</style>
@endpush
    @push('js')
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script>
    $(function() {

    var text_val = $(".input-group input").val();
    if (text_val === "") {
      $(".input-group").removeClass('is-filled');
    } else {
      $(".input-group").addClass('is-filled');
    }
});
</script>
@endpush
</x-layout>
