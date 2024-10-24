<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wellcome :
            {{ Auth::user()->name }}
        </h2>
    </x-slot>



    <div class="container py-2">

        <video id="video" autoplay></video>
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
        </script>


        <div class="row">
            <div class="col">
                <div class="card p-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
