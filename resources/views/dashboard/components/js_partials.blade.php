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