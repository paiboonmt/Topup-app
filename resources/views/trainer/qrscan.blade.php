<x-app-layout>


    <div class="container py-2">
        {{-- <video id="video" autoplay></video>
        <canvas id="canvas"></canvas>
        <div id="output"></div>
        <script>
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const output = document.getElementById('output');
            const ctx = canvas.getContext('2d');

            // เข้าถึงกล้อง
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then((stream) => {
                    video.srcObject = stream;
                    video.play();
                    scanQRCode();
                })
                .catch((err) => {
                    console.error("เกิดข้อผิดพลาดในการเข้าถึงกล้อง:", err);
                });

            function scanQRCode() {
                // กำหนดขนาดของ canvas ตามวิดีโอ
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // วาดภาพจากวิดีโอลง canvas
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                // รับข้อมูล imageData จาก canvas
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

                // ใช้ jsQR ในการสแกน QR code
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    output.textContent = `QR Code Detected: ${code.data}`;
                } else {
                    output.textContent = 'No QR Code detected.';
                }

                // สแกนใหม่ทุก 500 มิลลิวินาที
                setTimeout(scanQRCode, 500);
            }
        </script> --}}
    </div>


    <div class="container">
        <div class="row">
            <div class="col mx-auto">
                <div class="card p-3">
                    <div class="card-header">
                        FORM
                    </div>
                    <div class="card-body">
                        <form action="{{ route('trainer.qrcheck') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Qrcode</label>
                                <input type="number" name="code" value="{{ session('code') }}" class="form-control" autofocus required>
                            </div>
                            <button type="submit" hidden class="btn btn-success col-12">Enter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-3">
            <div class="col mx-auto text-center">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <span class="text-danger">{{ session('old_card') }}</span>
                        <span class="text-danger">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('date_expiry'))
                    <div class="alert alert-danger" role="alert">
                        <span class="text-danger">หมายเลข : {{ session('card') }}</span>
                        <span class="text-danger">วันที่ : {{ date('d-m-Y', strtotime(session('expiry'))) }}</span>
                        <span class="text-danger">{{ session('date_expiry') }}</span>
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>
