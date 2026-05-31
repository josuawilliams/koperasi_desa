<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Koperasi Desa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-[linear-gradient(180deg,#fffef8_0%,#f7f7f2_45%,#eef6ff_100%)] font-['Instrument_Sans',sans-serif] text-gray-900 antialiased">
    <div class="relative overflow-hidden">
        <div
            class="absolute inset-x-0 top-0 h-80 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_55%),radial-gradient(circle_at_top_right,_rgba(249,115,22,0.14),_transparent_42%)]">
        </div>
        <div class="absolute right-0 top-28 h-56 w-56 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="absolute left-0 top-[28rem] h-56 w-56 rounded-full bg-emerald-200/30 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="flex items-center justify-between py-6">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">Koperasi Desa</p>
                    <h1 class="mt-2 text-2xl font-semibold text-gray-900">Etalase Belanja Warga</h1>
                </div>
                @auth
                    <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('cart.index') }}"
                                class="inline-flex items-center justify-center rounded-full bg-white/90 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 backdrop-blur transition hover:bg-white">
                                Keranjang
                            </a>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                            Dashboard
                        </a>
                    </div>
                @else
                    <div class="flex rounded-full bg-white/85 p-1 shadow-sm ring-1 ring-gray-200 backdrop-blur">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                            Register
                        </a>
                    </div>
                @endauth
            </header>

            <main class="pb-16 pt-4">
                <section class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div class="max-w-2xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/85 px-4 py-2 text-sm font-medium text-emerald-800 shadow-sm ring-1 ring-emerald-100">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Toko kebutuhan harian dan produk desa
                        </div>

                        <h2 class="mt-6 text-4xl font-semibold leading-tight text-gray-900 sm:text-5xl">
                            Belanja kebutuhan rumah, hasil tani, dan stok koperasi dalam satu etalase yang terasa hidup.
                        </h2>

                        <p class="mt-5 max-w-xl text-base leading-7 text-gray-600 sm:text-lg">
                            Halaman ini sekarang murni jadi storefront. Fokusnya ada pada produk, kategori, dan nuansa
                            jualan barang seperti e-commerce sederhana milik koperasi desa.
                        </p>

                        <form action="/" method="GET"
                            class="mt-8 flex flex-col gap-3 rounded-2xl bg-white/90 p-3 shadow-sm ring-1 ring-gray-200 sm:flex-row">
                            <input type="search" name="search" value="{{ request('search') }}"
                                placeholder="Cari produk..."
                                class="min-h-12 flex-1 rounded-xl border-0 bg-gray-50 px-4 text-sm font-medium text-gray-800 outline-none ring-1 ring-gray-200 transition placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-emerald-500">
                            <div class="flex gap-2">

                                <button type="submit"
                                    class="inline-flex min-h-12 flex-1 items-center justify-center rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 sm:flex-none">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <section
                        class="rounded-[30px] bg-white/90 p-5 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.35)] ring-1 ring-white/80">
                        <div class="rounded-[24px] bg-[linear-gradient(155deg,#0f172a_0%,#14532d_100%)] p-5 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-emerald-100">Rak Depan</p>
                                    <h3 class="mt-1 text-xl font-semibold">Produk paling dicari</h3>
                                </div>
                                <div class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/90">
                                    Etalase
                                </div>
                            </div>

                            <div class="mt-5 grid gap-3">
                                @forelse ($productDashboard->take(3) as $product)
                                    <div
                                        class="grid gap-4 rounded-2xl bg-white/10 p-4 ring-1 ring-white/10 sm:grid-cols-[88px_minmax(0,1fr)] sm:items-center">
                                        <div
                                            class="h-22 flex w-full items-center justify-center rounded-2xl bg-white/10 text-sm font-semibold uppercase text-white">
                                            @if ($product->image)
                                                <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-full w-full rounded-lg object-cover ring-1 ring-gray-200" />
                                            @else
                                                <div
                                                    class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-200">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h4 class="text-base font-semibold">{{ $product->name }}</h4>
                                            </div>
                                            <p class="mt-2 text-sm text-white/70">{{ $product->description }}</p>
                                            <p class="mt-3 text-lg font-semibold"> Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl bg-white/10 p-4 text-sm text-white/75 ring-1 ring-white/10">
                                        Produk tidak ditemukan.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </section>

                <section class="mt-14">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-orange-600">Produk Pilihan
                            </p>
                            <h3 class="mt-2 text-2xl font-semibold text-gray-900">
                                {{ $search ? 'Hasil pencarian untuk "' . $search . '"' : 'Etalase yang terasa seperti toko online' }}
                            </h3>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                        @forelse ($productDashboard as $product)
                            <article
                                class="rounded-[28px] bg-white/95 p-4 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-md">
                                <div
                                    class="flex h-44 items-center justify-center rounded-[22px] bg-[linear-gradient(145deg,#dcfce7_0%,#ffedd5_100%)] text-lg font-semibold uppercase text-gray-700">
                                    @if ($product->image)
                                        <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full rounded-lg object-cover ring-1 ring-gray-200" />
                                    @else
                                        <div
                                            class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-sm font-semibold uppercase text-gray-500 ring-1 ring-gray-200">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 class="text-base font-semibold text-gray-900">{{ $product->name }}</h4>

                                    </div>
                                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $product->description }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-lg font-semibold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <a href="{{ route('show', ['id' => $product->id]) }}" type="button"
                                            class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div
                                class="rounded-[28px] bg-white/95 p-6 text-sm leading-6 text-gray-600 shadow-sm ring-1 ring-gray-200 md:col-span-2 xl:col-span-4">
                                Tidak ada produk yang cocok dengan pencarian "{{ $search }}".
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>
