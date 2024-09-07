@extends('./template')


@section('pagina', 'Dashboard')

@section('head-content')

<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/main.scss', 'resources/js/loginScript.js'])

@endsection

@section('main-content')


@include('./components/nav')


<section class="container-fluid auth-pages">

    Dashboard



</section>

@include('./components/loader-page')


@endsection


