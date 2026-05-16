@extends('layouts.app')
@section('title','Orders')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Orders</h1>
    @can('create', \App\Models\Order::class)
      <a class="px-4 py-2 bg-blue-600 text-white rounded" href="{{ route('orders.create') }}">新規作成</a>
    @endcan
      <a href="{{ route('orders.trashed') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">ゴミ箱</a>
  </div>

  <form method="GET" action="{{ route('orders.index') }}" class="bg-white p-4 border rounded mb-6">
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
      <div>
        <label class="block text-sm mb-1">ユーザー名</label>
        <input type="text" name="user_name" class="border p-2 w-full" value="{{ e(old('user_name', request('user_name'))) }}">
        @error('user_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm mb-1">開始日</label>
        <input type="date" name="date_from" class="border p-2 w-full" value="{{ old('date_from', request('date_from')) }}">
        @error('date_from') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm mb-1">終了日</label>
        <input type="date" name="date_to" class="border p-2 w-full" value="{{ old('date_to', request('date_to')) }}">
        @error('date_to') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm mb-1">最小金額</label>
        <input type="number" name="min_total" class="border p-2 w-full" value="{{ old('min_total', request('min_total')) }}">
        @error('min_total') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm mb-1">最大金額</label>
        <input type="number" name="max_total" class="border p-2 w-full" value="{{ old('max_total', request('max_total')) }}">
        @error('max_total') <divext-sm">{{ $message }}</div> @enderror
      </div>
    </div>
    <div class="mt-4 flex gap-2">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">検索</button>
      <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 rounded">リセット</a>
    </div>
  </form>

  @if($orders->count())
    <table class="w-full border-collapse border text-sm">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">#</th>
          <th class="border p-2">ユーザー</th>
          <th class="border p-2">注文日</th>
          <th class="border p-2">明細数</th>
          <th class="border p-2">合計</th>
          <th class="border p-2">操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $o)
          <tr class="hover:bg-gray-50">
            <td class="border p-2">{{ $o->id }}</td>
            <td class="border p-2">{{ $o->user->name }}</td>
            <td class="border p-2">{{ $o->order_date->format('Y-m-d') }}</td>
            <td class="border p-2">{{ $o->items->count() }}</td>
            <td class="border p-2">¥{{ number_format($o->computed_total) }}</td>
            <td class="border p-2 text-right">
              <a class="text-blue-600" href="{{ route('orders.show', $o) }}">詳細</a>
              @can('update', $o)
                <a class="ml-2 text-green-600" href="{{ route('orders.edit', $o) }}">編集</a>
              @endcan
              @can('delete', $o)
                <form method="post" action="{{ route('orders.destroy', $o) }}" class="inline"
                      onsubmit="return confirm('本当に削除しますか？')">
                  @csrf
                  @method('DELETE')
                  <button class="ml-2 text-red-600">削除</button>
                </form>
              @endcan
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-6">
      {{ $orders->links() }}
    </div>
  @else
    <p>データがありません。</p>
  @endif
</div>
@endsection
