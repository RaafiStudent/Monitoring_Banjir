<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-wide">
            {{ __('Manajemen Kontak Warga') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-600 rounded-full mix-blend-screen filter blur-[150px] opacity-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/50 rounded-xl text-emerald-400 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-[2rem] shadow-2xl h-fit">
                    <h3 class="text-xl font-bold text-white mb-6">Tambah Kontak Baru</h3>
                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-white border border-slate-300 text-slate-950 font-bold placeholder:text-slate-400 placeholder:font-normal rounded-xl focus:ring-cyan-500 focus:border-cyan-500 p-3 shadow-inner" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div class="mb-5">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Nomor WhatsApp</label>
                            <input type="text" name="phone_number" required class="w-full bg-white border border-slate-300 text-slate-950 font-bold placeholder:text-slate-400 placeholder:font-normal rounded-xl focus:ring-cyan-500 focus:border-cyan-500 p-3 shadow-inner" placeholder="Contoh: 08123456789">
                            <p class="text-[10px] text-slate-500 mt-1">Gunakan awalan 08 atau 62.</p>
                        </div>
                        <div class="mb-8">
                            <label class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Peran / Posisi</label>
                            <select name="role" class="w-full bg-white border border-slate-300 text-slate-950 font-bold rounded-xl focus:ring-cyan-500 focus:border-cyan-500 p-3 shadow-inner">
                                <option value="Warga">Warga Biasa</option>
                                <option value="Ketua RT">Ketua RT</option>
                                <option value="Relawan">Relawan Siaga</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-black py-3.5 rounded-xl transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                            SIMPAN KONTAK
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-slate-900/40 backdrop-blur-2xl border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <div class="p-8 border-b border-slate-800 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white">Database Kontak Kaligangsa</h3>
                        <span class="px-4 py-1.5 bg-slate-800 rounded-full text-xs font-bold text-cyan-400 border border-slate-700">Total: {{ $contacts->total() }} Orang</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] bg-slate-900/60">
                                    <th class="px-8 py-5 font-bold">Nama / Peran</th>
                                    <th class="px-8 py-5 font-bold">No. WhatsApp</th>
                                    <th class="px-8 py-5 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50">
                                @forelse($contacts as $contact)
                                <tr class="hover:bg-white/5 transition-all">
                                    <td class="px-8 py-5">
                                        <p class="text-white font-bold">{{ $contact->name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $contact->role }}</p>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="font-mono text-cyan-400">{{ $contact->phone_number }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kontak ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider bg-rose-500/10 px-3 py-1.5 rounded-lg border border-rose-500/20 transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-16 text-center text-slate-500 italic">
                                        Belum ada data kontak warga.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 bg-slate-900/20 border-t border-slate-800">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>