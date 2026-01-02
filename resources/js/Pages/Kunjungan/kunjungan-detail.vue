<template>
    <div class="col-span-1 lg:col-span-12 space-y-8 p-4 sm:p-6 lg:p-2 bg-gray-50/50">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Detail Kunjungan
                </h1>
                <p class="text-gray-500 text-sm mt-1">ID Transaksi: #{{ kunjungan.id }} • {{ kunjungan.tanggal_kunjungan }}</p>
            </div>
            <Link :href="$route('kunjungan.home')" 
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </Link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#086abb] px-6 py-4">
                        <h2 class="text-white font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Data Pasien
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                                <p class="text-gray-900 font-medium text-lg leading-tight">{{ kunjungan.pasien.nama }}</p>
                                <span class="inline-flex mt-1 items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    RM: {{ kunjungan.pasien.no_rm }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-50">
                                <div>
                                    <label class="text-xs text-gray-400 block">NIK</label>
                                    <p class="text-sm font-medium">{{ kunjungan.pasien.nik }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 block">Status BPJS</label>
                                    <p :class="kunjungan.pasien.status_bpjs === 'Aktif' ? 'text-green-600' : 'text-red-600'" class="text-sm font-bold">
                                        {{ kunjungan.pasien.status_bpjs }}
                                    </p>
                                </div>
                            </div>
                            <div class="pt-2">
                                <label class="text-xs text-gray-400 block">Alamat</label>
                                <p class="text-sm text-gray-600 italic leading-relaxed">{{ kunjungan.pasien.alamat }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-6 bg-emerald-500 rounded-full mr-3"></span>
                        Informasi Dokter
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-900 font-bold italic">{{ kunjungan.dokter.nama_dokter }}</p>
                            <p class="text-sm text-emerald-600 font-medium">{{ kunjungan.dokter?.poli?.nama_poli ?? '-' }}</p>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ kunjungan.dokter.no_hp }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
                    <div class="border-b border-gray-100 p-6 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Detail Pemeriksaan</h2>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold uppercase tracking-wider">
                            Poli {{ kunjungan.poli }}
                        </span>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                            <div class="p-4 bg-orange-50 rounded-2xl text-center">
                                <p class="text-xs text-orange-600 font-bold uppercase mb-1">Tensi</p>
                                <p class="text-xl font-black text-orange-900">{{ kunjungan.tensi }} <span class="text-xs font-normal">mmHg</span></p>
                            </div>
                            <div class="p-4 bg-blue-50 rounded-2xl text-center">
                                <p class="text-xs text-blue-600 font-bold uppercase mb-1">Suhu</p>
                                <p class="text-xl font-black text-blue-900">{{ kunjungan.suhu }}<span class="text-sm font-normal">°C</span></p>
                            </div>
                            <div class="p-4 bg-purple-50 rounded-2xl text-center">
                                <p class="text-xs text-purple-600 font-bold uppercase mb-1">Status</p>
                                <p class="text-sm font-black text-purple-900 mt-1">Selesai</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl text-center">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-1">Antrean</p>
                                <p class="text-xl font-black text-gray-900">#12</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="group">
                                <label class="flex items-center text-sm font-bold text-gray-700 mb-2">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                    Keluhan Utama
                                </label>
                                <div class="p-4 bg-gray-50 rounded-xl border border-transparent group-hover:border-red-100 transition-colors">
                                    <p class="text-gray-700 leading-relaxed">{{ kunjungan.keluhan }}</p>
                                </div>
                            </div>

                            <div class="group">
                                <label class="flex items-center text-sm font-bold text-gray-700 mb-2">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-2"></span>
                                    Catatan Dokter / Diagnosa
                                </label>
                                <div class="p-4 bg-gray-50 rounded-xl border border-transparent group-hover:border-gray-200 transition-colors italic">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ kunjungan.catatan ?? 'Tidak ada catatan tambahan.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";

const page = usePage();
const kunjungan = computed(() => page.props.kunjungan)
</script>