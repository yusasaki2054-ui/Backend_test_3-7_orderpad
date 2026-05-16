@csrf
<div class="mb-4">
  <label class="block mb-1">商品名 <span class="text-red-600">*</span></label>
  <input type="text" name="name" class="border p-2 w-full"
         value="{{ old('name', $product->name) }}">
  @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
  <label class="block mb-1">価格（税抜・円） <span class="text-red-600">*</span></label>
  <input type="number" name="price" class="border p-2 w-full" min="0" step="1"
         value="{{ old('price', $product->price) }}">
  @error('price') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
  <label class="block mb-1">説明</label>
  <textarea name="description" class="border p-2 w-full" rows="4">{{ old('description', $product->description) }}</textarea>
  @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
  <label class="block mb-1">公開日（任意）</label>
  <input typer p-2"
         value="{{ old('published_at', optional($product->published_at)->format('Y-m-d')) }}">
  @error('published_at') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-6">
  <label class="block mb-1">画像（任意）</label>
  @if($product->image_path)
    <div class="mb-2">
      <img src="{{ Storage::url($product->image_path) }}" alt="{{ e($product->name) }}" class="w-32 h-32 object-cover border">
      <p class="text-sm text-gray-500 mt-1">現在の画像</p>
    </div>
  @else
    <div class="mb-2 w-32 h-32 bg-gray-200 flex items-center justify-center border">
      <span class="text-gray-400 text-sm">画像なし</span>
    </div>
  @endif
  <input type="file" name="image" class="border p-2 w-full" accept="image/jpg,image/jpeg,image/png,image/webp">
  <p class="text-sm text-gray-500 mt-1">対応形式: jpg, jpeg, png, webp / 最大2MB</p>
  @error('image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
</div>

<button class="px-4 py-2 bg-blue-600 text-white rounded">保存</button>
<a href="{{ route('products.index') }}" class="ml-3 text-gray-600">キャンセル</a>
