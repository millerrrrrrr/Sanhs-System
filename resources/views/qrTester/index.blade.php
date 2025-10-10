@extends('layout')
@section('title', 'Qr Tester')
@section('pagetitle', 'Qr Tester')
@section('main')

    <div class="flex flex-col items-center justify-center h-[80%]">
        <h1 class="text-2xl font-bold mb-6">QR Code Scanner</h1>

        <div id="qr-reader" class="mb-4 w-[500px] max-h-[80vh]"></div>

        <div id="qr-result" class="hidden mt-4 text-left">
            <p class="text-lg">Scanned LRN: <span id="scanned-data" class="font-semibold"></span></p>
        </div>

        <div id="user-info" class="mt-4 text-left">
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
       
        // Function to initialize the QR Code scanner
        const startQrScanner = () => {
            const qrScanner = new Html5QrcodeScanner(
                "qr-reader", // ID of the div where the scanner will be placed
                {
                    fps: 10, // Frames per second (scan rate)
                    qrbox: 250, // Size of the QR scanning box
                    facingMode: "environment", // Use the back camera (default)
                    showScanRegion: false, // Optional: hides the scan region UI
                    showResultButton: false, // Optional: hides the result button (Start Scanning)
                    disableScanIfNotAllowed: true, // Disable the scanner if camera permissions aren't granted
                },
                false // Whether to use the scan region to highlight the QR box
            );

            qrScanner.render(
                (decodedText, decodedResult) => {
                    // Handle the successful QR code scan
                    document.getElementById("qr-result").classList.remove("hidden");
                    document.getElementById("scanned-data").innerText = decodedText;

                    // Send the LRN to the backend to fetch student information
                    fetch(`qrTester/get-student/${decodedText}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show the student's data below the scanner
                                document.getElementById("user-info").innerHTML = `
                            <div class="bg-gray-100 p-4 rounded-md shadow-lg">
                                <p><strong>Name:</strong> ${data.student.name}</p>
                                <p><strong>Age:</strong> ${data.student.age}</p>
                                <p><strong>Gender:</strong> ${data.student.gender}</p>
                                <p><strong>Address:</strong> ${data.student.address}</p>
                                <p><strong>Level:</strong> ${data.student.level}</p>
                                <p><strong>Guardian:</strong> ${data.student.guardian}</p>
                                <p><strong>Email:</strong> ${data.student.email}</p>
                            </div>
                        `;
                            } else {
                                document.getElementById("user-info").innerHTML =
                                    "<p class='text-red-500'>Student not found</p>";
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching student info:", error);
                            document.getElementById("user-info").innerHTML =
                                "<p class='text-red-500'>Error retrieving student info</p>";
                        });

                    // Optionally stop the scanner or keep it running
                    // qrScanner.clear(); // Uncomment if you want to stop after one scan
                },
                (errorMessage) => {
                    // Handle scanning errors (you can log it or show a message)
                    console.error("Error while scanning:", errorMessage);
                }
            );
        };

        // Call the startQrScanner function automatically when the page is loaded
        document.addEventListener("DOMContentLoaded", () => {
            // Automatically start the QR scanner without user interaction
            startQrScanner();
        });
    </script>
@endpush
