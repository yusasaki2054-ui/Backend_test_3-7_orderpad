@extends('layouts.app')
@section('title','ゴミ箱 - Products')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">ゴミ箱（商品）</h1>
    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">← 通常一覧へ</a>
  </div>
  @if($products->count())
    <table class="w-full border-collapse border text-sm">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">#</th>
          <th class="border p-2">商品名</th>
          <th class="border p-2">価格</th>
          <th class="border p-2">削除日</th>
          <th class="border p-2">操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
          <tr class="hover:bg-gray-50">
            <td class="border p-2">{{ $p->id }}</td>
            <td class="border p-2">{{ $p->name }}</td>
            <td class="border p-2">{{ $p->price_formatted }}</td>
            <td class="border p-2">{{ $p->deleted_at->format('Y-m-d') }}</td>
            <td class="border p-2 text-right">
              <form method="post" action="{{ route('products.restore', $p->id) }}" class="inline">
                @csrf
                <button class="text-green-600">復元</button>
              </form>
              <form method="post" action="{{ route('products.force-destroy', $p->id) }}" class="inline"
                    onsubmit="return confirm('完全に削除しますか？元に戻せません。')">
                @csrf
                @method('DELETE')
                <button class="ml-2 text-red-600">完全削除</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-6">{{ $products->links() }}</div>
  @else
    <p>ゴミ箱は空です。</p>
  @endif
</div>
@endsection
