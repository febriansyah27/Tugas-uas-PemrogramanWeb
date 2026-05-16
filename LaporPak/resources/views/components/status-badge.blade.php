{{-- 
    Komponen Badge Status Pengaduan
    Usage: <x-status-badge :status="$pengaduan->status" />
--}}
@props(['status'])

@php
    $config = match($status) {
        'terkirim' => ['color' => 'bg-blue-100 text-blue-800 border-blue-200',   'icon' => '📤', 'label' => 'Terkirim'],
        'diproses' => ['color' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => '⚙️', 'label' => 'Diproses'],
        'selesai'  => ['color' => 'bg-green-100 text-green-800 border-green-200',  'icon' => '✅', 'label' => 'Selesai'],
        'ditolak'  => ['color' => 'bg-red-100 text-red-800 border-red-200',       'icon' => '❌', 'label' => 'Ditolak'],
        default    => ['color' => 'bg-gray-100 text-gray-800 border-gray-200',    'icon' => '❓', 'label' => ucfirst($status)],
    };
@endphp

<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $config['color'] }}">
    {{ $config['icon'] }} {{ $config['label'] }}
</span>
