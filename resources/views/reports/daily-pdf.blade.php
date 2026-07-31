<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daily Complaints Report</title>
    <style>
        @page { margin: 24px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            background: #9a9a9a;
        }
        .wrap {
            background: #9a9a9a;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 18px;
        }
        .header img {
            width: 70px;
            height: 70px;
            margin-bottom: 6px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1f5c3a;
        }
        .header h2 {
            margin: 4px 0 0;
            font-size: 13px;
            font-weight: normal;
            color: #1f5c3a;
        }
        .header h3 {
            margin: 10px 0 0;
            font-size: 15px;
            color: #1f5c3a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th {
            background: #1f5c3a;
            color: #fff;
            padding: 8px 6px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 7px 6px;
            border: 1px solid #666;
            font-size: 10px;
        }
        tr:nth-child(even) td {
            background: #d9d9d9;
        }
        tr:nth-child(odd) td {
            background: #efefef;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            <h1>Complaint Management System</h1>
            <h2>Ministry of Agriculture, Republic of Somaliland</h2>
            <h3>Daily Complaints Report: {{ $reportLabel }}</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Complainant</th>
                    <th>Phone</th>
                    <th>Region</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->complainant_name }}</td>
                        <td>{{ $complaint->phone }}</td>
                        <td>{{ $complaint->region }}</td>
                        <td>{{ $complaint->department }}</td>
                        <td>{{ $complaint->status }}</td>
                        <td>{{ $complaint->priority }}</td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;">No complaints for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
