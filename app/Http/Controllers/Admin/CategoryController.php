<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $categories = $user->categories;

        $breadcrumbs = [
            ['link' => "admin", 'name' => 'Dashboard'], ['name' => 'Categories'],
        ];

        $addNewBtn = "admin.category.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.categories.list', compact('categories', 'pageConfigs', 'breadcrumbs', 'addNewBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => 'Dashboard'], ['link' => "admin/category", 'name' =>  'Categories'], ['name' => __('Create')]
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.categories.add', compact(['pageConfigs', 'breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategoryRequest $request)
    {
        try {
            $user = auth()->user();

            $category = new Category();
            $category->user_id = $user->id;
            $category->name = $request->name;
            $category->save();

            return redirect(route('admin.category.show', $category))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => 'Dashboard'], ['link' => "admin/category", 'name' =>  'Categories'], ['name' => 'Update']
        ];

        return view('backend.categories.show', compact(['category', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->name = $request->name;
            $category->save();

            return redirect(route('admin.category.show', $category))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('admin.category.index'))->with('success', __('system-messages.delete'));
    }
}
