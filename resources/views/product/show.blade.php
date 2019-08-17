@extends('layouts.app')

@section('content')
    <div>
        <div>{{ $product->name }}</div>
        <div>{{ $product->description }}</div>
    </div>
@endsection