<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Produk</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('Detail Produk') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Informasi lengkap produk koperasi.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="/"
                class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition hover:bg-gray-50">
                Kembali
            </a>
            <form action="{{ route('cart.store', ['id' => $productDetail->id]) }}" method="POST"
                class="flex flex-col gap-2 sm:flex-row sm:items-center">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ $productDetail->stock }}"
                    class="h-10 w-20 rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                <button type="submit" @disabled($productDetail->stock < 1)
                    class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 disabled:cursor-not-allowed disabled:bg-gray-300">
                    Tambah Ke Keranjang
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 text-sm font-medium text-red-700 ring-1 ring-red-200">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div
                    class="mb-6 rounded-md bg-emerald-50 p-4 text-sm font-medium text-emerald-700 ring-1 ring-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @error('quantity')
                <div class="mb-6 rounded-md bg-red-50 p-4 text-sm font-medium text-red-700 ring-1 ring-red-200">
                    {{ $message }}
                </div>
            @enderror

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                <section class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                    <div class="grid gap-0 md:grid-cols-[220px_minmax(0,1fr)]">
                        <div class="flex items-center justify-center bg-gray-100 p-5">
                            @if ($productDetail->image)
                                <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $productDetail->image) }}"
                                    alt="{{ $productDetail->name }}"
                                    class="h-44 w-44 rounded-lg object-cover shadow-sm ring-1 ring-gray-200">
                            @else
                                <div
                                    class="flex h-44 w-44 items-center justify-center rounded-lg bg-gray-200 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-300">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="p-6">

                            <h3 class="mt-4 text-2xl font-semibold text-gray-900">{{ $productDetail->name }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $productDetail->slug }}</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-lg bg-emerald-50 p-4 ring-1 ring-emerald-100">
                                    <p class="text-sm font-medium text-emerald-700">Harga</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">
                                        Rp {{ number_format($productDetail->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="rounded-lg bg-sky-50 p-4 ring-1 ring-sky-100">
                                    <p class="text-sm font-medium text-sky-700">Stok</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $productDetail->stock }}</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-gray-900">Deskripsi</h4>
                                <p class="mt-2 leading-6 text-gray-600">{{ $productDetail->description }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">


                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <h3 class="text-base font-semibold text-gray-900">Metadata</h3>
                        <dl class="mt-5 space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Nama File Gambar</dt>
                                <dd class="mt-1 break-all font-semibold text-gray-900">{{ $productDetail->image ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">Dibuat</dt>
                                <dd class="text-right font-semibold text-gray-900">
                                    {{ optional($productDetail->created_at)->format('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">Diupdate</dt>
                                <dd class="text-right font-semibold text-gray-900">
                                    {{ optional($productDetail->updated_at)->format('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
