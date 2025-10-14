<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <div style="background: #fff; padding: 20px; border-radius: 8px;">
        <h2>Attendance Update for {{ $student->name }}</h2>
        <p>Dear Guardian,</p>

        <p>
            This is to inform you that <strong>{{ $student->name }}</strong> (LRN: {{ $student->lrn }})
            has just scanned their QR code.
        </p>

        <p>
            <strong>Session:</strong> {{ $attendance['session'] }} <br>
            <strong>Status:</strong> {{ $attendance['status'] }} <br>
            <strong>Current:</strong> {{ $attendance['current'] }} <br>
            <strong>Time In:</strong> {{ $attendance['time_in'] ?? '-' }} <br>
            <strong>Time Out:</strong> {{ $attendance['time_out'] ?? '-' }} <br>
        </p>

        <p>
            Message: <em>{{ $attendance['message'] }}</em>
        </p>

        <p>Thank you,<br>{{ config('app.name') }} Attendance System</p>
    </div>
</body>
</html>
