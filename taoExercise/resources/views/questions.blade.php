@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
	    <div class="container-fluid mb-2">
            <h1>Questions list</h1>
            @if(\Session::has("message"))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>{{ \Session::get("message") }}
                </div>
            @endif
	    </div>
	     <div class="container-fluid">
            @foreach($csv_data as $k=>$data)
                <div class="h4 d-inline">Q{{ $k+1 }} </div><small class="text-muted">(created at {{ $data[1] }} )</small>
                <dl class="row">
                    <dt class="col-sm-4"> {{ $data[0] }} </dt>
                    <dd class="col-sm-"><p> {{ $data[2] }} </p><p> {{ $data[3] }} </p><p> {{ $data[4] }} </p></dd>
                </dl>

            @endforeach
         </div>
        </div>
    </div>


@endsection
