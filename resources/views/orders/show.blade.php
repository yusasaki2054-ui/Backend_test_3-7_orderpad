@extends('layouts.app')
@section('title', 'Order #'.$order->id)
@section('content')
  <div class="max-w-7xl mx-auto px-4 py-6">
    <a href="{{ route('orders.index') }}">← Back</a>
    <h1 class="text-2xl font-bold mt-2">Order #{{ $order->id }}</h1>
    <div class="text-sm text-gray-500 mt-1">
      ユーザー: {{ $order->user->name }}／注文日: {{ $order->order_date->format('Y-m-d') }}
    </div>

    <table class="w-full border-collapse border text-sm mt-4">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">商品名</th>
          <th class="border p-2">単価</th>
          <th class="border p-2">数量</th>
          <th class="border p-2">小計</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
          <tr>
            <td class="border p-2">{{ $item->product->name }}</td>
            <td class="border p-2">¥{{ number_format($item->unit_price) }}</td>
            <td class="border p-2">{{ $item->qty }}</td>
            <td class="border p-2">¥{{ number_format($item->subtotal) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <p class="mt-4 font-semibold">
      合計: ¥{{ number_format($order->computed_total) }}
    </p>

    <div class="mt-6 flex gap-3">
      @can('update', $order)
        <a class="inline-block px-3 py-2 bg-blue-600 text-white rounded"
           href="{{ route('orders.edit', $order) }}">編集</a>
      @endcan
      @can('delete', $order)
        <form method="post" action="{{ route('orders.destroy', $order) }}" class="inline"
              onsubmit="return confirm('削除しますか？')">
          @csrf @method('DELETE')
          <button class="px-3 py-2 bg-red-600 text-white rounded">削除</button>
        </form>
      @endcan
    </div>
  </div>
@endsection
