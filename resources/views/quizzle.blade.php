@extends('masters')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Make you own quizzle!</h1>

    <form action="/quizzle" method="POST">

        @csrf

        <select class="form-select" aria-label="Default select example" name="category_id" >>
        <option selected>Choose a category</option>
        <option value="1">Geography</option>
        <option value="2">Music</option>
        <option value="3">Math</option>
        </select>
        <input type="text"  class="form-control"name="name">
        <input type="submit" class="form-control" value="Send">
    </form>

        </div>
    </div>
</div>
@endsection
