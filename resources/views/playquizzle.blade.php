@extends('quizmaster')
@section('content')
<div class="container">
    <div class="row mt-5">
        <h1>{{ $quiz->name }}</h1>
        {{-- For each questions related quiz --}}
        @foreach ($quiz->questions as $question)
        <h4>Question: {{ $question->question }}</h4>
        {{-- For each answers related questions --}}
        @foreach ($question->answers as $answer)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
    {{ $answer->answer }}
            </label>
        </div>
    @endforeach
    @endforeach
    </div>
</div>
@endsection
