@extends('layout')
@section('title', 'Attendances')
@section('pagetitle', 'Attendances')

@section('main')
    <div class="p-6 bg-gray-50 min-h-[80%]">
        <div class="max-w-[80%] mx-auto bg-white shadow-2xl rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Attendance Records</h2>

                {{-- Filters --}}
                <div class="flex space-x-3 items-center">
                    <input type="date" id="filter-date"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#660B05] focus:outline-none" />

                    <select id="filter-level"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#660B05] focus:outline-none">
                        <option value="">All Levels</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level }}">{{ $level }}</option>
                        @endforeach
                    </select>
                    <a href=" {{ route('attendanceIndex') }} ">
                        <button class="bg-[#660B05] text-white px-4 py-2 rounded-lg hover:bg-[#4b0703] transition">
                            Clear
                        </button>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-[#660B05] text-white">
                        <tr>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Level</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Morning In</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Morning Out
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Morning Status
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Student Status
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Afternoon In
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Afternoon Out
                            </th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Afternoon
                                Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Student Status
                            </th>
                        </tr>
                    </thead>
                    <tbody id="attendance-table">
                        @forelse ($attendance as $at)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-800 font-medium text-center">{{ $at->name }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->level }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->date }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->time_in ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->time_out ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->student_status ?? 'Absent' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->status ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->pm_time_in ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->pm_time_out ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->student_pm_status ?? 'Absent' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-center">{{ $at->pm_status ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="py-4 text-center bg-white text-gray-500">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- AJAX Filter Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('filter-date');
            const levelSelect = document.getElementById('filter-level');
            const tableBody = document.getElementById('attendance-table');

            function fetchFilteredData() {
                const date = dateInput.value;
                const level = levelSelect.value;

                fetch(`{{ route('attendanceFilter') }}?date=${date}&level=${level}`)
                    .then(res => res.json())
                    .then(data => {
                        const attendance = data.attendance;
                        tableBody.innerHTML = '';

                        if (attendance.length === 0) {
                            tableBody.innerHTML =
                                `<tr><td colspan="11" class="py-4 text-center bg-white text-gray-500">No records found.</td></tr>`;
                            return;
                        }

                        attendance.forEach(at => {
                            tableBody.innerHTML += `
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-800 font-medium text-center">${at.name ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.level ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.date ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.time_in ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.time_out ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.student_status ?? 'Absent'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.status ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.pm_time_in ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.pm_time_out ?? '—'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.student_pm_status ?? 'Absent'}</td>
                                <td class="px-6 py-4 text-gray-600 text-center">${at.pm_status ?? '—'}</td>
                            </tr>`;
                        });
                    })
                    .catch(err => console.error(err));
            }

            dateInput.addEventListener('change', fetchFilteredData);
            levelSelect.addEventListener('change', fetchFilteredData);
        });
    </script>
@endsection
