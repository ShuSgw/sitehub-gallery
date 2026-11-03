<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

use App\Services\GreetingService;

use App\Models\Category;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $greetingService = new GreetingService();
        $greeting = $greetingService->get();
        $user = Auth::user();
        $categories = $user->categories()->get();

        $siteId = $request->query('site');
        return view('category.index', compact(
            'greeting',
            'categories',
            'siteId'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->where('user_id', Auth::id()),
            ],
        ]);

        Auth::user()->categories()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');
    }

    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        abort_if($category->user_id !== Auth::id(), 403);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        abort_if($category->user_id !== Auth::id(), 403);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->where('user_id', Auth::id())->ignore($category->id),
            ],
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        abort_if($category->user_id !== Auth::id(), 403);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
