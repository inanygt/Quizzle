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
                <form method="POST" action="/quizzle/start" id="aiQuizForm">
                    @csrf
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject">

                    <label for="num_questions">Number of Questions:</label>
                    <input type="number" id="num_questions" name="num_questions">



                    <button type="submit" id="generateAiQuiz">Generate Ai Quiz</button>
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
    let generateAiQuizBtn = document.getElementById('generateAiQuiz');
    let aiQuizForm = document.getElementById('aiQuizForm');
    let quizzleForm = document.querySelector('form[action="/quizzle"]');
    let btn = document.getElementById('add');
    let container = document.getElementById('container');
    let questionCounter = 0;
    const maxQuestions = 10;

    function createQuestion(questionData) {
        if (questionCounter < maxQuestions) {
            let newDiv = document.createElement("div");

            let questionInput = document.createElement("input");
            questionInput.type = "text";
            questionInput.placeholder = "Your question";
            questionInput.classList.add("form-control", "my-3");
            questionInput.style.fontWeight = "bold";
            questionInput.name = "questions[]";
            questionInput.value = questionData.text;

            newDiv.appendChild(questionInput);

            questionCounter++;

            let questionHeading = document.createElement("h3");
            questionHeading.textContent = "Question " + questionCounter;
            questionHeading.classList.add('mt-5');

            questionData.answers.forEach((answerData, i) => {
                let answerDiv = document.createElement("div");
                answerDiv.classList.add("answer-option");

                let answerInput = document.createElement("input");
                answerInput.type = "text";
                answerInput.classList.add("form-control" , 'my-2');
                answerInput.placeholder = "Answer " + (i + 1);
                answerInput.name = `answers[${questionCounter - 1}][${i}][text]`;
                answerInput.value = answerData.text;

                let correctAnswerCheckbox = document.createElement("input");
                correctAnswerCheckbox.type = "checkbox";
                correctAnswerCheckbox.name = `answers[${questionCounter - 1}][${i}][is_correct]`;
                correctAnswerCheckbox.value = "1";
                correctAnswerCheckbox.checked = answerData.is_correct;

                answerDiv.appendChild(answerInput);
                answerDiv.appendChild(correctAnswerCheckbox);

                newDiv.appendChild(answerDiv);
            });

            let deleteBtn = document.createElement("button");
            deleteBtn.textContent = "Delete Question";
            deleteBtn.type = "button";
            deleteBtn.classList.add("btn", "btn-danger");
            deleteBtn.addEventListener("click", function() {
                container.removeChild(questionHeading);
                container.removeChild(newDiv);
                container.removeChild(deleteBtn);
                questionCounter--;
                btn.disabled = false;
            });

            container.appendChild(questionHeading);
            container.appendChild(newDiv);
            container.appendChild(deleteBtn);

            if (questionCounter === maxQuestions) {
                let maxReachedText = document.createElement("p");
                maxReachedText.textContent = "Maximum number of questions reached.";
                maxReachedText.classList.add("alert", "alert-warning");
                maxReachedText.setAttribute("role", "alert");
                container.appendChild(maxReachedText);
                btn.disabled = true;
            }
        }
    }

    btn.addEventListener("click", function() {
        createQuestion({
            text: "",
            answers: Array(4).fill({
                text: "",
                is_correct: false,
            }),
        });
    });

    generateAiQuizBtn.addEventListener('click', function(event) {
    event.preventDefault();

    // Store original form submission handler
    let originalOnsubmit = quizzleForm.onsubmit;

    // Temporarily disable form submission
    quizzleForm.onsubmit = function(e) { e.preventDefault(); };

    // Step 1: Generate the AI Quiz
    fetch('/quizzle/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-Token': '{{ csrf_token() }}'
        },
        body: new URLSearchParams(new FormData(aiQuizForm))
    })
    .then(() => {
        // Step 2: Fetch the latest AI Quiz
        return fetch('/quizzle/latest')
    })
    .then(response => response.json())
    .then(data => {
        // Step 3: Fill the quiz form
        data.questions.forEach(createQuestion);

        // Re-enable form submission by restoring the original handler
        quizzleForm.onsubmit = originalOnsubmit;
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});


</script>

@endsection

