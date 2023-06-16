@extends('quizmaster')
@section('content')
<div class="container">
    <div class="row mt-5">
        <h1>{{ $quiz->name }}</h1>
        {{-- For each questions related quiz --}}
        @foreach ($quiz->questions as $question)
        <h4>Question: {{ $question->question }}</h4>
        {{-- For each answers related questions --}}
        @foreach ($question->answers as $index => $answer)

        <div class="radio-group">
        <div class="form-check">
            <input  class="form-check-input" type="radio" name="group{{$index}}" id="flexRadioDefault1" value="{{ $answer->id }}">
            <label class="form-check-label" for="flexRadioDefault1">
     {{$index}} {{ $answer->answer }}
            </label>
        </div>
        </div>
        @endforeach
        {{-- Submit button --}}
        <input type="submit" class="btn btn-dark">
    @endforeach
    </div>
</div>
@endsection
