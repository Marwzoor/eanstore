@extends('layouts.app')

@section('title', 'Products')

@section('content')

<ul class="list-group">
	@foreach($products as $product)
	<a class="list-group-item" href="{{ action('ProductController@show', ['id' => $product->id]) }}">
		{{ $product->name }}
	</a>
	@endforeach
</ul>

@endsection