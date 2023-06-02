   @extends('masters')
   @section('content')
   <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="pt-5">Music</h1>
                    {{-- Cards --}}
                    <div class="row">
                        @foreach ($quizzes as $quiz)
                        <div class="col-md-6">
                            <div class="card mt-3">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h1 class="card-title">{{ $quiz->name }}</h1>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection
