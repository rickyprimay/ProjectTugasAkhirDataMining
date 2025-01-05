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

        $urlPredicted = "http://127.0.0.1:5000/predict";

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = $request->file('picture')->store('uploads', 'public');

        $userId = Auth::id();

        $file = new \CURLFile(storage_path("app/public/" . $imagePath));
        $data = [
            'file' => $file,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlPredicted);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            Alert::error('Error', 'Gagal melakukan prediksi');
            return redirect()->back();
        }

        $responseData = json_decode($response, true);
        $predictedClass = $responseData['predicted_class'] ?? null;

        if ($predictedClass == 0) {
            $label = 'organic';
            $co = 0.1;
        } elseif ($predictedClass == 1) {
            $label = 'anorganic';
            $co = 0.2;
        } else {
            $label = 'unknown';
            $co = 0.0;
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
