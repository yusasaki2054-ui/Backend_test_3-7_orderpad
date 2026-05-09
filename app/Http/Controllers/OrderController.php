<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->with(['user','items'])
            ->orderByDesc('order_date')->orderByDesc('id')
            ->paginate(15)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user','items.product']);
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $this->authorize('create', Order::class);
        $order = new Order(['order_date' => now()->toDateString()]);
        $order->setRelation('items', collect());
        $products = Product::query()->orderBy('name')->get(['id','name','price']);
        return view('orders.create', compact('order','products'));
    }

    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);

        $order = null;
        DB::transaction(function () use ($request, &$order) {
            $order = Order::create([
                'user_id'      => $request->user()->id,
                'order_date'   => $request->validated()['order_date'],
                'total_amount' => 0,
            ]);

            $total = 0;
            foreach ($request->validated()['items'] as $it) {
                $product = Product::findOrFail($it['product_id']);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'qty'        => $it['qty'],
                    'unit_price' => $product->price,
                ]);
                $total += $it['qty'] * $product->price;
            }
            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('orders.show', $order)
            ->with('success','注文を作成しました。');
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        $order->load(['items.product']);
        $products = Product::query()->orderBy('name')->get(['id','name','price']);
        return view('orders.edit', compact('order','products'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        DB::transaction(function () use ($request, $order) {
            $order->update(['order_date' => $request->validated()['order_date']]);
            $order->items()->delete();

            $total = 0;
            foreach ($request->validated()['items'] as $it) {
                $product = Product::findOrFail($it['product_id']);
                $order->items()->create([
                    'product_id' => $product->id,
                    'qty'        => $it['qty'],
                    'unit_price' => $product->price,
                ]);
                $total += $it['qty'] * $product->price;
            }
            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('orders.show', $order)
            ->with('success','注文を更新しました。');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success','注文を削除しました。');
    }
}
