

<nav class="navbar-custom">
<a href="" class="navbar-custom-logo">Book<span>store</span></a>

@if (!empty($user))

<div class="navbar-custom-items">
    
    <div class="navbar-custom-items-item">
       
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{$user->name}}
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('auth.logout')}}">Sair</a></li>
            </ul>
          </div>
    </div>
</div>


@else


<div class="navbar-custom-items">
    <div class="navbar-custom-items-item <?php if($page == 'login') echo 'active'?>">
        <a href="{{route('pagina.login')}}">Login</a>
    </div>
    <div class="navbar-custom-items-item <?php if($page == 'cadastro') echo 'active'?>">
        <a href="{{route('pagina.cadastro')}}">Cadastro</a>
    </div>
</div>
    
@endif

</nav>