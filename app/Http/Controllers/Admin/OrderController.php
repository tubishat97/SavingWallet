<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['name' => __('Orders')],
        ];

        $pageConfigs = ['pageHeader' => true];

        $addNewBtn = "admin.order.create";

        // Initialize query builder
        $orderQuery = Order::orderBy('id', 'desc');

        $start = $request->start_date;
        $end = $request->end_date;

        if (!empty($start) && empty($end)) {
            $orderQuery->whereDate('created_at', '>=', $start);
        }

        if (!empty($end) && empty($start)) {
            $orderQuery->whereDate('created_at', '<=', $end);
        }

        if (!empty($start) && !empty($end)) {
            $orderQuery->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }

        // Execute the query to get the orders
        $orders = $orderQuery->get();

        return view('backend.order.list', compact('breadcrumbs', 'pageConfigs', 'orders', 'addNewBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['name' => __('Add Order'),],
        ];

        // Fetch all products with names and prices
        $products = Product::all();

        return view('backend.order.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'cname' => 'required|string|max:255',
            'c_mobile_number' => 'nullable|string|max:15',
            'items' => 'required|array',
            'items.*.product' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost' => 'required|integer|min:1',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Begin transaction
            \DB::beginTransaction();

            $order = new Order();
            $order->name = $request->cname;
            $order->phone = $request->c_mobile_number;
            $order->save();

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product']);

                if ($product->quantity >= (int) $item['quantity']) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $product->id;
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['cost'] * (int) $item['quantity'];
                    $orderItem->save();
                    $total += $orderItem->price;

                    // Decrement product quantity
                    $product->decrementQuantity($item['quantity']);
                } else {
                    throw new Exception(__('Insufficient stock'));
                }
            }

            $order->price = $total;
            $order->save();

            // Commit transaction
            \DB::commit();

            return redirect()->route('admin.order.index')->with('success', __('system-messages.add'));
        } catch (Exception $e) {
            // Rollback transaction in case of error
            \DB::rollBack();

            // Redirect back with error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
