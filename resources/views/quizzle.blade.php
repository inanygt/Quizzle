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
            {{-- Form --}}
            <form action="/quizzle" method="POST">
                @csrf
                <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="category_id" >>
                    {{-- Categories --}}
                    <option selected>Choose a category</option>
                    @foreach ($categories as $category)
                    <option value="1"> {{$category->name}} </option>
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
                {{-- Submit  --}}

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


    // EVENTLISTENER
    btn.addEventListener("click", function() {
    if (questionCounter <= maxQuestions) {
    // Create a new div element
    let newDiv = document.createElement("div");

    // Create an input field for the question
    let questionInput = document.createElement("input");
    questionInput.type = "text";
    questionInput.placeholder = "Your question";
    questionInput.classList.add("form-control", "my-3");
    questionInput.style.fontWeight = "bold";

    newDiv.appendChild(questionInput);

       // Increment the question counter
    questionCounter++;

     // Create a heading element for the question
    let questionHeading = document.createElement("h3");
    questionHeading.textContent = "Question " + questionCounter;
    questionHeading.classList.add('mt-5');

    // Create input fields for answers
    for (let i = 1; i <= 3; i++) {
        let answerInput = document.createElement("input");
        answerInput.type = "text";
        answerInput.classList.add("form-control", "text-danger");
        answerInput.placeholder = "Answer " + i;
        newDiv.appendChild(answerInput);
    }

    let answerInput = document.createElement("input");
    answerInput.type="text";
    answerInput.placeholder = "correct answer";
    answerInput.classList.add("form-control", 'my-3', "text-success");

     // Create a delete button
            let deleteBtn = document.createElement("button");
            deleteBtn.textContent = "Delete Question";
            deleteBtn.classList.add("btn", "btn-danger");
            deleteBtn.addEventListener("click", function() {
                container.removeChild(questionHeading);
                container.removeChild(newDiv);
                container.removeChild(answerInput);
                container.removeChild(deleteBtn);
                questionCounter--;
                btn.disabled = false;
            });

    // Append the new div element to the container
    container.appendChild(questionHeading);
    container.appendChild(newDiv);
    container.appendChild(answerInput);
    container.appendChild(deleteBtn);


     if (questionCounter +1 > maxQuestions) {
            // Disable the button or perform any necessary action
            let maxReachedText = document.createElement("p");
            maxReachedText.textContent = "Maximum number of questions reached.";
            maxReachedText.classList.add("alert", "alert-warning");
            maxReachedText.setAttribute("role", "alert");
            container.appendChild(maxReachedText);
            btn.disabled = true;
        }
}

});


</script>
@endsection

