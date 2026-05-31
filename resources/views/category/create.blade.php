<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Kategori</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('Edit Kategori') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Tambah kategori untuk menjaga struktur produk tetap rapi.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('category.store') }}" method="POST"
                class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_280px]">
                @csrf
                @method('POST')

                <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-base font-semibold text-gray-900">Informasi Kategori</h3>
                        <p class="mt-1 text-sm text-gray-500">Hanya nama kategori yang perlu diubah pada halaman ini.
                        </p>
                    </div>

                    <div class="mt-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Masukkan nama kategori">
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="flex flex-col gap-3">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                        <a href={{ route('category.index') }}
                            class="inline-flex items-center justify-center rounded-md bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</x-app-layout>
