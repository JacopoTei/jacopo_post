<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('welcome')}}">Home</a>
          </li>
      
          <li class="nav-item">
            <a href="{{route('article.create')}}" class="nav-link">Crea un articolo</a>
         </li>
         <li class="nav-item">
           <a href="{{route('article.index')}}" class="nav-link">Tutti gli articoli</a>
        </li>
        <li class="nav-item">
          <a href="{{route('careers')}}" class="nav-link">Lavora con noi</a>
       </li>
          @auth
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Benvenuto {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Profilo</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">Logout</a></li>
                  @if(Auth::user()->is_admin)
          <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
     @endif
     @if(Auth::user()->is_revisor)
          <li><a class="dropdown-item" href="{{ route('revisor.dashboard') }}">Dashboard Revisore</a></li>
     @endif
     @if(Auth::user()->is_writer)
          <li><a class="dropdown-item" href="{{ route('writer.dashboard') }}">Dashboard Redattore</a></li>
     @endif
                  <form method="post" action="{{ route('logout') }}" id="form-logout" class="d-none">
                      @csrf
                  </form>
              </ul>
          </li>
      @endauth
      
      @guest
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Benvenuto Ospite
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="{{ route('register') }}">Registrati</a></li>
                  <li><a class="dropdown-item" href="{{ route('login') }}">Accedi</a></li>
              </ul>
          </li>
         
      @endguest
      
        </ul>
        <form class="d-flex" method="GET" action="{{route('article.search')}}">
          <input class="form-control me-2" type="search" name="query" placeholder="Cosa stai cercando?" aria-label="Search">
          <button class="btn btn-outline-info" type="submit">Cerca</button>
        </form>     
      </div>
    </div>
  </nav>