@extends('layouts.app')

@section('title', $product->name)

@section('content')

<a href="{{ action('ProductController@index') }}">
	&laquo; Back to product list
</a>

<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>

@endsection