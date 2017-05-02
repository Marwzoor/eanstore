@extends('layouts.app')

@section('title', 'Add shopping item')

@section('content')

<h1>Add shopping item</h1>

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

<form method="POST" action="{{ action('ShoppingItemController@store') }}">
	{{ csrf_field() }}
	<div class="form-group">
		<input placeholder="Ean barcode" name="barcode" value="" type="number" class="form-control" autofocus="true" />
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">
			Add
		</button>
	</div>
</form>

@endsection