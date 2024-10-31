@extends('dashboard.layouts.app')

@section('content')
<div class="lg:ml-72 mt-4">
  <h1 class="my-4 font-bold text-xl">Manajemen Sampah - {{ Auth::user()->name }}</h1>
    <button type="button" onclick="toggleModal()"
        class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        Tambahkan Sampah
    </button>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow dark:bg-gray-800 w-1/3">
            <div class="px-6 py-4 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Data Sampah</h2>
                <button type="button" onclick="toggleModal()"
                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white absolute top-3 right-3 text-2xl font-bold">&times;</button>
            </div>
            <form action="{{ route('management.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="triggerFileInput()"
                        class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Upload dari File
                    </button>
                    <button type="button" onclick="openCamera()"
                        class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Ambil Foto
                    </button>
                </div>

                <input id="fileInput" name="picture" type="file" accept="image/*" class="hidden" />

                <div id="cameraContainer" class="flex items-center justify-center mt-4 hidden">
                    <video id="cameraStream" autoplay playsinline class="w-64 h-48 rounded-lg object-cover" style="transform: scaleX(-1);"></video>
                    <canvas id="cameraCapture" class="hidden"></canvas>
                </div>

                <div id="captureButtonContainer" class="flex justify-center mt-4 hidden">
                    <button type="button" onclick="capturePhoto()"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Ambil Gambar</button>
                </div>

                <!-- Preview Image -->
                <div id="imagePreviewContainer" class="flex items-center justify-center mt-4 hidden">
                    <img id="imagePreview" src="" alt="Preview" class="w-32 h-32 rounded-lg object-cover">
                </div>

                <!-- Progress bar -->
                <div id="uploadProgress" class="hidden w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                    <div id="progressBar" class="bg-green-500 h-2.5 rounded-full" style="width: 0%"></div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="toggleModal()"
                        class="text-gray-500 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">Batal</button>
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel sampah -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white dark:bg-gray-900">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Gambar Sampah</th>
                    <th scope="col" class="px-6 py-3">Label</th>
                    <th scope="col" class="px-6 py-3">Kadar CO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trashes as $index => $trash)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $index + 1 }}</th>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $trash->picture) }}" class="w-20 h-20 object-cover" alt="Trash Image">
                    </td>
                    <td class="px-6 py-4">{{ ucfirst($trash->label) }}</td>
                    <td class="px-6 py-4">{{ $trash->co }} CO</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    let videoStream;

    function toggleModal() {
        const modal = document.getElementById('modal');
        modal.classList.toggle('hidden');
        stopCamera();
    }

    function triggerFileInput() {
        document.getElementById('fileInput').click();
    }

    function openCamera() {
        const cameraContainer = document.getElementById('cameraContainer');
        const captureButtonContainer = document.getElementById('captureButtonContainer');

        cameraContainer.classList.remove('hidden');
        captureButtonContainer.classList.remove('hidden');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                videoStream = stream;
                const video = document.getElementById('cameraStream');
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing camera:', error);
            });
    }

    function capturePhoto() {
        const video = document.getElementById('cameraStream');
        const canvas = document.getElementById('cameraCapture');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const context = canvas.getContext('2d');
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0);

        const imageDataURL = canvas.toDataURL('image/png');
        imagePreview.src = imageDataURL;
        imagePreviewContainer.classList.remove('hidden');

        fetch(imageDataURL)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], 'captured-image.png', { type: 'image/png' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                const fileInput = document.getElementById('fileInput');
                fileInput.files = dataTransfer.files;
            });

        stopCamera();
    }

    function stopCamera() {
        const cameraContainer = document.getElementById('cameraContainer');
        const captureButtonContainer = document.getElementById('captureButtonContainer');

        cameraContainer.classList.add('hidden');
        captureButtonContainer.classList.add('hidden');

        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
        }
    }

    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
