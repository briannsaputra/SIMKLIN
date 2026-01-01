<template>
    <div class="col-span-1 lg:col-span-12 space-y-8 p-4 sm:p-6 lg:p-2">
        <div class="max-w-6xl mx-auto space-y-5">
            <div
                class="bg-white p-6 rounded-xl shadow-lg flex items-center justify-between border-t-4 border-[#086abb]">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-2 text-[#086abb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                        </svg>
                        Detail Pasien
                    </h1>
                    <p class="text-sm text-gray-500 mt-1 ml-11">
                        No RM: <span class="font-bold text-gray-700">{{ pasien.no_rm }}</span>
                    </p>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-xs text-gray-500 uppercase font-medium">Status BPJS</p>
                    <span class="mt-1 inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold shadow-sm"
                        :class="{
                            'bg-green-100 text-green-700': pasien.status_bpjs === 'Aktif',
                            'bg-red-100 text-red-700': pasien.status_bpjs === 'Tidak Aktif',
                            'bg-blue-100 text-blue-700': pasien.status_bpjs === 'Baru',
                            'bg-purple-100 text-purple-700': pasien.status_bpjs === 'PBI',
                            'bg-gray-100 text-gray-700': pasien.status_bpjs === 'Non BPJS'
                        }">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ pasien.status_bpjs }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-3 mb-5 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-[#086abb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                    Identitas Pasien
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">

                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-1.5 text-[#086abb]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Lengkap
                            </p>
                            <p class="text-lg font-bold text-gray-900">{{ pasien.nama }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-1.5 text-[#086abb]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                NIK
                            </p>
                            <p class="text-lg font-bold text-gray-900">{{ pasien.nik }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-1.5 text-[#086abb]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Tanggal Lahir
                            </p>
                            <p class="font-semibold text-gray-800">{{ pasien.tanggal_lahir }}</p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-1.5 text-[#086abb]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 16v4m-2 0h4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 4h4v4m0-4l-5 5" />
                                </svg>
                                Jenis Kelamin
                            </p>
                            <p class="font-semibold text-gray-800">
                                {{ pasien.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>

                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 flex items-center mb-1">
                                <svg class="w-4 h-4 mr-1.5 text-[#086abb]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3a1 1 0 011 .684l1.5 4.5a1 1 0 01-.5 1.21l-2.2 1.1a11 11 0 005.5 5.5l1.1-2.2a1 1 0 011.21-.5l4.5 1.5A1 1 0 0121 16v3a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V5z" />
                                </svg>
                                Nomor Telepon
                            </p>
                            <p class="font-semibold text-gray-800">{{ pasien.telepon }}</p>
                        </div>

                        <div class="hidden sm:block"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-3 mb-5 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#086abb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Alamat Tinggal
                </h2>
                <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-200">
                    {{ pasien.alamat || 'Alamat tidak tersedia' }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-3 mb-5 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#086abb]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Informasi Medis Penting
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 rounded-lg border-2 border-red-300 bg-red-50">
                        <p class="text-xs text-red-700 flex items-center mb-1 font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Alergi
                        </p>
                        <p class="font-bold text-xl text-red-700">
                            {{ pasien.alergi || 'Tidak ada Alergi' }}
                        </p>
                    </div>

                    <div class="p-4 rounded-lg border-2 border-gray-300 bg-gray-50">
                        <p class="text-xs text-gray-700 flex items-center mb-1 font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Catatan Tambahan
                        </p>
                        <p class="font-semibold text-gray-800">
                            {{ pasien.catatan || 'Tidak ada catatan tambahan.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <Link :href="$route('pasien.home')"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Pasien
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    pasien: Object
})
</script>