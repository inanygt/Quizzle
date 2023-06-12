@extends('quizmaster')
@section('content')
<div class="container">
    <div class="row">
         <h1>{{ $quiz->name }}</h1>

    @foreach($quiz->questions as $question)
    <p>Question: {{ $question->question }}</p>
    @endforeach
    </div>
</div>


@endsection
