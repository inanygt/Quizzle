@extends('quizmaster')
@section('content')
<div class="container">
    <div class="row">
         <h1>{{ $quiz->name }}</h1>

    {{-- @foreach($quiz->questions as $question)
    <p>Question: {{ $question->question }}</p>
    @endforeach --}}
    @foreach ($quiz->questions as $question)
    <p>Question: {{ $question->question }}</p>

    @foreach ($question->answers as $answer)
        <p>Answer: {{ $answer->answer }}</p>

    @endforeach

    <br>
@endforeach
    </div>
</div>


@endsection
