<?php

namespace App\Http\Controllers;

use App\Category;
use App\Outcome;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('referrals', 'outcomes')->get();

        return $categories;
    }

    public function show($name)
    {
        $category = Category::with('referrals')->where('name', '===', $name);

        return $category;
    }

    public function getOutcomes($id)
    {
        $categories = Category::with(['outcomes'])->findOrFail($id);

        return $categories;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'outcome' => 'bail|required|unique:outcomes,outcome|string',
                'status' => 'required',
            ],

            [
                'outcome.unique' => 'This outcome already exists.'
            ]
        );

        $category = Category::findOrFail($request->category_id);
        $outcome = $category->outcomes()->create(
            [
                'outcome' => $request->outcome,
                'status' => $request->status,
            ]
            );

        return $outcome;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'outcome' => 'bail|required|string|unique:outcomes,outcome,'.$id,
                'status' => 'required',
            ],

            [
                'outcome.unique' => 'This outcome already exists.'
            ]
        );
        $outcome = Outcome::findOrFail($id);

        $outcome->outcome = $request->outcome;
        $outcome->status = $request->status;

        $outcome->save();

        return $outcome;
    }

    public function destroy($id)
    {
        $outcome = Outcome::findOrFail($id);

        $outcome->delete();

        return 204;
    }
}
