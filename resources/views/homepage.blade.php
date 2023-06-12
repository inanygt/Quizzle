<link rel="stylesheet" href="{{ asset('css/homepage.css') }}">

<div class="row row-front align-items-center justify-content-center">
    <div class="col text-center">
        <div class="hero">
            <h1 class="homeHeading">Quizzle, Learn & Grow</h1>
            <p class="deopacity">Unleash Your Knowledge!</p>
            {{-- Buttons --}}
            <a href="{{ route('quizzle') }}" class="btn btn-dark mx-2 deopacity"><i class="fa-solid pe-1 fa-circle-plus"></i> quizzle</a>
            <a href="{{ route('random') }}" class="btn btn-dark mx-2 deopacity"><i class="fa-regular pe-1 fa-circle-play"></i> random </a>
        </div>
    </div>
</div>
