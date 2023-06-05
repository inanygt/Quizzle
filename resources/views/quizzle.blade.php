@extends('masters')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h1>Make you own quizzle!</h1>


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
                <button type="button" id="add" class="btn btn-primary my-3">Add a Question</button>
                {{--   Questions --}}
                <div id="myDiv"></div>
                {{-- Submit  --}}
                <input type="submit" class="form-control my-3" value="confirm">

            </form>

        </div>
    </div>
</div>
{{-- Javascript --}}
<script>
    let btn = document.getElementById('add');
    let container = document.getElementById('myDiv');

    btn.addEventListener("click", function() {
    // Create a new div element
    let newDiv = document.createElement("div");

    // Create an input field for the question
    let questionInput = document.createElement("input");
    questionInput.type = "text";
    questionInput.placeholder = "Your question";
    questionInput.classList.add("form-control");
    questionInput.classList.add("my-3");
    newDiv.appendChild(questionInput);

    // Create input fields for answers
    for (let i = 1; i <= 4; i++) {
        let answerInput = document.createElement("input");
        answerInput.type = "text";
        answerInput.classList.add("form-control");
        answerInput.placeholder = "Answer " + i;
        newDiv.appendChild(answerInput);
    }

    // Append the new div element to the container
    container.appendChild(newDiv);
});


</script>
@endsection
