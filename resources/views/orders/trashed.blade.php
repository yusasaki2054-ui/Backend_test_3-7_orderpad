@extends('layouts.app')
@section('title','ゴミ箱 - Orders')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">ゴミ箱</h1>
    <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">← 通常一覧へ</a>
  </div>
  @if($orders->count())
    <table class="w-full border-collapse border text-sm">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">#</th>
          <th class="border p-2">ユーザー</th>
          <th class="border p-2">注文日</th>
          <th class="border p-2">削除日</th>
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
            <td class="border p-2">{{ $o->deleted_at->format('Y-m-d') }}</td>
            <td class="border p-2">{{ $o->computed_total }}</td>
            <td class="border p-2 text-right">
              @can('restore', $o)
                <form method="post" action="{{ route('orders.restore', $o->id) }}" class="inline">
                  @csrf
                  <button class="text-green-600">復元</button>
                </form>
              @endcan
              @can('forceDelete', $o)
                <form method="post" action="{{ route('orders.force-destroy', $o->id) }}" class="inline"
                      onsubmit="return confirm('完全に削除しますか？元に戻せません。')">
                  @csrf
                  @method('DELETE')
                  <button class="ml-2 text-red-600">完全削除</button>
                </form>
              @endcan
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-6">{{ $orders->links() }}</div>
  @else
    <p>ゴミ箱は空です。</p>
  @endif
</div>
@endsection
