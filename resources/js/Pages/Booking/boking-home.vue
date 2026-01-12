<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <div class=" bg-gray-50">
            <div class="mx-5 my-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Riwayat Booking</h1>
                        <p class="text-gray-500 text-sm">Kelola dan pantau status janji temu medis Anda.</p>
                    </div>
                    <button
                        class="mt-4 md:mt-0 bg-[#075798] hover:bg-[#06467a] text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Booking Baru
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-6">

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-14 w-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                                        DR
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="text-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 uppercase tracking-wider">
                                                kode boking </span>
                                            <span
                                                class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-50 text-green-600">
                                                Selesai
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight">dr. John Doe, Sp.A
                                        </h3>
                                        <p class="text-gray-500 text-sm mt-1">Pasien: <span
                                                class="font-medium text-gray-700">Ahmad Fauzi</span></p>
                                    </div>
                                </div>

                                <div
                                    class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 border-t lg:border-t-0 lg:border-x border-gray-100 pt-4 lg:pt-0 lg:px-6">
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-1">
                                            Tanggal Booking</p>
                                        <div class="flex items-center gap-2 text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-medium">12 Januari 2026</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-1">
                                            Keluhan</p>
                                        <p class="text-sm text-gray-600 line-clamp-1 italic">"Demam tinggi selama 2
                                            hari..."</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <button
                                        class="flex-1 lg:flex-none px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                        Detail
                                    </button>
                                    <button
                                        class="flex-1 lg:flex-none px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        Batalkan
                                    </button>
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

</script>