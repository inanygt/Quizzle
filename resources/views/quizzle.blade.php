@extends('masters')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 mx-auto">
            <h1 class="mb-4">Make you own quizzle!</h1>


            @if (@isset($name))
            <div class="alert alert-success" role="alert">
                {{$name}}, you submission has been received.
            </div>

            @endif

            @if (@isset($errorMessage))
            <div class="alert alert-danger" role="alert">
                {{$errorMessage}}
            </div>
            @endif

            <div class="container">
                <form method="POST" action="/quizzle/start">
                    @csrf
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject">

                    <label for="num_questions">Number of Questions:</label>
                    <input type="number" id="num_questions" name="num_questions">

                    <button type="submit">Generate Ai Quiz</button>
                </form>
                </div>
            {{-- Form --}}
            <form action="/quizzle" method="POST">
                @csrf
                <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="category_id">
    <option disabled selected value="">Choose a category</option>
    {{-- Categories --}}
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
                </div>
                <div class="mb-3">

                    <input type="text" placeholder="Name your fuzzle"  class="form-control"name="name">
                </div>
                <div class="mb-3">
                    <input type="text" placeholder="Subject of your fuzzle"  class="form-control"name="subject">
                </div>
                {{-- Add --}}
                <div id="container"></div>
                <button type="button" id="add" class="btn btn-primary my-3">Add Question</button>
                <input type="submit" class="form-control my-3" value="confirm">
                <input type="hidden" name="approved" value="0">
            </form>

        </div>
    </div>
</div>
{{-- Javascript --}}
<script>
    let btn = document.getElementById('add');
    let container = document.getElementById('container');
    let answer = document.getElementById('answer');
    let hquest = document.getElementById('hquest');
    let questionCounter = 0; // Counter to keep track of the question number
    const maxQuestions = 5; // Maximum number of questions

    function createQuestion(questionData) {
        let newDiv = document.createElement("div");

        let questionInput = document.createElement("input");
        questionInput.type = "text";
        questionInput.value = questionData.text;
        questionInput.classList.add("form-control", "my-3");
        questionInput.style.fontWeight = "bold";
        questionInput.name = "questions[]";

        newDiv.appendChild(questionInput);

        questionCounter++;

        let questionHeading = document.createElement("h3");
        questionHeading.textContent = "Question " + questionCounter;
        questionHeading.classList.add('mt-5');

        for (let i = 0; i < questionData.answers.length; i++) {
            let answerData = questionData.answers[i];
            let answerDiv = document.createElement("div");
            answerDiv.classList.add("answer-option");

            let answerInput = document.createElement("input");
            answerInput.type = "text";
            answerInput.name = "answers[]";
            answerInput.value = answerData.text;
            answerInput.classList.add("form-control", "my-3");

            let correctCheckbox = document.createElement("input");
            correctCheckbox.type = "checkbox";
            correctCheckbox.name = "is_correct[]";
            correctCheckbox.checked = answerData.is_correct;

            answerDiv.appendChild(answerInput);
            answerDiv.appendChild(correctCheckbox);
            newDiv.appendChild(answerDiv);
        }

        container.appendChild(questionHeading);
        container.appendChild(newDiv);
    }

    window.onload = function() {
        fetch('/quizzle/latest')
            .then(response => response.json())
            .then(data => {
                data.questions.forEach(createQuestion);
            });
    };

    btn.addEventListener('click', function() {
        if (questionCounter >= maxQuestions) {
            alert("You cannot add more questions!");
            return;
        }
        createQuestion({ text: "", answers: [{ text: "", is_correct: false }] });
    });
</script>
@endsection
