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
                <input type="text" name="nome-cadastro-input" id="nome-cadastro">
            </div>
            <div class="auth-pages-form-content-input-group">
                <label for="email-cadastro">Email</label>
                <input type="email" name="email-cadastro-input" id="email-cadastro">
            </div>
            <div class="auth-pages-form-content-input-group">
                <label for="senha-cadastro">Senha</label>
                <input type="text" name="senha-cadastro-input" id="senha-cadastro">
            </div>
            <div class="auth-pages-form-content-input-group">
                <label for="confirmar-senha-cadastro">Confirmar Senha</label>
                <input type="text" name="confirmar-senha-cadastro-input" id="confirmar-senha-cadastro">
                <div class="auth-pages-form-content-input-group-eyes">
                    <i class="fa-solid fa-eye active"></i>
                    <i class="fa-solid fa-eye-slash "></i>
                </div>
            </div>
        </div>
        <div class="auth-pages-form-redirect">
            <a href="{{route('pagina.login')}}">Fazer Login</a>
        </div>
        <button type="button" name="button-cadastro"><span>Cadastrar</span></button>
    </div>


</section>


@endsection





