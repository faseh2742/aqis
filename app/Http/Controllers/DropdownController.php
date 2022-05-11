<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dropdown;
use App\DropdownItem;

class DropdownController extends Controller
{
    public function index()
    {
        $dropdowns = Dropdown::with(['items' => function ($query) {
            $query->where('status', '=', 1)->orderBy('item', 'desc'); 
        }])->get();
         
        return $dropdowns;
    }

    public function show($id)
    {
        $dropdowndata = Dropdown::with(['items' => function ($query) {
            $query->orderBy('item', 'asc'); 
        }])->findOrFail($id);

        return $dropdowndata;
    }

    public function getDropdown($id)
    {
        $dropdown = Dropdown::with(['items' => function ($query) {
            $query->where('status', '=', 1)->orderBy('item', 'desc'); 
        }])->findOrFail($id);

        return $dropdown;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'item' => 'bail|required|unique:dropdown_items,item|string|max:255',
                'status' => 'required',
            ],

            [
                'item.unique' => 'This item already exists.'
            ]
        );

        $dropdown = Dropdown::findOrFail($request->dropdown_id);
        $dropdownItem = $dropdown->items()->create(
            [
                'item' => $request->item,
                'status' => $request->status,
            ]
            );

        return $dropdownItem;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'item' => 'bail|required|string|max:255|unique:dropdown_items,item,' . $id,
                'status' => 'required',
            ],

            [
                'item.unique' => 'This item already exists.'
            ]
        );
        $dropdownItem = DropdownItem::findOrFail($id);

        $dropdownItem->item = $request->item;
        $dropdownItem->status = $request->status;

        $dropdownItem->save();

        return $dropdownItem;
    }

    public function destroy($id)
    {
        $dropdownItem = DropdownItem::findOrFail($id);

        $dropdownItem->delete();

        return 204;
    }


}
