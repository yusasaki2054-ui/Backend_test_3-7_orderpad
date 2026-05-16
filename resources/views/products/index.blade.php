@extends('layouts.app')
@section('title','Products')
@section('content')
  <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Products</h1>
      <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">新規作成</a>
      <a href="{{ route('products.trashed') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">ゴミ箱</a>
    </div>

    @if ($products->count())
      <div class="grid md:grid-cols-3 gap-4">
        @foreach($products as $p)
          <a href="{{ route('products.show', $p) }}" class="block p-4 border bg-white hover:bg-gray-50">
            @if($p->image_path)
              <img src="{{ Storage::url($p->image_path) }}" alt="{{ e($p->name) }}" class="w-full h-40 object-cover mb-2">
            @else
              <div class="w-full h-40 bg-gray-200 flex items-center justify-center mb-2">
                <span class="text-gray-400 text-sm">画像なし</span>
              </div>
            @endif
            <div class="font-semibold truncate">{{ $p->name }}</div>
            <dm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($p->description, 60) }}</div>
            <div class="mt-2">{{ $p->price_formatted }}</div>
            @if($p->published_at)
              <div class="text-xs text-gray-500 mt-1">公開: {{ $p->published_at->format('Y-m-d') }}</div>
            @endif
          </a>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @else
      <p>データがありません。</p>
    @endif
  </div>
@endsection
