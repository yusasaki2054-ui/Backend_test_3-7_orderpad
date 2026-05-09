@csrf
<div class="mb-4">
  <label class="block mb-1">注文日</label>
  <input type="date" name="order_date" class="border p-2" value="{{ old('order_date', optional($order->order_date)->format('Y-m-d')) }}">
  @error('order_date') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>
@php
  $items = old('items');
  if (!is_array($items)) {
    $items = ($order->relationLoaded('items') ? $order->items->map(function($it){
      return ['product_id'=>$it->product_id,'unit_price'=>$it->unit_price,'qty'=>$it->qty];
    })->toArray() : []);
  }
  if (count($items) === 0) { $items = [['product_id'=>'','unit_price'=>'','qty'=>1]]; }
@endphp
<table class="w-full bg-white border mb-4" id="items-table">
  <thead>
    <tr class="bg-gray-50">
      <th class="p-2">商品</th>
      <th class="p-2">単価</th>
      <th class="p-2">数量</th>
      <th class="p-2"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($items as $i => $it)
      <tr class="border-t">
        <td class="p-2">
          <select name="items[{{ $i }}][product_id]" class="border p-2 w-full product-select">
            <option value="">選択してください</option>
            @foreach ($products as $p)
              <option value="{{ $p->id }}" data-price="{{ $p->price }}" {{ (string)$it['product_id'] === (string)$p->id ? 'selected' : '' }}>
                {{ $p->name }} (¥{{ number_format($p->price) }})
              </option>
            @endforeach
          </select>
        </td>
        <td class="p-2">
          <input type="number" min="0" name="items[{{ $i }}][unit_price]" class="border p-2 w-full unit-price" value="{{ old('items.'.$i.'.unit_price', $it['unit_price']) }}">
        </td>
        <td class="p-2">
          <input type="number" min="1" name="items[{{ $i }}][qty]" class="border p-2 w-full" value="{{ old('items.'.$i.'.qty', $it['qty']) }}">
        </td>
        <td class="p-2">
          <button type="button" class="px-3 py-2 bg-gray-200 rounded rtton>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="mb-6">
  <button type="button" id="add-row" class="px-4 py-2 bg-gray-600 text-white rounded">行を追加</button>
</div>
<button class="px-4 py-2 bg-blue-600 text-white rounded">保存</button>
<a href="{{ route('orders.index') }}" class="ml-3 text-gray-600">キャンセル</a>
