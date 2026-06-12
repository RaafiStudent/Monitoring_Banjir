<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Banjir</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #222; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 0; padding: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .status-bahaya { color: red; font-weight: bold; }
        .status-siaga { color: orange; font-weight: bold; }
        .status-waspada { color: #b8860b; font-weight: bold; }
        .status-aman { color: green; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>BADAN PENANGGULANGAN BENCANA DAERAH (BPBD) KOTA TEGAL</h2>
        <h3>LAPORAN MONITORING SISTEM PERINGATAN DINI BANJIR</h3>
        <p>Lokasi Observasi: Desa Kaligangsa, Kecamatan Margadana</p>
    </div>

    <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Rekam</th>
                <th>Ketinggian Air (CM)</th>
                <th>Status Ketinggian</th>
                <th>Curah Hujan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $row->water_level }} cm</td>
                <td class="
                    @if($row->status == 'BAHAYA') status-bahaya
                    @elseif($row->status == 'SIAGA') status-siaga
                    @elseif($row->status == 'WASPADA') status-waspada
                    @else status-aman @endif
                ">
                    {{ $row->status }}
                </td>
                <td>{{ $row->rain_status }} ({{ $row->rain_value }} mm)</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>