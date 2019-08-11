@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
	    <div class="container-fluid">
		<h1>Add question</h1>
	    </div>
	     <div class="container-fluid">
            <form action="/addQuestion" method="post">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Please correct errors!
                    </div>
                @endif

                {!! csrf_field() !!}


	      <div class="form-row">
            <div class="form-group col-md-12">
                    <label for="marca">Question</label>
                    <input type="text" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" id="question" name="question" placeholder="Question" value="{{ old('question') }}">
                    @if($errors->has('question'))
                        <span class="help-block">{{ $errors->first('question') }}</span>
                    @endif
            </div>
         </div>
	      <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nume">Choice 1</label>
                    <input type="text" class="form-control  {{ $errors->has('choice1') ? 'is-invalid' : '' }}" id="choice1" name="choice1" placeholder="Choice 1" value="{{ old('choice1') }}">
                    @if($errors->has('choice1'))
                        <span class="help-block">{{ $errors->first('choice1') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="prenume">Choice 2</label>
                    <input type="text" class="form-control {{ $errors->has('choice2') ? 'is-invalid' : '' }}" id="choice2" name="choice2" placeholder="Choice 2" value="{{ old('choice2') }}">
                    @if($errors->has('choice2'))
                        <span class="help-block">{{ $errors->first('choice2') }}</span>
                    @endif
                </div>

                <div class="form-group col-md-4">
                    <label for="prenume">Choice 3</label>
                    <input type="text" class="form-control {{ $errors->has('choice3') ? 'is-invalid' : '' }}" id="choice3" name="choice3" placeholder="Choice 3" value="{{ old('choice3') }}">
                    @if($errors->has('choice3'))
                        <span class="help-block">{{ $errors->first('choice3') }}</span>
                    @endif
                </div>
	     </div>


                <button type="submit" class="btn btn-default">Add</button>
            </form>
	  </div>
        </div>
    </div>

@endsection
