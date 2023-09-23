<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubType;
use App\Models\Type;

class SubTypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        $sub_types = SubType::all();
        $data = compact('sub_types', 'types');
        return view('sub_types.index')->with($data);
    }
    public function create(Request $request)
    {
        $sub_type = new SubType();
        $sub_type->type_id = $request->type;
        $sub_type->name = $request->name;
        $sub_type->save();
        return redirect()->back()->with('success', 'Sub Type Added Successfully');
    }
    public function delete($id)
    {
        $sub_type = SubType::find($id);
        $sub_type->delete();
        return redirect()->back()->with('success', 'Sub Type Deleted Successfully');
    }
    public function update(Request $request, $id)
    {
        $sub_type = SubType::find($id);
        $sub_type->type_id = $request->type;
        $sub_type->name = $request->name;
        $sub_type->save();
        return redirect()->back()->with('success', 'Sub Type Updated Successfully');
    }
    public function get_sub_type_by_type($id)
    {
        $sub_types = SubType::where('type_id', $id)->get();
        return response()->json($sub_types);
    }
}
