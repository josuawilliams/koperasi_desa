<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Keranjang</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('Keranjang Belanja') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Produk yang sudah kamu tambahkan dari etalase.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <a href="/"
            class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 transition hover:bg-gray-50">
            Lanjut Belanja
        </a>
    </x-slot>

    @php
        $total = $carts->sum(fn ($cart) => $cart->quantity * ($cart->product->price ?? 0));
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="rounded-md bg-emerald-50 p-4 text-sm font-medium text-emerald-700 ring-1 ring-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <section class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                <div class="border-b border-gray-200 px-5 py-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Daftar Produk</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $carts->count() }} item di keranjang.</p>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($carts as $cart)
                        <article class="grid gap-4 p-5 md:grid-cols-[80px_minmax(0,1fr)_140px_96px] md:items-center">
                            <div
                                class="flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100 text-xs font-semibold uppercase text-gray-500 ring-1 ring-gray-200">
                                @if ($cart->product?->image)
                                    <img src="{{ asset(getenv('CUSTOM_IMAGES_LOCATION') . '/' . $cart->product->image) }}"
                                        alt="{{ $cart->product->name }}"
                                        class="h-20 w-20 rounded-lg object-cover ring-1 ring-gray-200">
                                @else
                                    No Image
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h4 class="text-base font-semibold text-gray-900">{{ $cart->product->name ?? '-' }}</h4>
                                <p class="mt-1 text-sm text-gray-600">{{ $cart->product->description ?? '-' }}</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs font-medium text-gray-600">
                                    <span class="rounded-md bg-emerald-50 px-2 py-1 text-emerald-700">
                                        Qty: {{ $cart->quantity }}
                                    </span>
                                    <span class="rounded-md bg-gray-100 px-2 py-1">
                                        Stok tersisa: {{ $cart->product->stock ?? 0 }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-left md:text-right">
                                <p class="text-sm font-medium text-gray-500">Subtotal</p>
                                <p class="mt-1 text-lg font-semibold text-gray-900">
                                    Rp {{ number_format($cart->quantity * ($cart->product->price ?? 0), 0, ',', '.') }}
                                </p>
                            </div>

                            <form action="{{ route('cart.destroy', ['id' => $cart->id]) }}" method="POST"
                                class="md:text-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex h-9 items-center justify-center rounded-md bg-red-50 px-3 text-sm font-semibold text-red-700 ring-1 ring-red-200 transition hover:bg-red-100">
                                    Hapus
                                </button>
                            </form>
                        </article>
                    @empty
                        <div class="p-6 text-sm leading-6 text-gray-600">
                            Keranjang masih kosong.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
