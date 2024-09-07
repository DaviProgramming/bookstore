@extends('./template')


@section('pagina', 'Login')

@section('head-content')

@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/main.scss', 'resources/js/loginScript.js'])

@endsection

@section('main-content')


@include('./components/nav')


<section class="container-fluid auth-pages">


    <div class="auth-pages-form">
        <div class="auth-pages-form-title">Login</div>
        <div class="auth-pages-form-content">
            <div class="auth-pages-form-content-input-group">
                <label for="email-login-input">Email</label>
                <input type="text" name="email-login-input">
            </div>
            <span class="auth-pages-form-content-input-error email"><i class="fa-solid fa-circle-exclamation"></i> <span>Email inválido</span></span>
            <div class="auth-pages-form-content-input-group">
                <label for="senha-login-input">Senha</label>
                <input type="text" name="senha-login-input">
                <div class="auth-pages-form-content-input-group-eyes">
                    <i class="fa-solid fa-eye"></i>
                    <i class="fa-solid fa-eye-slash active"></i>
                </div>
            </div>
            <span class="auth-pages-form-content-input-error password"><i class="fa-solid fa-circle-exclamation"></i> <span>Senha inválida</span></span>
        </div>
        <div class="auth-pages-form-redirect">
            <a href="{{route('pagina.cadastro')}}">Cadastre-se</a>
        </div>
        <button type="button" name="button-login"><span>Entrar</span></button>
    </div>


</section>


@endsection





