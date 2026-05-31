<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-700">Produk</p>
                <h2 class="text-xl font-semibold leading-tight text-gray-900">
                    {{ __('Tambah Produk') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data"
                class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                @csrf
                <div class="space-y-6">
                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-base font-semibold text-gray-900">Informasi Produk</h3>
                            <p class="mt-1 text-sm text-gray-500">Ubah detail utama yang tampil di daftar produk
                                koperasi.</p>
                        </div>
                        <div class="mt-6 grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                    Produk</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="Masukkan nama produk">
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                <input id="slug" name="slug" type="text" value="{{ old('slug') }}"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="slug-produk">
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">
                                    Kategori
                                </label>
                                <select id="category_id" name="category_id"
                                    class="mt-2 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih Kategori</option>

                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">Rp</span>
                                    <input id="price" name="price" type="number" value="{{ old('price') }}"
                                        class="block w-full rounded-none rounded-r-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                        placeholder="0">
                                </div>
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                                <input id="stock" name="stock" type="number" value="{{ old('stock') }}"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="0">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="description" name="description" rows="5"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="Tulis deskripsi produk">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-base font-semibold text-gray-900">Gambar Produk</h3>
                            <p class="mt-1 text-sm text-gray-500">Gunakan gambar yang jelas untuk memudahkan pembeli
                                mengenali produk.</p>
                        </div>

                        <div>

                            <input id="image" name="image" type="file" accept="image/*"
                                class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-emerald-700">
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                        <h3 class="text-base font-semibold text-gray-900">Status Produk</h3>
                        <div class="mt-5 rounded-lg bg-gray-50 p-4">
                            <label for="is_visible" class="flex items-center justify-between gap-4">
                                <span>
                                    <span class="block text-sm font-medium text-gray-700">Is Visible</span>
                                    <span class="mt-1 block text-sm text-gray-500">Produk tampil untuk pengguna.</span>
                                </span>
                                <input id="is_visible" name="is_visible" type="checkbox" value="1"
                                    @checked(old('is_visible'))
                                    class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </label>
                        </div>
                    </section>


                    <div class="flex flex-col gap-3">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('product.index') }}"
                            class="inline-flex items-center justify-center rounded-md bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</x-app-layout>
