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
            <a href="{{ route('product.index') }}"
                class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition hover:bg-gray-50">
                Kembali
            </a>
            <a href="{{ route('product.edit', ['id' => $product->id]) }}"
                class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                Edit Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                <section class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                    <div class="grid gap-0 md:grid-cols-[220px_minmax(0,1fr)]">
                        <div class="flex items-center justify-center bg-gray-100 p-5">
                            @if ($product->image)
                                <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-44 w-44 rounded-lg object-cover shadow-sm ring-1 ring-gray-200">
                            @else
                                <div
                                    class="flex h-44 w-44 items-center justify-center rounded-lg bg-gray-200 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-300">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">#{{ $product->id }}</span>
                                <span
                                    class="{{ $product->is_visible ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold">
                                    <span
                                        class="{{ $product->is_visible ? 'bg-emerald-500' : 'bg-amber-500' }} h-1.5 w-1.5 rounded-full"></span>
                                    {{ $product->is_visible ? 'Visible' : 'Hidden' }}
                                </span>
                            </div>

                            <h3 class="mt-4 text-2xl font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $product->slug }}</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-lg bg-emerald-50 p-4 ring-1 ring-emerald-100">
                                    <p class="text-sm font-medium text-emerald-700">Harga</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="rounded-lg bg-sky-50 p-4 ring-1 ring-sky-100">
                                    <p class="text-sm font-medium text-sky-700">Stok</p>
                                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $product->stock }}</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-gray-900">Deskripsi</h4>
                                <p class="mt-2 leading-6 text-gray-600">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <h3 class="text-base font-semibold text-gray-900">Relasi Data</h3>
                        <dl class="mt-5 space-y-4 text-sm">
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">User</dt>
                                <dd class="text-right font-semibold text-gray-900">{{ $product->user ?? '-' }}</dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">Kategori</dt>
                                <dd class="text-right font-semibold text-gray-900">{{ $product->category ?? '-' }}</dd>
                            </div>
                        </dl>
                    </section>

                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <h3 class="text-base font-semibold text-gray-900">Metadata</h3>
                        <dl class="mt-5 space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500">Nama File Gambar</dt>
                                <dd class="mt-1 break-all font-semibold text-gray-900">{{ $product->image ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">Dibuat</dt>
                                <dd class="text-right font-semibold text-gray-900">
                                    {{ optional($product->created_at)->format('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-gray-500">Diupdate</dt>
                                <dd class="text-right font-semibold text-gray-900">
                                    {{ optional($product->updated_at)->format('d M Y H:i') ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <form action="{{ route('product.destroy', ['id' => $product->id]) }}" method="POST"
                        class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        @csrf
                        @method('DELETE')

                        <h3 class="text-base font-semibold text-gray-900">Aksi</h3>
                        <div class="mt-5 grid gap-3">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 ring-1 ring-red-200 transition hover:bg-red-100">
                                Hapus Produk
                            </button>
                        </div>
                    </form>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
