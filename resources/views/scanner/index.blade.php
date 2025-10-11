@extends('scannerLayout')
@section('title', 'Attendance Scanner')
@section('pagetitle', 'Attendance Scanner')

@section('main')
<div class="flex flex-col md:flex-row gap-6 p-6">
    {{-- LEFT SIDE: QR SCANNER --}}
    <div class="w-full md:w-1/2 flex flex-col items-center justify-center bg-white rounded-lg shadow p-4">
        <h2 class="text-xl font-semibold mb-4">Scan Student QR Code</h2>
        <div id="qr-reader" class="w-full max-w-[400px] max-h-[80vh]"></div>
        <div id="qr-result" class="hidden mt-4 text-center">
            <p class="text-lg">Scanned LRN: <span id="scanned-data" class="font-semibold text-blue-600"></span></p>
        </div>
    </div>

    {{-- RIGHT SIDE: STUDENT INFO + ATTENDANCE DETAILS --}}
    <div class="w-full md:w-1/2 bg-white rounded-lg shadow p-4">
        <h2 class="text-xl font-semibold mb-4 text-center">Student Attendance Details</h2>
        <div id="student-info" class="text-left space-y-2">
            <p class="text-gray-500 italic text-center">Scan a QR code to display student details...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const qrRegionId = "qr-reader";
    const html5QrCode = new Html5Qrcode(qrRegionId);
    
    let isProcessing = false;
    let lastScanTimes = {}; // store cooldowns per LRN (student)

    const SCAN_COOLDOWN = 10000; // 10 seconds

    const startScanner = () => {
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            async (decodedText) => {
                const now = Date.now();

                // 🔹 Cooldown per student (same QR)
                if (lastScanTimes[decodedText] && (now - lastScanTimes[decodedText] < SCAN_COOLDOWN)) {
                    console.log(`Cooldown active for ${decodedText}`);
                    return;
                }

                if (isProcessing) return;
                isProcessing = true;
                lastScanTimes[decodedText] = now; // mark scan time for this QR

                document.getElementById("qr-result").classList.remove("hidden");
                document.getElementById("scanned-data").innerText = decodedText;

                const container = document.getElementById("student-info");
                container.innerHTML = `<p class="text-gray-500 italic">Recording attendance...</p>`;

                try {
                    // 🔹 AJAX fetch (no page reload)
                    const response = await fetch(`scanner/attendance/record/${decodedText}`, { method: "GET" });
                    const data = await response.json();

                    if (!data.success) {
                        container.innerHTML = `<p class="text-red-500 font-semibold">${data.message}</p>`;
                    } else {
                        const student = data.student;
                        const attendance = data.attendance;

                        // 🔹 Local PH Time
                        const phTime = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
                        const date = new Date(phTime);
                        const hours = date.getHours();
                        let greeting = "Good morning";
                        if (hours >= 12 && hours < 18) greeting = "Good afternoon";
                        else if (hours >= 18) greeting = "Good evening";

                        container.innerHTML = `
                            <div class="bg-gray-50 p-6 rounded-lg shadow-inner animate-fadeIn">
                                <h3 class="text-2xl font-semibold text-center mb-2">${greeting}, ${student.name}!</h3>
                                <hr class="my-3">
                                <div class="space-y-2 text-lg">
                                    <p><strong>Status:</strong> 
                                        <span class="${
                                            attendance.status === 'Present' ? 'text-green-600' :
                                            attendance.status === 'Late' ? 'text-yellow-600' :
                                            attendance.status === 'Left' ? 'text-blue-600' :
                                            'text-gray-600'
                                        } font-semibold">${attendance.status}</span>
                                    </p>
                                    <p><strong>Time In:</strong> ${attendance.time_in || '-'}</p>
                                    <p><strong>Time Out:</strong> ${attendance.time_out || '-'}</p>
                                </div>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error("Error fetching student info:", error);
                    container.innerHTML = `<p class="text-red-500">Server error while recording attendance.</p>`;
                } finally {
                    isProcessing = false;
                }
            },
            (errorMessage) => {
                // Optional: ignore scanning noise
            }
        );
    };

    startScanner();
});
</script>

<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.5s ease-out;
}
</style>
@endpush
