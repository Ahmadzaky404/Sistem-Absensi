@php
    $warnaGrafik = ['Hadir' => '#16A34A', 'Izin' => '#EAB308', 'Sakit' => '#DC2626', 'Dinas Luar' => '#2563EB'];
    $nilaiHariIni = collect($grafikKehadiran['series'])->map(fn ($nilai) => $nilai[0] ?? 0);
    $nilaiMaksimum = max(array_merge([1], array_values($nilaiHariIni->all())));
@endphp
@php
    $lebarGrafik = 320;
    $tinggiGrafik = 90;
    $posisiGrafik = [];
    foreach (array_keys($warnaGrafik) as $indeks => $kategori) {
        $posisiGrafik[] = [
            'kategori' => $kategori,
            'x' => 28 + ($indeks * 88),
            'y' => 20 + (50 - (($nilaiHariIni[$kategori] / $nilaiMaksimum) * 50)),
        ];
    }
    $jalurGrafik = 'M '.$posisiGrafik[0]['x'].','.$posisiGrafik[0]['y'];
    foreach (array_slice($posisiGrafik, 1) as $indeks => $titik) {
        $sebelumnya = $posisiGrafik[$indeks];
        $jarakKontrol = ($titik['x'] - $sebelumnya['x']) / 2;
        $jalurGrafik .= ' C '.($sebelumnya['x'] + $jarakKontrol).','.$sebelumnya['y'].' '.($titik['x'] - $jarakKontrol).','.$titik['y'].' '.$titik['x'].','.$titik['y'];
    }
@endphp
<div role="img" aria-label="Grafik kurva kehadiran hari ini">
    <svg viewBox="0 0 {{ $lebarGrafik }} {{ $tinggiGrafik }}" class="w-100" style="height: 90px;">
        <line x1="20" y1="70" x2="300" y2="70" stroke="#E5E7EB" stroke-width="1" />
        <path d="{{ $jalurGrafik }}" fill="none" stroke="#2563EB" stroke-width="3" stroke-linecap="round" />
        @foreach ($posisiGrafik as $titik)
            <circle cx="{{ $titik['x'] }}" cy="{{ $titik['y'] }}" r="4" fill="{{ $warnaGrafik[$titik['kategori']] }}" />
            <text x="{{ $titik['x'] }}" y="{{ $titik['y'] - 8 }}" text-anchor="middle" fill="#334155" font-size="10" font-weight="600">{{ $nilaiHariIni[$titik['kategori']] }}</text>
            <text x="{{ $titik['x'] }}" y="{{ $tinggiGrafik - 10 }}" text-anchor="middle" fill="#64748B" font-size="9">{{ $titik['kategori'] }}</text>
        @endforeach
    </svg>
</div>
