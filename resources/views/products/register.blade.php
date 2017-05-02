@extends('layouts.app')

@section('title', 'Register product')

@section('content')

<h1>Register product</h1>
<p>Register your product by filling out the form below.</p>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<form method="POST" action="{{ action('ProductController@store') }}">
	{{ csrf_field() }}
	<div class="form-group">
		<input placeholder="Name" name="name" value="{{ old('name') }}" type="text" class="form-control" />
	</div>
	<div class="form-group">
		<textarea placeholder="Description" name="description" class="form-control">{{ old('description') }}</textarea>
	</div>
	<div class="form-group">
		<input placeholder="Ean barcode" name="barcode" value="" type="number" class="form-control" />
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">
			Register
		</button>
	</div>
</form>

@endsection