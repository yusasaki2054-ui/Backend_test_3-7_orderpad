<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(12);

        return view('products.trashed', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $product = new Product();
        return view('products.create', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']);
        $product = Product::create($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', '商品を作成しました。');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']);
        $product->update($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', '商品を更新しました。');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '商品をゴミ箱に移動しました。');
    }

    public function restore(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('products.trashed')
            ->with('success', '商品を復元しました。');
    }

    public function forceDestroy(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->forceDelete();

        return redirect()
            ->route('products.trashed')
            ->with('success', '商品を完全に削除しました。');
    }
}
