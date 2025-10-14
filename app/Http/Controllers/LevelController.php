<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{

    public function index()
    {

        $grade = Level::orderByRaw('CAST(level AS UNSIGNED) ASC')->paginate(5);


        return view('level.index', compact('grade'));
    }

    public function add(Request $request)
    {

        $request->validate([
            'level' => 'required',
        ]);



        if (Level::create($request->all())) {
            return back()->with('success', 'Added successfully');
        }
        return back()->with('error', 'Failed to add');
    }

    public function edit($id, Level $level)
    {
        $level = Level::findOrFail($id);
        return view('level.edit', compact('level'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'level'
        ]);

        $level = Level::findOrFail($id);

        if ($level->update($request->all())) {
            return redirect()->route('level')->with('success', 'Updated successfully');
        }
        return redirect()->route('level')->with('error', 'Update failed');
    }
}
