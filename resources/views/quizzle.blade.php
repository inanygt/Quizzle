@extends('masters')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
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

    <form action="/quizzle" method="POST">
        @csrf
        <select class="form-select" aria-label="Default select example" name="category_id" >>
        {{-- For each all categories --}}
            <option selected>Choose a category</option>
            @foreach ($categories as $category)
            <option value="1"> {{$category->name}} </option>
            @endforeach
        </select>
        <label for="exampleInputEmail1" class="form-label">Choose the name of the quizz</label>
        <input type="text"  class="form-control"name="name">
        <input type="submit" class="form-control" value="Send">
        {{-- Test --}}
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
    </form>

        </div>
    </div>
</div>
@endsection
