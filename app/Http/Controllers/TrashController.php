<?php

namespace App\Http\Controllers;

use App\Models\Trash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TrashController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $trashes = Trash::where('user_id', $userId)->get();

        return view('dashboard.pages.management', compact('trashes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = $request->file('picture')->store('uploads', 'public');

        $userId = Auth::id();

        $labelOptions = ['organic', 'anorganic'];
        $label = Arr::random($labelOptions);

        $co = 0;
        if ($label === 'organic') {
            $co = 0.1;
        } else if ($label === 'anorganic') {
            $co = 0.2;
        }

        Trash::create([
            'picture' => $imagePath,
            'label' => $label,
            'co' => $co,
            'user_id' => $userId,
        ]);

        Alert::success('Success', 'Kamu Berhasil Menambahkan data sampah dengan label ' . $label);

        return redirect()->route('management')->with('success', 'Data sampah berhasil disimpan');
    }
}
