<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('home')}}">
        <img id="logo" src="{{ asset('images/quizzleLogo.png') }}" alt="Image">

    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{route('discover')}}">Discover</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="{{route('quizzle')}}">Quizzle!</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/quiz/start">Ai Quiz</a>
          </li>
        {{-- DropDown Profile --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('register')}}">Register</a></li>
            <li><a class="dropdown-item"  href="{{route('login')}}">Log In</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Log Out </a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>

{{-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> --}}
