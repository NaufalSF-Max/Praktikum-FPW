<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="overflow-x-auto">

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-500">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-
            center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
            </form>

            <a href="{{ route('product-create')}}">
                <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Add product data
                </button>
            </a>
            <a href="{{ route('product-export-excel') }}">Export ke Excel</a>
            <a href="{{ route('product-export-pdf') }}" class="ml-2">Export ke PDF</a>
            <button id="export-jpg-btn" class="ml-2">Export ke JPG</button>

            <table class="min-w-full border border-collapse border-gray-200">

                <thead>
                    <tr class="bg-gray-100">
                        
                        @php
                            $direction_toggle = $direction == 'asc' ? 'desc' : 'asc';
                        @endphp

                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'id', 'direction' => ($sort == 'id') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                ID
                                @if($sort == 'id') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'product_name', 'direction' => ($sort == 'product_name') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Product Name
                                @if($sort == 'product_name') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'unit', 'direction' => ($sort == 'unit') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Unit
                                @if($sort == 'unit') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'type', 'direction' => ($sort == 'type') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Type
                                @if($sort == 'type') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'information', 'direction' => ($sort == 'information') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Information
                                @if($sort == 'information') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'qty', 'direction' => ($sort == 'qty') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Qty
                                @if($sort == 'qty') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product-index', ['sort' => 'producer', 'direction' => ($sort == 'producer') ? $direction_toggle : 'asc', 'search' => request('search')]) }}">
                                Producer
                                @if($sort == 'producer') <span>{{ $direction == 'asc' ? '▲' : '▼' }}</span> @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="bg-white">
                            <td class="px-4 py-2 border border-gray-200">{{ $item->id }}</td>
                            <td class="px-4 py-2 border border-gray-200 hover:text-blue-500 hover:underline">
                                <a href="{{ route('product-detail', $item->id) }}">
                                    {{$item->product_name }}
                                </a>
                            </td>
                            <td class="px-4 py-2 border border-gray-200">{{$item->unit }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{$item->type }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{$item->information }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{$item->qty }}</td>
                            <td class="px-4 py-2 border border-gray-200">{{$item->producer }}</td>
                            <td class="px-4 py-2 border border-gray-200">
                                <a href="{{ route('product-edit', $item->id) }}"
                                    class="px-2 text-blue-600 hover:text-blue-800">Edit</a>
                                <button class="px-2 text-red-600 hover:text-red-800"
                                    onclick="confirmDelete('{{ route('product-deleted', $item->id) }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <p class="mb-4 tect-center text-2xl font-bold text-red-600"> No Products Found</p>
                    @endforelse
                    <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="mt-4">
                {{-- Ini sudah otomatis membawa parameter search, sort, dan direction --}}
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <script>
        // Pastikan DOM sudah dimuat
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Temukan tombol yang kita buat
        const exportBtn = document.getElementById('export-jpg-btn');

        // 2. Tambahkan event listener saat di-klik
        exportBtn.addEventListener('click', function() {
            
            exportBtn.textContent = 'Membuat JPG...';
            exportBtn.disabled = true;

            // 3. Ambil HTML laporan dari server
            fetch("{{ route('product-export-html') }}")
                .then(response => response.json())
                .then(data => {
                    const reportHtml = data.html;

                    // 4. Buat <iframe>, BUKAN <div>
                    const iframe = document.createElement('iframe');
                    iframe.style.position = 'absolute';
                    iframe.style.left = '-9999px'; // Sembunyikan di luar layar
                    iframe.style.border = 'none';
                    document.body.appendChild(iframe);

                    // 5. Tulis HTML lengkap ke dalam dokumen iframe
                    iframe.contentWindow.document.open();
                    iframe.contentWindow.document.write(reportHtml);
                    iframe.contentWindow.document.close();

                    // 6. PENTING: Tunggu iframe selesai memuat HTML dan style
                    iframe.onload = function() {
                        
                        // 7. Target elemen <body> DI DALAM iframe
                        // Ini adalah elemen yang valid dan memiliki style
                        const elementToCapture = iframe.contentWindow.document.body;
                        
                        // Atur ukuran iframe agar pas dengan kontennya
                        iframe.width = elementToCapture.scrollWidth + 'px';
                        iframe.height = elementToCapture.scrollHeight + 'px';

                        // 8. Jalankan html2canvas pada elemen <body> iframe
                        html2canvas(elementToCapture, { 
                            useCORS: true, 
                            scale: 1.5 // Skala agar gambar lebih jernih
                        }).then(canvas => {
                            // 9. Buat link download dari hasil canvas
                            const link = document.createElement('a');
                            link.download = 'rekap-mutasi-stock.jpg';
                            link.href = canvas.toDataURL('image/jpeg');
                            link.click(); // Picu download

                            // 10. Bersihkan (hapus iframe)
                            document.body.removeChild(iframe);
                            exportBtn.textContent = 'Export ke JPG';
                            exportBtn.disabled = false;
                        });
                    };
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal membuat JPG.');
                    exportBtn.textContent = 'Export ke JPG';
                    exportBtn.disabled = false;
                });
        });
    });

        function confirmDelete(deleteUrl) {
            console.log(deleteUrl);
            if (confirm('Apakah Anda yakin ingin menghapus data ini ? ')) {
                // Jika user mengonfirmasi, kita dapat membuat form dan mengirimkan permintaan delete
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                // Tambahkan CSRF token
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                // Tambahkan method spoofing untuk DELETE (karena HTML form hanya mendukung GET dan POST)
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        }

        @if(session('success'))
            alert("{{ session('success') }}");
        @endif

        @if(session('error'))
            alert("{{ session('error') }}");
        @endif
    </script>

</x-app-layout>