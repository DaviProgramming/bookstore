@extends('./template')


@section('pagina', 'cadastro')

@section('head-content')

@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/main.scss', 'resources/js/cadastroScript.js'])

@endsection

@section('main-content')


@include('./components/nav')


<section class="container-fluid auth-pages">


    <div class="auth-pages-form">
        <div class="auth-pages-form-title">Cadastre-se</div>
        <div class="auth-pages-form-content">
            <div class="auth-pages-form-content-input-group">
                <label for="nome-cadastro">Nome</label>
                <input type="text" name="nome-cadastro-input" id="nome-cadastro" autofocus>
            </div>
            <span class="auth-pages-form-content-input-error name"><i class="fa-solid fa-circle-exclamation"></i> <span>Nome invalido</span></span>
            <div class="auth-pages-form-content-input-group">
                <label for="email-cadastro">Email</label>
                <input type="email" name="email-cadastro-input" id="email-cadastro">
            </div>
            <span class="auth-pages-form-content-input-error email"><i class="fa-solid fa-circle-exclamation"></i> <span>Email invalido</span></span>

            <div class="auth-pages-form-content-input-group">
                <label for="senha-cadastro">Senha</label>
                <input type="password" name="senha-cadastro-input" id="senha-cadastro">
                <div class="auth-pages-form-content-input-group-eyes">
                    <i class="fa-solid fa-eye"></i>
                    <i class="fa-solid fa-eye-slash active"></i>
                </div>
            </div>
            <span class="auth-pages-form-content-input-error password"><i class="fa-solid fa-circle-exclamation"></i> <span>Senha invalida</span></span>

            <div class="auth-pages-form-content-input-group">
                <label for="confirmar-senha-cadastro">Confirmar Senha</label>
                <input type="password" name="confirmar-senha-cadastro-input" id="confirmar-senha-cadastro">
                <div class="auth-pages-form-content-input-group-eyes">
                    <i class="fa-solid fa-eye"></i>
                    <i class="fa-solid fa-eye-slash active"></i>
                </div>
            </div>
            <span class="auth-pages-form-content-input-error confirm-password"><i class="fa-solid fa-circle-exclamation"></i> <span>As senhas não coincidem</span></span>

        </div>
        <div class="auth-pages-form-redirect">
            <a href="{{route('pagina.login')}}">Fazer Login</a>
        </div>
        <button type="button" name="button-cadastro"><span class="button-span">Cadastrar</span></button>
    </div>


</section>


@endsection





