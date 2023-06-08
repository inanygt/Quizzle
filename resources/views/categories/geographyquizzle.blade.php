@extends('quizmaster')
@section('content')

{{-- Questions --}}
<div class="row my-5">
    <div class="col text-center">
        @foreach ($questions as $question )
    <h3> {{$question->question}}</h3>
@endforeach
    </div>
</div>

{{-- Answers --}}



<div class="row">
    @foreach ($answers as $answer )
    <div class="col-6">
        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$answer->answer}}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            </div>
        </div>
        @endforeach
</div>




@endsection
