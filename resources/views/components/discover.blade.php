@extends('welcome')
@section('content')
<h1 class="pt-5">Discover our collection of Quizzles!</h1>
{{-- Cards --}}


<div class="row">
    @foreach ($categories as $category)
    <div class="col-md-6">
        <div class="card mt-3">
            {{-- <img src="..." class="card-img-top" alt="..."> --}}
            <div class="card-body">
                <h1 class="card-title">{{ $category->name }}</h1>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="{{ route($category->name) }}" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
