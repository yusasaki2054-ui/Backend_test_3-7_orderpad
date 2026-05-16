@extends('layouts.app')
@section('title','Create Product')

@section('content')
  <div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Create Product</h1>

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" novalidate>
      @include('products._form')
    </form>
  </div>
@endsection
