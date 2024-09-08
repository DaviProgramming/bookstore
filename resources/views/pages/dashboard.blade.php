@php

    if(empty($page)){

        $url = "/dashboard/inicio";
        header("Location: $url");
        exit();

    }


@endphp

@extends('./template')

@section('pagina', 'Dashboard')

@section('head-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/main.scss', 'resources/js/novoLivro.js'])

@endsection

@section('main-content')


@include('./components/nav')
@include('./components/aside')


<section class="container-fluid dashboard">

    @if ($page == 'inicio')

    @include('./components/dashboard/inicio')

    @elseif($page == 'novo-livro')

    @include('./components/dashboard/adicionar-livro')
        
    @endif



</section>

@include('./components/loader-page')


@endsection


