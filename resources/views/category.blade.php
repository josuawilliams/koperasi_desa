<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Koperasi Desa</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('Daftar Kategori') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Kelola kelompok produk agar inventaris tetap rapi dan mudah dicari.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form action="{{ route('category.index') }}" method="GET"
                class="flex w-full overflow-hidden rounded-md shadow-sm ring-1 ring-gray-300 sm:w-80">
                <input type="search" name="search" value={{ request('search') }} placeholder="cari"
                    class="min-w-0 flex-1 border-0 px-3 py-2 text-sm text-gray-700 focus:ring-0">
                <button type="submit"
                    class="bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                    Cari
                </button>
            </form>

            <a href="{{ route('category.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                <div class="border-b border-gray-200 px-5 py-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">List Kategori</h3>
                            <p class="mt-1 text-sm text-gray-500">Struktur kategori untuk mengelompokkan produk
                                koperasi.</p>
                        </div>
                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-800 ring-1 ring-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Master Data
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach ($category as $item)
                        <article
                            class="grid gap-4 p-5 transition hover:bg-gray-50 lg:grid-cols-[minmax(0,1fr)_140px_180px] lg:items-center">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="truncate text-base font-semibold text-gray-900">{{ $item->name }}
                                    </h4>
                                    <span class="rounded-md px-2 py-1 text-xs font-medium text-gray-600"></span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('category.edit', ['id' => $item->id]) }}"
                                        class="inline-flex h-9 items-center justify-center rounded-md bg-amber-50 px-3 text-sm font-semibold text-amber-700 ring-1 ring-amber-200 transition hover:bg-amber-100">
                                        Edit
                                    </a>

                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="border-t border-gray-200 px-5 py-4">
                    {{ $category->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
