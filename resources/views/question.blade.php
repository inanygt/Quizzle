<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Quiz') }}</div>

                    <div class="card-body">
                        <h3>{{ $question->question }}</h3>  <!-- Displaying the question outside the form -->

                        <form method="POST" action="{{ route('quiz.submitAnswer', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber]) }}">
                            @csrf

                            <div class="form-group">
                                @foreach(json_decode($question->choices) as $index => $choice)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answer" id="answer{{ $index }}" value="{{ $index }}">
                                        <label class="form-check-label" for="answer{{ $index }}">
                                            {{ $choice }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit Answer') }}
                                </button>
                            </div>

                            <!-- Displaying correct answer for testing -->
                            <div>Correct Answer: {{ $question->correct_answer }}</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>
</html>
