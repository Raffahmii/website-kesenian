@extends('layouts.dashboard')

@section('title', 'Manajemen Anggota')
@section('subtitle', 'Kelola seluruh anggota & pengurus organisasi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Manajemen <span class="text-gold-dark">Anggota</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $stats['total'] }} user terdaftar · {{ $stats['aktif'] }} aktif
                </p>
            </div>
            <div class="flex flex-wrap gap-2 self-start sm:self-center">
                <button 
                    type="button"
                    x-data
                    @click="$dispatch('open-alumni-modal')"
                    class="px-4 py-2.5 rounded-xl bg-yellow-100 hover:bg-yellow-200
                           text-yellow-700 text-sm font-medium transition-colors
                           flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    Alumni Massal
                </button>

                <button 
                    type="button"
                    x-data
                    @click="$dispatch('open-serah-modal')"
                    class="px-4 py-2.5 rounded-xl bg-purple-100 hover:bg-purple-200
                           text-purple-700 text-sm font-medium transition-colors
                           flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Serah Terima
                </button>

                <a href="{{ route('dashboard.members.create') }}" class="btn-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Anggota
                </a>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total User', 'value' => $stats['total']],
                ['label' => 'Aktif', 'value' => $stats['aktif']],
                ['label' => 'Alumni', 'value' => $stats['alumni']],
                ['label' => 'Nonaktif', 'value' => $stats['nonaktif']],
            ];
        @endphp

        @foreach($statCards as $i => $stat)
            <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-none">
                    {{ $stat['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-light-muted" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama, email, atau NIS..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                              bg-light-bg border border-light-border text-light-text
                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>

            <select name="role" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                        text-light-text focus:outline-none focus:bg-white
                                        focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Role</option>
                @foreach(\App\Enums\RoleUser::cases() as $role)
                    <option value="{{ $role->value }}" @selected(request('role') === $role->value)>
                        {{ $role->label() }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="semua" @selected(request('status') === 'semua')>Semua Status</option>
                @foreach(\App\Enums\StatusAnggota::cases() as $status)
                    <option value="{{ $status->value }}" 
                            @selected(request('status', 'aktif') === $status->value)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            <select name="cabang" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Cabang</option>
                @foreach(\App\Enums\Cabang::cases() as $cab)
                    <option value="{{ $cab->value }}" @selected(request('cabang') === $cab->value)>
                        {{ $cab->shortLabel() }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="panel-light p-0 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border bg-light-bg/50">
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Anggota</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden md:table-cell">Kontak</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden lg:table-cell">Kelas</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden lg:table-cell">Cabang</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Role</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Status</th>
                        <th class="text-right text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @forelse($members as $member)
                        <tr class="hover:bg-light-hover transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" 
                                             class="w-10 h-10 rounded-xl object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                                    font-display font-bold text-bg-primary shrink-0">
                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="font-medium text-sm text-light-text truncate">
                                                {{ $member->nama_lengkap }}
                                            </p>
                                            @if($member->id_user === auth()->id())
                                                <span class="text-[9px] px-1.5 py-0.5 rounded 
                                                             bg-gold/20 text-gold-dark font-semibold">YOU</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-light-muted truncate">
                                            {{ $member->nis ? 'NIS: ' . $member->nis : $member->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4 hidden md:table-cell">
                                <p class="text-xs text-light-text truncate">{{ $member->email }}</p>
                                @if($member->phone)
                                    <p class="text-[10px] text-light-muted">{{ $member->phone }}</p>
                                @endif
                            </td>

                            <td class="py-3 px-4 hidden lg:table-cell">
                                @if($member->kelas)
                                    <p class="text-xs text-light-text">{{ $member->kelas }} {{ $member->jurusan }}</p>
                                    <p class="text-[10px] text-light-muted">Angkatan {{ $member->angkatan }}</p>
                                @else
                                    <span class="text-xs text-light-muted">-</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 hidden lg:table-cell">
                                @if($member->cabang)
                                    <span class="text-xs text-light-text">
                                        {{ $member->cabang->icon() }} {{ $member->cabang->shortLabel() }}
                                    </span>
                                @else
                                    <span class="text-xs text-light-muted">-</span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                <span class="badge-gold text-[10px]">{{ $member->role->label() }}</span>
                            </td>

                            <td class="py-3 px-4">
                                @php
                                    $statusClass = match($member->status_anggota) {
                                        \App\Enums\StatusAnggota::AKTIF    => 'bg-green-100 text-green-700',
                                        \App\Enums\StatusAnggota::ALUMNI   => 'bg-yellow-100 text-yellow-700',
                                        \App\Enums\StatusAnggota::NONAKTIF => 'bg-red-100 text-red-700',
                                    };
                                @endphp
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $statusClass }}">
                                    {{ $member->status_anggota->label() }}
                                </span>
                            </td>

                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('dashboard.members.show', $member->id_user) }}" 
                                       class="p-2 rounded-lg hover:bg-light-bg text-light-muted hover:text-gold-dark transition-colors"
                                       title="Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <a href="{{ route('dashboard.members.edit', $member->id_user) }}" 
                                       class="p-2 rounded-lg hover:bg-light-bg text-light-muted hover:text-blue-500 transition-colors"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    @can('manage-members')
                                        @if($member->id_user !== auth()->id())
                                            <button 
                                                type="button"
                                                @click="$dispatch('open-delete-modal', {
                                                    action: '{{ route('dashboard.members.destroy', $member->id_user) }}',
                                                    title: 'Hapus {{ addslashes($member->nama_lengkap) }}?',
                                                    description: 'Data anggota akan dihapus permanen.'
                                                })"
                                                class="p-2 rounded-lg hover:bg-red-50 text-light-muted hover:text-red-500 transition-colors"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="text-5xl mb-3">👥</div>
                                <p class="text-light-text font-medium mb-1">Belum ada anggota</p>
                                <p class="text-light-muted text-sm">Mulai dengan menambah anggota pertama</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">{{ $members->links() }}</div>

    {{-- ═══════════════════════════════════════
         DELETE MODAL
         ═══════════════════════════════════════ --}}
    <div 
        x-data="{ open: false, action: '', title: '', description: '' }"
        x-init="
            window.addEventListener('open-delete-modal', (e) => {
                open = true;
                action = e.detail.action;
                title = e.detail.title;
                description = e.detail.description;
            });
        "
        @keydown.escape.window="open = false"
        x-show="open"
        x-cloak
        @click.self="open = false"
        x-transition
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    >
        <div @click.stop x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="w-full max-w-md panel-light p-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-red-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-lg text-center text-light-text mb-2" x-text="title"></h3>
            <p class="text-sm text-light-muted text-center mb-6" x-text="description"></p>
            <div class="flex gap-3">
                <button @click="open = false"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-light-border
                               text-light-muted hover:bg-light-bg font-medium text-sm transition-colors">
                    Batal
                </button>
                <form :action="action" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600
                                   text-white font-medium text-sm transition-colors">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         ALUMNI MASSAL MODAL
         ═══════════════════════════════════════ --}}
    <div 
        x-data="{ open: false }"
        x-init="window.addEventListener('open-alumni-modal', () => { open = true; document.body.style.overflow = 'hidden'; });"
        @keydown.escape.window="open = false; document.body.style.overflow = ''"
        x-show="open" x-cloak
        @click.self="open = false; document.body.style.overflow = ''"
        x-transition
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md"
    >
        <div @click.stop x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="relative w-full max-w-md rounded-3xl overflow-hidden
                    bg-light-card border border-light-border shadow-2xl">
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 
                        bg-yellow-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <button @click="open = false; document.body.style.overflow = ''"
                    class="absolute top-4 right-4 z-10 p-2 rounded-xl 
                           text-light-muted hover:text-yellow-600 hover:bg-yellow-50 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <form action="{{ route('dashboard.members.alumni-massal') }}" method="POST" 
                  class="relative p-6 sm:p-8">
                @csrf

                <div class="w-16 h-16 mx-auto rounded-3xl bg-yellow-100 flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>

                <h3 class="font-display font-bold text-xl text-center text-light-text mb-2">Alumni Massal</h3>
                <p class="text-sm text-light-muted text-center mb-6">
                    Semua anggota angkatan yang dipilih akan jadi <strong>alumni</strong> dan kepengurusannya dinonaktifkan.
                </p>

                <div class="p-4 rounded-2xl bg-light-bg border border-light-border mb-4">
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Pilih Angkatan <span class="text-red-500">*</span>
                    </label>
                    <select name="angkatan" required
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-white border border-light-border text-light-text
                                   focus:outline-none focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">— Pilih Angkatan —</option>
                        @foreach($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}">Angkatan {{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="p-3 rounded-xl bg-red-50 border border-red-200 mb-6 flex items-start gap-3">
                    <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-[11px] text-red-700 leading-relaxed">
                        ⚠️ Tindakan ini <strong>tidak bisa dibatalkan otomatis</strong>. Yakin?
                    </p>
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="open = false; document.body.style.overflow = ''"
                            class="flex-1 px-4 py-3 rounded-xl border border-light-border
                                   text-light-muted hover:bg-light-bg font-medium text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 rounded-xl bg-yellow-500 hover:bg-yellow-600
                                   text-white font-medium text-sm transition-colors
                                   flex items-center justify-center gap-2
                                   shadow-lg shadow-yellow-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ya, Alumni-kan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         SERAH TERIMA MODAL
         ═══════════════════════════════════════ --}}
    <div 
        x-data="{ open: false }"
        x-init="window.addEventListener('open-serah-modal', () => { open = true; document.body.style.overflow = 'hidden'; });"
        @keydown.escape.window="open = false; document.body.style.overflow = ''"
        x-show="open" x-cloak
        @click.self="open = false; document.body.style.overflow = ''"
        x-transition
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md"
    >
        <div @click.stop x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="relative w-full max-w-lg rounded-3xl overflow-hidden
                    bg-light-card border border-light-border shadow-2xl
                    max-h-[90vh] overflow-y-auto">
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 
                        bg-purple-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <button @click="open = false; document.body.style.overflow = ''"
                    class="absolute top-4 right-4 z-10 p-2 rounded-xl 
                           text-light-muted hover:text-purple-600 hover:bg-purple-50 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <form action="{{ route('dashboard.members.serah-terima') }}" method="POST" 
                  class="relative p-6 sm:p-8">
                @csrf

                <div class="w-16 h-16 mx-auto rounded-3xl bg-purple-100 flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>

                <h3 class="font-display font-bold text-xl text-center text-light-text mb-2">
                    Serah Terima Jabatan
                </h3>
                <p class="text-sm text-light-muted text-center mb-6">
                    Pindahkan jabatan dari senior purna ke junior pengganti
                </p>

                @if(!$periodeAktif)
                    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 mb-4">
                        <p class="text-sm text-red-700">
                            ⚠️ Tidak ada periode aktif. Aktifkan periode dulu di <strong>Pengaturan</strong>.
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                <span class="text-red-500">1.</span> Senior Purna (yang pergi) <span class="text-red-500">*</span>
                            </label>
                            <select name="id_user_lama" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-white border border-light-border text-light-text
                                           focus:outline-none focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Pilih Pengurus Aktif —</option>
                                @foreach($pengurusAktif as $k)
                                    <option value="{{ $k->id_user }}">
                                        {{ $k->user->nama_lengkap }} — {{ $k->jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                <span class="text-red-500">2.</span> Junior Pengganti <span class="text-red-500">*</span>
                            </label>
                            <select name="id_user_baru" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-white border border-light-border text-light-text
                                           focus:outline-none focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Pilih Anggota —</option>
                                @foreach($membersAktif as $m)
                                    <option value="{{ $m->id_user }}">
                                        {{ $m->nama_lengkap }} @if($m->kelas) · {{ $m->kelas }} {{ $m->jurusan }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode }}">

                        <div class="p-3 rounded-xl bg-purple-50 border border-purple-200 flex items-start gap-3">
                            <svg class="w-4 h-4 text-purple-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-[11px] text-purple-700 leading-relaxed">
                                📌 Senior akan jadi <strong>alumni</strong>. Junior dapat jabatan + role yang sama.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="open = false; document.body.style.overflow = ''"
                                class="flex-1 px-4 py-3 rounded-xl border border-light-border
                                       text-light-muted hover:bg-light-bg font-medium text-sm transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-3 rounded-xl bg-purple-500 hover:bg-purple-600
                                       text-white font-medium text-sm transition-colors
                                       flex items-center justify-center gap-2
                                       shadow-lg shadow-purple-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Serah Terima
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

@endsection