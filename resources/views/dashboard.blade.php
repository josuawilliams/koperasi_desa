<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Koperasi Desa</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('Daftar Produk') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Produk terhubung dengan users dan categories.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form action="{{ route('dashboard') }}" method="GET"
                class="flex w-full overflow-hidden rounded-md shadow-sm ring-1 ring-gray-300 sm:w-80">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                    class="min-w-0 flex-1 border-0 px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:ring-0">
                <button type="submit"
                    class="bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                    Cari
                </button>
            </form>

            <a href="{{ route('product.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                Tambah Produk
            </a>
        </div>
    </x-slot>

    @php
        $visibleCount = $products->where('is_visible', true)->count();
        $totalProducts = method_exists($products, 'total') ? $products->total() : $products->count();
    @endphp
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="bg-white p-5 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Total Produk</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white p-5 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Produk Tampil</p>
                    <p class="mt-2 text-3xl font-semibold text-emerald-700">{{ $visibleCount }}</p>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                <div class="border-b border-gray-200 px-5 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Inventaris Produk</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $totalProducts }} produk tersedia.</p>
                        </div>
                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-800 ring-1 ring-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            ERD: products
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <article
                            class="grid gap-4 p-5 transition hover:bg-gray-50 xl:grid-cols-[88px_minmax(0,1fr)_170px_130px_180px] xl:items-center">
                            <div
                                class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-200">
                                @if ($product->image)
                                    <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="h-20 w-20 rounded-lg object-cover ring-1 ring-gray-200" />
                                @else
                                    <div
                                        class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-200">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="truncate text-base font-semibold text-gray-900">{{ $product->name }}</h4>
                                    <span
                                        class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">#{{ $product->id }}</span>
                                    <span
                                        class="{{ $product->is_visible ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium">
                                        <span
                                            class="{{ $product['is_visible'] ? 'bg-emerald-500' : 'bg-amber-500' }} h-1.5 w-1.5 rounded-full"></span>
                                        {{ $product->is_visible ? 'Visible' : 'Hidden' }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">{{ $product->description }}</p>
                                <div
                                    class="mt-3 grid gap-2 text-xs font-medium text-gray-500 sm:grid-cols-2 lg:grid-cols-4">
                                    <div class="rounded-md bg-blue-50 px-2 py-1 text-blue-700">
                                        <span
                                            class="block text-[10px] uppercase tracking-wide text-blue-500">Category</span>
                                        {{ $product->category }}
                                    </div>
                                    <div class="rounded-md bg-slate-100 px-2 py-1">
                                        <span
                                            class="block text-[10px] uppercase tracking-wide text-gray-400">User</span>
                                        {{ $product->user }}
                                    </div>
                                    <div class="rounded-md bg-slate-100 px-2 py-1">
                                        <span
                                            class="block text-[10px] uppercase tracking-wide text-gray-400">Slug</span>
                                        {{ $product->slug }}
                                    </div>
                                    <div class="rounded-md bg-slate-100 px-2 py-1">
                                        <span
                                            class="block text-[10px] uppercase tracking-wide text-gray-400">Image</span>
                                        {{ $product->image }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Harga</p>
                                <p class="mt-1 text-lg font-semibold text-gray-900">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <div class="flex-column flex w-full text-sm">
                                    <span class="font-medium text-gray-500">Stok : </span>
                                    <span class="font-semibold text-gray-900">{{ $product->stock }}</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-3 gap-2">
                                    <a href="{{ route('product.show', ['id' => $product->id]) }}"
                                        class="inline-flex h-9 items-center justify-center rounded-md bg-sky-50 px-3 text-sm font-semibold text-sky-700 ring-1 ring-sky-200 transition hover:bg-sky-100">
                                        Detail
                                    </a>
                                    <a href="{{ route('product.edit', ['id' => $product->id]) }}"
                                        class="inline-flex h-9 items-center justify-center rounded-md bg-amber-50 px-3 text-sm font-semibold text-amber-700 ring-1 ring-amber-200 transition hover:bg-amber-100">
                                        Edit
                                    </a>
                                    <form action="{{ route('product.destroy', ['id' => $product->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex h-9 items-center justify-center rounded-md bg-red-50 px-3 text-sm font-semibold text-red-700 ring-1 ring-red-200 transition hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if (method_exists($products, 'links') && $products->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
