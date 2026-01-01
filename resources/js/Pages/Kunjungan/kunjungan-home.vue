<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <main class="bg-gray-50 p-6 rounded-2xl">
            <div class="max-w-7xl mx-auto">
                <div class="mb-5 flex items-center justify-between">
                    <h1 class="text-[22px] font-bold text-gray-900 mb-2">
                        List Kunjungan Pasien
                    </h1>

                    <button @click="isOpen = true"
                        class="px-3 py-3 text-sm bg-[#064e88] text-white font-semibold rounded-lg shadow-xl hover:bg-[#064e88] transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#064e88] flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Data Kunjungan</span>
                    </button>
                </div>
                <!-- ALERT -->
                <div v-if="message" :class="alertClasses"
                    class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg transition-all duration-300">
                    <span>{{ message }}</span>
                    <button @click="close" class="ml-4 font-bold">×</button>
                </div>
                <div class="shadow bg-white">
                    <!-- Search -->
                    <div class="pt-3 px-4">
                        <form @submit.prevent="submitSearch" class="mb-6 flex items-center gap-3">
                            <input v-model="searchForm.search" type="text" placeholder="Cari kunjungan pasien..."
                                class="flex-grow px-5 py-2.5 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500 transition duration-150 shadow-sm" />

                            <button type="submit"
                                class="p-2.5 bg-[#054a83] text-white rounded-full hover:bg-[#0761aa] transition duration-150 shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-xl shadow">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-100">
                                    <th class="px-3 py-3 text-left text-sm font-semibold text-gray-600">
                                        No Rm
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Nama Pasien
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Nik
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Keluhan
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Nama Dokter
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Tensi
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Suhu Tubuh
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in kunjungans" :key="item.id"
                                    class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        {{ item.pasien.no_rm }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        {{ item.pasien.nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.pasien.nik }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.keluhan }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.dokter.nama_dokter }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ item.tensi }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.suhu }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1">
                                            <button @click="openEditModal(item)"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-semibold rounded-full shadow-sm text-blue-800 bg-blue-100 hover:bg-blue-200 hover:shadow-md transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </button>

                                            <button @click="openDeleteModal(item)"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-semibold rounded-full shadow-sm text-red-800 bg-red-100 hover:bg-red-200 hover:shadow-md transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                            </button>

                                            <Link :href="$route('kunjungan.show', item.id)"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-semibold rounded-full shadow-sm text-gray-800 bg-gray-200 hover:bg-gray-300 hover:shadow-md transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Detail
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between text-sm text-gray-600">
                    <span>Showing 1 to 6 of 6 results</span>
                    <div class="flex gap-2">
                        <button
                            class="px-4 py-2 bg-white border border-gray-300 text-gray-800 rounded hover:bg-gray-100 transition">
                            Previous
                        </button>
                        <button
                            class="px-4 py-2 bg-blue-100 text-blue-600 border border-blue-200 rounded hover:bg-blue-200 transition">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Overlay Modal (Latar Belakang Gelap) -->
    <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="isOpen || isOpenEdit" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity z-40"
            @click.self="isOpen = false"></div>
    </transition>
    <!-- Struktur Modal Tambah -->
    <transition enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Penipu untuk memusatkan konten modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!-- Konten Utama Modal -->
                <div
                    class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all my-8 w-[90%] max-w-sm sm:align-middle sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl border-t-4 border-[#064e88]">
                    <!-- Header Modal -->
                    <div class="bg-blue-100 p-6 sm:p-7 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-[#064e88]" id="modal-title">
                            Tambah Data Pengunjung
                        </h3>
                        <button @click="isOpen = false" class="text-[#053c66] hover:text-[#064e88] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <form @submit.prevent="submit">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Nama Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88]">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M10 2a4 4 0 100 8 4 4 0 000-8zm-7 16a7 7 0 0114 0H3z" />
                                                    </svg>
                                                </span>
                                                <select v-model="form.pasien_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Nama Pasien
                                                    </option>

                                                    <option v-for="pasien in pasienList" :key="pasien.id"
                                                        :value="pasien.id">
                                                        {{ pasien.nama }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.pasien_id" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.pasien_id }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Nama Dokter
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88]">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" />
                                                        <path d="M4 22a8 8 0 0116 0" />
                                                        <path d="M11 6h2v2h2v2h-2v2h-2v-2H9V8h2V6z" fill="white" />
                                                    </svg>

                                                </span>
                                                <select v-model="form.dokter_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Nama Dokter
                                                    </option>

                                                    <option v-for="dokter in dokterList" :key="dokter.id"
                                                        :value="dokter.id">
                                                        {{ dokter.nama_dokter }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.dokter_id" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.dokter_id }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Poli
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M6 2a1 1 0 00-1 1v4a5 5 0 0010 0V3a1 1 0 00-2 0v4a3 3 0 01-6 0V3a1 1 0 00-1-1z" />
                                                        <path
                                                            d="M20 12a3 3 0 10-3 3v2a5 5 0 01-10 0v-1a1 1 0 10-2 0v1a7 7 0 0014 0v-2a3 3 0 001-3z" />
                                                    </svg>


                                                </span>

                                                <input type="text" v-model="form.poli" placeholder="jantung,gigi"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.poli" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.poli }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Keluhan
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 2L2 20h20L12 2z" />
                                                        <path d="M12 9v4M12 17h.01" stroke="white" stroke-width="2" />
                                                    </svg>

                                                </span>

                                                <input type="text" v-model="form.keluhan" placeholder="Masukan Keluhan"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.keluhan" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.keluhan }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Tensi Tubuh
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 3a9 9 0 00-9 9h2a7 7 0 0114 0h2a9 9 0 00-9-9z" />
                                                        <path d="M12 12l4-4" stroke="white" stroke-width="2" />
                                                        <circle cx="12" cy="12" r="2" />
                                                    </svg>

                                                </span>

                                                <input type="text" v-model="form.tensi"
                                                    placeholder="Masukkan tensi tubuh"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.tensi" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.tensi }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Suhu Tubuh
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 14.76V5a2 2 0 10-4 0v9.76a4 4 0 104 0z" />
                                                    </svg>

                                                </span>

                                                <input type="text" v-model="form.suhu" placeholder="Masukkan suhu tubuh"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.suhu" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.suhu }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Catatan
                                            </label>

                                            <div class="flex items-start relative">
                                                <span
                                                    class="absolute left-0 pt-2 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h8.5a2 2 0 001.414-.586l3.5-3.5A2 2 0 0018 11.5V5a2 2 0 00-2-2H4zm8 12H4V5h12v6.5L12 15z" />
                                                        <path d="M6 7h8v2H6V7zm0 4h5v2H6v-2z" />
                                                    </svg>
                                                </span>

                                                <textarea v-model="form.catatan" placeholder="Masukkan catatan lengkap"
                                                    rows="1"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] focus:outline-none px-3 py-2 pl-10 text-sm rounded-md shadow-sm transition duration-300 placeholder-gray-400"></textarea>
                                            </div>

                                            <div v-if="form.errors.catatan" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.catatan }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#064e88] text-base font-medium text-white hover:bg-[#053c66] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e88] sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                                    Simpan
                                </button>
                                <button type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e88] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150"
                                    @click="isOpen = false">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <!-- Struktur Modal Edit -->
    <transition enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="isOpenEdit" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Penipu untuk memusatkan konten modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Konten Utama Modal -->
                <div
                    class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all my-8 w-[90%] max-w-sm sm:align-middle sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl border-t-4 border-[#064e88]">
                    <!-- Header Modal -->
                    <div class="bg-blue-100 p-6 sm:p-7 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-[#064e88]" id="modal-title">
                            Edit Data Pengunjung
                        </h3>
                        <button @click="isOpenEdit = false" class="text-[#053c66] hover:text-[#064e88] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <form @submit.prevent="submitUpdate">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Nama Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88]">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M10 2a4 4 0 100 8 4 4 0 000-8zm-7 16a7 7 0 0114 0H3z" />
                                                    </svg>
                                                </span>
                                                <select v-model="formEdit.pasien_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Nama Pasien
                                                    </option>
                                                    <option v-for="pasien in pasienList" :key="pasien.id"
                                                        :value="pasien.id">
                                                        {{ pasien.nama }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="formEdit.errors.pasien_id"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.pasien_id }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Nama Dokter
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88]">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" />
                                                        <path d="M4 22a8 8 0 0116 0" />
                                                        <path d="M11 6h2v2h2v2h-2v2h-2v-2H9V8h2V6z" fill="white" />
                                                    </svg>

                                                </span>
                                                <select v-model="formEdit.dokter_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Nama Dokter
                                                    </option>
                                                    <option v-for="dokter in dokterList" :key="dokter.id"
                                                        :value="dokter.id">
                                                        {{ dokter.nama_dokter }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="formEdit.errors.dokter_id"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.dokter_id }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Poli
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M6 2a1 1 0 00-1 1v4a5 5 0 0010 0V3a1 1 0 00-2 0v4a3 3 0 01-6 0V3a1 1 0 00-1-1z" />
                                                        <path
                                                            d="M20 12a3 3 0 10-3 3v2a5 5 0 01-10 0v-1a1 1 0 10-2 0v1a7 7 0 0014 0v-2a3 3 0 001-3z" />
                                                    </svg>
                                                </span>
                                                <input type="text" v-model="formEdit.poli" placeholder="jantung,gigi"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.poli" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.poli }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Keluhan
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 2L2 20h20L12 2z" />
                                                        <path d="M12 9v4M12 17h.01" stroke="white" stroke-width="2" />
                                                    </svg>

                                                </span>
                                                <input type="text" v-model="formEdit.keluhan"
                                                    placeholder="Masukan Keluhan"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.keluhan" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.keluhan }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Tensi Tubuh
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 3a9 9 0 00-9 9h2a7 7 0 0114 0h2a9 9 0 00-9-9z" />
                                                        <path d="M12 12l4-4" stroke="white" stroke-width="2" />
                                                        <circle cx="12" cy="12" r="2" />
                                                    </svg>

                                                </span>
                                                <input type="text" v-model="formEdit.tensi"
                                                    placeholder="Masukkan tensi tubuh"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.tensi" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.tensi }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Suhu Tubuh
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 14.76V5a2 2 0 10-4 0v9.76a4 4 0 104 0z" />
                                                    </svg>

                                                </span>
                                                <input type="text" v-model="formEdit.suhu"
                                                    placeholder="Masukkan suhu tubuh"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.suhu" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.suhu }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Catatan
                                            </label>

                                            <div class="flex items-start relative">
                                                <span
                                                    class="absolute left-0 pt-2 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h8.5a2 2 0 001.414-.586l3.5-3.5A2 2 0 0018 11.5V5a2 2 0 00-2-2H4zm8 12H4V5h12v6.5L12 15z" />
                                                        <path d="M6 7h8v2H6V7zm0 4h5v2H6v-2z" />
                                                    </svg>
                                                </span>
                                                <textarea v-model="formEdit.catatan"
                                                    placeholder="Masukkan catatan lengkap" rows="1"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] focus:outline-none px-3 py-2 pl-10 text-sm rounded-md shadow-sm transition duration-300 placeholder-gray-400"></textarea>
                                            </div>

                                            <div v-if="formEdit.errors.catatan" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.catatan }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#064e88] text-base font-medium text-white hover:bg-[#053c66] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e88] sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
                                    Simpan Perubahan
                                </button>
                                <button type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e88] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150"
                                    @click="isOpenEdit = false"> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <!-- Modal Konfirmasi -->
    <div v-if="isDeleteOpen" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h2 class="text-lg font-semibold">Konfirmasi Hapus</h2>
            <p class="mt-2 text-sm text-gray-600">
                Apakah Anda yakin ingin menghapus
                <strong>{{ selectedItem.pasien?.nama }}</strong>?
            </p>

            <div class="flex justify-end mt-6 gap-3">
                <button @click="isDeleteOpen = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-sm">
                    Batal
                </button>

                <button @click="deleteData" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watchEffect } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';

/* --- FORM SEARCH --- */
const searchForm = useForm({
    search: usePage().props.search ?? ''
})

function submitSearch() {
    searchForm.get(route('kunjungan.home'), {
        preserveState: true,
        replace: true,
    })
}


/* --- FORM TAMBAH --- */
const form = useForm({
    pasien_id: "",
    poli: "",
    keluhan: "",
    dokter_id: "",
    tensi: "",
    suhu: "",
    catatan: "",
    tanggal_kunjungan: "",
});

/* --- FORM EDIT --- */
const formEdit = useForm({
    pasien_id: "",
    poli: "",
    keluhan: "",
    dokter_id: "",
    tensi: "",
    suhu: "",
    catatan: "",
    tanggal_kunjungan: "",
});

/* --- ALERT & FLASH --- */
const message = ref(null);
const type = ref("success");
const page = usePage();

watchEffect(() => {
    // otomatis tampilkan flash
    const flash = page.props.flash || {};
    if (flash.success) {
        message.value = flash.success;
        type.value = "success";
        setTimeout(() => (message.value = null), 3000);
    } else if (flash.error) {
        message.value = flash.error;
        type.value = "error";
        setTimeout(() => (message.value = null), 3000);
    }
});
const alertClasses = computed(() => {
    // Tailwind alert
    if (type.value === "success")
        return "bg-green-100 text-green-800 border border-green-300";
    if (type.value === "error")
        return "bg-red-100 text-red-800 border border-red-300";
    if (type.value === "warning")
        return "bg-yellow-100 text-yellow-800 border border-yellow-300";
    return "";
});
function close() {
    message.value = null;
}

/* --- MODAL --- */
function openEditModal(kunjungan) {
    isOpenEdit.value = true;

    formEdit.pasien_id = kunjungan.pasien_id;
    formEdit.poli = kunjungan.poli;
    formEdit.keluhan = kunjungan.keluhan;
    formEdit.dokter_id = kunjungan.dokter_id;
    formEdit.tensi = kunjungan.tensi;
    formEdit.suhu = kunjungan.suhu;
    formEdit.catatan = kunjungan.catatan;
    formEdit.tanggal_kunjungan = kunjungan.tanggal_kunjungan;

    currentId.value = kunjungan.id;
}

function closeModal() {
    isOpen.value = false;
    isOpenEdit.value = false;
    form.reset();
    form.clearErrors();
    formEdit.reset();
    formEdit.clearErrors();
}

function openDeleteModal(item) {
    selectedItem.value = item;
    isDeleteOpen.value = true;
}

/* --- STATE MODAL & PREVIEW --- */
const currentId = ref(null);
const isOpen = ref(false);
const isOpenEdit = ref(false);
const isDeleteOpen = ref(false);
const selectedItem = ref({});

/* --- CRUD --- */
function submit() {
    form.post("/pendaftaran/kunjungan/store", {
        forceFormData: true,
        onSuccess: () => closeModal(),
    });
}

function submitUpdate() {
    formEdit
        .transform((d) => ({ ...d, _method: "PUT" }))
        .post(`/pendaftaran/kunjungan/update/${currentId.value}`, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
}

function deleteData() {
    form.delete(route("kunjungan.destroy", selectedItem.value.id), {
        onSuccess: () => (isDeleteOpen.value = false),
    });
}

/* --- ESCAPE KEY CLOSE MODAL --- */
const closeOnEscape = (e) => {
    if (e.key === "Escape") closeModal();
};
onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

/* --- COMPUTED --- */
const kunjungans = computed(() => usePage().props.kunjungans);
const pasienList = computed(() => usePage().props.pasienList);
const dokterList = computed(() => usePage().props.dokterList);
</script>