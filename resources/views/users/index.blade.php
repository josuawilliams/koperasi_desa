<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-emerald-700">Koperasi Desa</p>
            <h2 class="text-xl font-semibold leading-tight text-gray-900">
                {{ __('List User') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">Kelola akses user yang bisa login ke aplikasi.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <form action="{{ route('users.index') }}" method="GET"
            class="flex w-full overflow-hidden rounded-md shadow-sm ring-1 ring-gray-300 sm:w-80">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email"
                class="min-w-0 flex-1 border-0 px-3 py-2 text-sm text-gray-700 focus:ring-0">
            <button type="submit"
                class="bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                Cari
            </button>
        </form>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                <div class="border-b border-gray-200 px-5 py-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Daftar User</h3>
                            <p class="mt-1 text-sm text-gray-500">User yang diblokir tidak bisa login.</p>
                        </div>
                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-md bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-800 ring-1 ring-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Super Admin
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($users as $userItem)
                        <article
                            class="grid gap-4 p-5 transition hover:bg-gray-50 lg:grid-cols-[minmax(0,1fr)_180px_180px] lg:items-center">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="truncate text-base font-semibold text-gray-900">{{ $userItem->name }}</h4>
                                    @if ($userItem->is_blocked)
                                        <span
                                            class="rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 ring-1 ring-red-200">
                                            Diblokir
                                        </span>
                                    @else
                                        <span
                                            class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                            Aktif
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 truncate text-sm text-gray-500">{{ $userItem->email }}</p>
                            </div>

                            <div class="text-sm text-gray-600">
                                {{ $userItem->roles->pluck('name')->join(', ') ?: 'Tanpa role' }}
                            </div>

                            <div>
                                @if ($userItem->is(auth()->user()))
                                    <span
                                        class="inline-flex h-9 items-center justify-center rounded-md bg-gray-100 px-3 text-sm font-semibold text-gray-500 ring-1 ring-gray-200">
                                        Akun Anda
                                    </span>
                                @elseif ($userItem->is_blocked)
                                    <form method="POST" action="{{ route('users.unblock', $userItem) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex h-9 w-full items-center justify-center rounded-md bg-emerald-50 px-3 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-200 transition hover:bg-emerald-100">
                                            Unblokir
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('users.block', $userItem) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex h-9 w-full items-center justify-center rounded-md bg-red-50 px-3 text-sm font-semibold text-red-700 ring-1 ring-red-200 transition hover:bg-red-100">
                                            Blokir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="p-5 text-sm text-gray-500">User tidak ditemukan.</div>
                    @endforelse
                </div>

                <div class="border-t border-gray-200 px-5 py-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
