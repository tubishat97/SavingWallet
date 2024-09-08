<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['name' => __('Products')],
        ];

        $pageConfigs = ['pageHeader' => true];

        $addNewBtn = "admin.product.create";

        return view('backend.products.list', compact('breadcrumbs', 'pageConfigs', 'products', 'addNewBtn'));
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
            ['name' => __('Products'),],
        ];

        return view('backend.products.add', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->save();

        $product->incrementQuantity($request->quantity);


        return redirect()->route('admin.product.index')->with('success', __('system-messages.add'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['link' => "admin/product", 'name' => __('Products')],
            ['name' => $product->name,],
        ];

        return view('backend.products.show', compact('product', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            $product->name = $request->name;
            $product->save();

            return redirect(route('admin.product.show', $product))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('admin.product.index'))->with('success', __('system-messages.delete'));
    }

    public function incrementQuantity(Request $request, Product $product)
    {
        $product->incrementQuantity($request->quantity);

        return redirect()->route('admin.product.index')->with('success', __('system-messages.add'));
    }

    public function incrementQuantityShow(Product $product)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['link' => "admin/product", 'name' => __('Products')],
            ['name' => 'Add Qty: ' . $product->name,],
        ];

        return view('backend.products.increment-quantity-show', compact('product', 'breadcrumbs'));
    }

    public function log(Request $request, Product $product)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => __('Dashboard')],
            ['link' => "admin/product", 'name' => __('Products')],
            ['name' => 'History Log'],
        ];

        // Initialize query builder
        $logsQuery = ProductLog::orderBy('created_at', 'desc');

        $start = $request->start_date;
        $end = $request->end_date;
        $product = $request->product;

        if (!empty($product)) {
            $logsQuery->where('product_id', $product);
        }

        if (!empty($start) && empty($end)) {
            $logsQuery->whereDate('created_at', '>=', $start);
        }

        if (!empty($end) && empty($start)) {
            $logsQuery->whereDate('created_at', '<=', $end);
        }

        if (!empty($start) && !empty($end)) {
            $logsQuery->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }
        

        // Execute the query to get the logs
        $logs = $logsQuery->get();

        $products = Product::all();

        return view('backend.products.log', compact('logs', 'products', 'breadcrumbs'));
    }
}
