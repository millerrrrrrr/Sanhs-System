@extends('layout')
@section('title', 'Qr Tester')
@section('pagetitle', 'Qr Tester')

@section('main')
<div class="flex flex-col items-center justify-center h-[80%]">
    <h1 class="text-2xl font-bold mb-6">QR Code Scanner (Test Mode)</h1>

    <!-- QR Scanner -->
    <div id="qr-reader" class="mb-4 w-[500px] max-h-[80vh]"></div>

    <!-- Scanned LRN Display -->
    <div id="qr-result" class="hidden mt-4 text-left">
        <p class="text-lg">Scanned LRN: 
            <span id="scanned-data" class="font-semibold text-blue-600"></span>
        </p>
    </div>

    <!-- Student Info -->
    <div id="user-info" class="mt-4 text-left"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const qrRegionId = "qr-reader";
    const html5QrCode = new Html5Qrcode(qrRegionId);
    let isProcessing = false;
    let lastScanTimes = {};
    const SCAN_COOLDOWN = 10000; // 10 seconds cooldown for same LRN

    const startScanner = () => {
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            async (decodedText) => {
                const now = Date.now();

                // Prevent rapid duplicate scans for the same QR
                if (lastScanTimes[decodedText] && (now - lastScanTimes[decodedText] < SCAN_COOLDOWN)) {
                    console.log(`Cooldown active for ${decodedText}`);
                    return;
                }

                if (isProcessing) return;
                isProcessing = true;
                lastScanTimes[decodedText] = now;

                // Display scanned LRN
                document.getElementById("qr-result").classList.remove("hidden");
                document.getElementById("scanned-data").innerText = decodedText;

                const container = document.getElementById("user-info");
                container.innerHTML = `<p class="text-gray-500 italic">Fetching student info...</p>`;

                try {
                    const response = await fetch(`qrTester/get-student/${decodedText}`, { method: "GET" });
                    const data = await response.json();

                    if (!data.success) {
                        container.innerHTML = `<p class="text-red-500 font-semibold">${data.message || "Student not found."}</p>`;
                    } else {
                        const s = data.student;
                        container.innerHTML = `
                            <div class="bg-gray-100 p-5 rounded-lg shadow-inner border-2 border-green-500 animate-flash">
                                <h3 class="text-2xl font-semibold text-center mb-3">${s.name}</h3>
                                <div class="space-y-1 text-lg">
                                    <p><strong>LRN:</strong> ${s.lrn}</p>
                                    <p><strong>Age:</strong> ${s.age}</p>
                                    <p><strong>Gender:</strong> ${s.gender}</p>
                                    <p><strong>Address:</strong> ${s.address}</p>
                                    <p><strong>Level:</strong> ${s.level}</p>
                                    <p><strong>Guardian:</strong> ${s.guardian}</p>
                                    <p><strong>Email:</strong> ${s.email}</p>
                                </div>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error("Error fetching student info:", error);
                    container.innerHTML = `<p class="text-red-500">Server error retrieving student info.</p>`;
                } finally {
                    // Flash border animation for feedback
                    flashBorder(container);
                    isProcessing = false;
                }
            },
            (errorMessage) => {
                // Ignore scan noise
            }
        );
    };

    function flashBorder(container) {
        container.classList.add("animate-flash");
        setTimeout(() => container.classList.remove("animate-flash"), 500);
    }

    startScanner();
});
</script>

<style>
@keyframes flash {
  0% { border-color: transparent; }
  50% { border-color: #22c55e; } /* Green flash */
  100% { border-color: transparent; }
}
.animate-flash {
  animation: flash 0.5s ease-out;
}
</style>
@endpush
