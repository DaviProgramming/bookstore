@extends('./template')


@section('pagina', 'Login')

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
            <div class="auth-pages-form-content-input-group">
                <label for="senha-login-input">Senha</label>
                <input type="text" name="senha-login-input">
            </div>
        </div>
        <div class="auth-pages-form-redirect">
            <a href="{{route('pagina.cadastro')}}">Cadastre-se</a>
        </div>
        <button type="button"><span>Entrar</span></button>
    </div>


</section>


@endsection





