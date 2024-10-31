@extends('dashboard.layouts.app')

@section('content')
    <div class="lg:ml-72 mt-4">
      <h1 class="my-4 font-bold text-xl">Selamat Datang {{ Auth::user()->name }} di Dashboard BersihBersama✋</h1>
        
        <div class="flex gap-x-4">
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">🗑️🗑️Total Sampah :</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Kamu sudah menambahkan sampah sebanyak <strong>{{ $totalTrash }}</strong></p>
            </a>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">🪣🪣Total Sampah Anorganik</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Sampah Anorganik yang sudah kamu tambahkan sebanyak <strong>{{ $totalAnorganic }}</strong></p>
            </a>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">♻️♻️Total Sampah Organik</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Sampah Organik yang sudah kamu tambahkan sebanyak <strong>{{ $totalOrganic }}</strong></p>
            </a>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">🦠🦠Total Kadar Udara yang kamu selamatkan :</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Dengan tidak membakar sampah ini kamu sudah menyelamatkan kadar udara sebanyak <strong>{{ $totalCO }} Co</strong></p>
            </a>
        </div>
    </div>
@endsection
