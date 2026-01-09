<template>
    <div class="col-span-1 lg:col-span-12 space-y-6">
        <div
            class="bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden border border-gray-100 transition-all hover:shadow-2xl">

            <div class="relative h-48 bg-gradient-to-br from-[#0a64ae] via-[#126cb5] to-[#1086e6]">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-40 h-40 bg-indigo-900/20 rounded-full blur-2xl">
                </div>

                <div class="absolute -bottom-14 left-1/2 -translate-x-1/2 md:left-12 md:translate-x-0">
                    <div class="relative">
                        <div class="p-1.5 bg-white rounded-[2rem] shadow-xl">
                            <img class="h-28 w-28 rounded-[1.7rem] object-cover border-2 border-gray-50"
                                :src="fotoDokter" alt="Foto Dokter">
                        </div>
                        <div class="absolute bottom-2 right-2 h-6 w-6 bg-green-500 border-4 border-white rounded-full">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-20 pb-10 px-8">
                <div class="text-center md:text-left mb-8">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ jadwalDokter.dokter.nama_dokter }}
                    </h1>
                    <div class="mt-2 flex items-center justify-center md:justify-start gap-2">
                        <span
                            class="px-3 py-1 bg-blue-50 text- text-sm font-semibold rounded-lg border border-indigo-100">
                            {{ jadwalDokter.dokter.poli.nama_poli }}
                        </span>
                        <span class="flex items-center text-amber-500 text-sm font-bold">
                            <svg class="w-4 h-4 fill-current mr-1" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Total Pasien 200
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="group p-5 bg-slate-50 hover:bg-white hover:ring-2 hover:ring-blue-500/20 rounded-[1.8rem] transition-all duration-300">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Hari</p>
                            <div class="flex items-center gap-3">
                                <div
                                    class="p-2 bg-blue-100 text-[#064e88] rounded-xl group-hover:bg-[#064e88] group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-lg font-bold text-slate-800">{{ jadwalDokter.hari }}</span>
                            </div>
                        </div>

                        <div
                            class="group p-5 bg-slate-50 hover:bg-white hover:ring-2 hover:ring-emerald-500/20 rounded-[1.8rem] transition-all duration-300">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Waktu</p>
                            <div class="flex items-center gap-3">
                                <div
                                    class="p-2 bg-emerald-100 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-lg font-bold text-slate-800 tracking-tight">
                                    {{ jadwalDokter.jam_mulai.slice(0, 5) }}-{{ jadwalDokter.jam_selesai.slice(0, 5) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between p-6 bg-[#072d4d] rounded-[1.8rem] text-white shadow-lg shadow-slate-200">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Ketersediaan
                                Kuota</p>
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-black text-white">{{ jadwalDokter.kuota }}</span>
                                <span class="text-slate-400 font-medium italic text-sm">Sisa Pasien Terdaftar</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div v-if="jadwalDokter.aktif" class="flex flex-col items-end">
                                <span class="relative flex h-3 w-3 mb-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                </span>
                                <span class="text-xs font-black tracking-tighter text-green-400">AVAILABLE</span>
                            </div>
                            <span v-else class="text-xs font-black tracking-tighter text-red-400 uppercase italic">On
                                Leave</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-4">
                    <button
                        class="group relative w-full bg-[#064e88] hover:bg-[#0a60a6] text-white font-bold py-5 rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-100 overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Daftar Antrean Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700">
                        </div>
                    </button>

                    <Link :href="$route('jadwal.home')"
                        class="w-full bg-transparent text-center border-2 border-slate-100 text-slate-500 font-bold py-4 rounded-2xl hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 text-sm">
                        Kembali ke Daftar Jadwal
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue"
import { Link, usePage } from "@inertiajs/vue3"

const page = usePage()

const jadwalDokter = computed(() => page.props.jadwalDokter)

const fotoDokter = computed(() => {
    const image = jadwalDokter.value?.dokter?.image

    return image
        ? `/storage/${image}`
        : '/images/brian-saputra-DhVa1vBg.jpg'
})
</script>
