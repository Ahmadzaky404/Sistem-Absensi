@extends('layouts.admin')

@section('title', 'Lokasi Absen')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>#attendance-map { height: 440px; border-radius: 8px; }</style>
@endpush

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="page-title h3 mb-1">Lokasi Absen</h1>
            <p class="text-secondary mb-0">Atur titik dan radius area yang diizinkan untuk absensi.</p>
        </div>
        <button type="button" class="btn btn-primary" id="use-current-location"><i class="fa-solid fa-location-crosshairs me-2"></i>Gunakan Lokasi Saya</button>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7"><div class="soft-card p-3"><div id="attendance-map" aria-label="Peta pengaturan lokasi absensi"></div></div></div>
        <div class="col-12 col-lg-5">
            <div class="soft-card p-4">
                <h2 class="h5 fw-bold mb-3" id="form-title">Tambah Lokasi</h2>
                <form method="POST" action="{{ route('admin.lokasi-absen.store') }}" id="location-form">
                    @csrf
                    <div id="method-field"></div>
                    <div class="mb-3"><label for="nama_lokasi" class="form-label">Nama Lokasi</label><input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" maxlength="100" required placeholder="Contoh: Kantor Pusat"></div>
                    <p class="small text-secondary mb-3" id="location-status" role="status" aria-live="polite"></p>
                    <div class="row g-3">
                        <div class="col-6"><label for="latitude" class="form-label">Latitude</label><input type="number" step="any" class="form-control" id="latitude" name="latitude" required></div>
                        <div class="col-6"><label for="longitude" class="form-label">Longitude</label><input type="number" step="any" class="form-control" id="longitude" name="longitude" required></div>
                    </div>
                    <div class="mt-3 mb-4"><label for="radius" class="form-label">Radius (meter)</label><input type="number" class="form-control" id="radius" name="radius" value="2000" min="10" max="100000" required></div>
                    <div class="d-flex gap-2"><button type="submit" class="btn btn-primary" id="save-button"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Lokasi</button><button type="button" class="btn btn-outline-secondary d-none" id="cancel-edit">Batal</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="soft-card p-4 mt-4">
        <h2 class="h5 fw-bold mb-3">Daftar Lokasi</h2>
        <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Nama</th><th>Koordinat</th><th>Radius</th><th class="text-end">Aksi</th></tr></thead><tbody>
            @forelse ($lokasiAbsens as $lokasi)
                @php($lokasiData = $lokasi->only(['id', 'nama_lokasi', 'latitude', 'longitude', 'radius']))
                <tr data-location="{{ \Illuminate\Support\Js::from($lokasiData) }}">
                    <td class="fw-semibold">{{ $lokasi->nama_lokasi }}</td><td>{{ number_format($lokasi->latitude, 7) }}, {{ number_format($lokasi->longitude, 7) }}</td><td>{{ number_format($lokasi->radius) }} m</td>
                    <td class="text-end"><button type="button" class="btn btn-sm btn-outline-primary edit-location" title="Ubah lokasi"><i class="fa-solid fa-pen"></i></button> <form class="d-inline" method="POST" action="{{ route('admin.lokasi-absen.destroy', $lokasi) }}" data-confirm-delete>@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus lokasi"><i class="fa-solid fa-trash"></i></button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-secondary py-4">Belum ada lokasi absensi yang diatur.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const locations = @json($lokasiAbsens->values());
        const defaultPoint = locations[0] || { latitude: -6.2, longitude: 106.816666 };
        const map = L.map('attendance-map').setView([defaultPoint.latitude, defaultPoint.longitude], locations.length ? 15 : 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
        let selectionMarker, selectionCircle;
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const radiusInput = document.getElementById('radius');
        const form = document.getElementById('location-form');
        const useCurrentLocationButton = document.getElementById('use-current-location');
        const locationStatus = document.getElementById('location-status');

        function setLocationStatus(message, isError = false) {
            locationStatus.textContent = message;
            locationStatus.classList.toggle('text-danger', isError);
            locationStatus.classList.toggle('text-secondary', !isError);
        }

        function drawSelection(latitude, longitude) {
            if (selectionMarker) map.removeLayer(selectionMarker);
            if (selectionCircle) map.removeLayer(selectionCircle);
            selectionMarker = L.marker([latitude, longitude]).addTo(map);
            selectionCircle = L.circle([latitude, longitude], { radius: Number(radiusInput.value || 0), color: '#2563EB', fillOpacity: 0.1 }).addTo(map);
        }
        function setPoint(latitude, longitude, center = true) {
            latitudeInput.value = Number(latitude).toFixed(7); longitudeInput.value = Number(longitude).toFixed(7);
            drawSelection(latitude, longitude); if (center) map.setView([latitude, longitude], 16);
        }
        locations.forEach((location) => {
            L.marker([location.latitude, location.longitude]).bindPopup(`<strong>${location.nama_lokasi}</strong><br>Radius: ${location.radius} m`).addTo(map);
            L.circle([location.latitude, location.longitude], { radius: location.radius, color: '#16A34A', fillOpacity: 0.06 }).addTo(map);
        });
        map.on('click', (event) => setPoint(event.latlng.lat, event.latlng.lng, false));
        radiusInput.addEventListener('input', () => { if (latitudeInput.value && longitudeInput.value) drawSelection(latitudeInput.value, longitudeInput.value); });
        function geolocationErrorMessage(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    return 'Izin lokasi ditolak. Izinkan lokasi untuk situs ini melalui ikon gembok di address bar, lalu coba lagi.';
                case error.POSITION_UNAVAILABLE:
                    return 'Lokasi belum tersedia. Aktifkan layanan lokasi/GPS perangkat, lalu coba lagi.';
                case error.TIMEOUT:
                    return 'Pengambilan lokasi melebihi batas waktu. Pastikan sinyal GPS memadai, lalu coba lagi.';
                default:
                    return 'Lokasi GPS tidak dapat diambil. Silakan coba lagi.';
            }
        }

        useCurrentLocationButton.addEventListener('click', () => {
            if (!window.isSecureContext) {
                setLocationStatus('GPS hanya dapat digunakan melalui HTTPS atau localhost. Buka aplikasi dengan HTTPS, lalu coba lagi.', true);
                return;
            }

            if (!navigator.geolocation) {
                setLocationStatus('Browser atau perangkat ini tidak mendukung pengambilan lokasi GPS.', true);
                return;
            }

            useCurrentLocationButton.disabled = true;
            setLocationStatus('Meminta lokasi perangkat…');

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
                        setLocationStatus('Koordinat GPS tidak valid. Silakan coba lagi.', true);
                    } else {
                        setPoint(latitude, longitude);
                        setLocationStatus('Lokasi berhasil digunakan.');
                    }
                    useCurrentLocationButton.disabled = false;
                },
                (error) => {
                    setLocationStatus(geolocationErrorMessage(error), true);
                    useCurrentLocationButton.disabled = false;
                },
                { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 }
            );
        });
        document.querySelectorAll('.edit-location').forEach((button) => button.addEventListener('click', () => {
            const location = JSON.parse(button.closest('tr').dataset.location);
            document.getElementById('form-title').textContent = 'Ubah Lokasi'; document.getElementById('nama_lokasi').value = location.nama_lokasi; radiusInput.value = location.radius;
            form.action = `{{ url('/admin/lokasi-absen') }}/${location.id}`;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('save-button').innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan'; document.getElementById('cancel-edit').classList.remove('d-none'); setPoint(location.latitude, location.longitude);
        }));
        document.getElementById('cancel-edit').addEventListener('click', () => window.location.reload());
    </script>
@endpush
