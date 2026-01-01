<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <main class="bg-gray-50 p-6 rounded-2xl">
            <div class="max-w-7xl mx-auto">
                <div class="mb-5 flex items-center justify-between">
                    <h1 class="text-[22px] font-bold text-gray-900 mb-2">
                        List Pasien
                    </h1>

                    <button @click="isOpen = true"
                        class="px-3 py-3 text-sm bg-[#064e88] text-white font-semibold rounded-lg shadow-xl hover:bg-[#064e88] transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#064e88] flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Data Pasien</span>
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
                            <input v-model="searchForm.search" type="text" placeholder="Cari pasien..."
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
                                        Tanggal Lahir
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Status BPJS
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        No Hp
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in pasiens" :key="item.id"
                                    class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        {{ item.no_rm }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.nik }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ formatTanggal(item.tanggal_lahir) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap"
                                            :class="[
                                                item.status_bpjs === 'Aktif' && 'bg-green-100 text-green-700',
                                                item.status_bpjs === 'Tidak Aktif' && 'bg-red-100 text-red-700',
                                                item.status_bpjs === 'Baru' && 'bg-blue-100 text-blue-700',
                                                item.status_bpjs === 'PBI' && 'bg-purple-100 text-purple-700',
                                                item.status_bpjs === 'Non BPJS' && 'bg-gray-100 text-gray-700'
                                            ]">
                                            <!-- Desktop -->
                                            <span class="hidden sm:inline">
                                                {{ item.status_bpjs }}
                                            </span>

                                            <!-- Mobile -->
                                            <span class="sm:hidden">
                                                {{ item.status_bpjs === 'Tidak Aktif' ? 'Non Aktif' : item.status_bpjs
                                                }}
                                            </span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.telepon }}
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

                                            <Link :href="$route('pasien.show', item.id)"
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
            @click="isOpen = false"></div>
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
                            Tambah Data Pasien
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
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nama Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="form.nama"
                                                    placeholder="Masukkan nama lengkap pasien"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.nama" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.nama }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nik KTP
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h5v3H4V5zm0 5h12v2H4v-2zm0 4h8v2H4v-2z" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="form.nik" placeholder="Masukkan nik ktp"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.nik" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.nik }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Tanggal Lahir
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" />
                                                        <path d="M18 8H2v8a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                                    </svg>
                                                </span>

                                                <input type="date" v-model="form.tanggal_lahir" :class="{
                                                    'text-gray-400':
                                                        !form.status_bpjs,
                                                    'text-gray-700':
                                                        form.status_bpjs,
                                                }"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.tanggal_lahir"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.tanggal_lahir }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                No Hp
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M2.003 5.884c-.05-1.33.97-2.543 2.293-2.593l2.29-.088c.927-.036 1.74.57 1.98 1.457l.55 2.02a2.04 2.04 0 01-.45 1.86l-1.12 1.25a11.64 11.64 0 005.09 5.09l1.25-1.12a2.04 2.04 0 011.86-.45l2.02.55c.887.24 1.493 1.053 1.457 1.98l-.088 2.29c-.05 1.323-1.263 2.343-2.593 2.293C9.943 18.82 1.18 10.057 2.003 5.884z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <input type="number" v-model="form.telepon" placeholder="Masukan no hp"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.telepon" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.telepon }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Elergi Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 2a1 1 0 01.894.553l7 14A1 1 0 0117 18H3a1 1 0 01-.894-1.447l7-14A1 1 0 0110 2zm0 5a1 1 0 00-1 1v3a1 1 0 002 0V8a1 1 0 00-1-1zm0 8a1.25 1.25 0 110-2.5A1.25 1.25 0 0110 15z" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="form.alergi"
                                                    placeholder="Contoh: Debu, Obat tertentu, Makanan laut, dll."
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.alergi" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.alergi }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Jenis Kelamin
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12 2a4 4 0 100 8 4 4 0 000-8zM9 14a1 1 0 011-1h1v-1a1 1 0 112 0v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 01-1-1z" />
                                                    </svg>
                                                </span>

                                                <select v-model="form.jenis_kelamin" :class="{
                                                    'text-gray-400':
                                                        !form.status_bpjs,
                                                    'text-gray-700':
                                                        form.status_bpjs,
                                                }"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 rounded-md">
                                                    <option value="" disabled>
                                                        Pilih jenis kelamin
                                                    </option>
                                                    <option value="L">
                                                        Laki-laki
                                                    </option>
                                                    <option value="P">
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.jenis_kelamin"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.jenis_kelamin }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Status BPJS
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h5v3H4V5zm0 5h12v2H4v-2zm0 4h8v2H4v-2z" />
                                                    </svg>
                                                </span>

                                                <select v-model="form.status_bpjs" :class="{
                                                    'text-gray-400':
                                                        !form.status_bpjs,
                                                    'text-gray-700':
                                                        form.status_bpjs,
                                                }"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 rounded-md text-gray-400">
                                                    <option value="" disabled>
                                                        Pilih Status BPJS
                                                    </option>
                                                    <option value="Aktif">
                                                        BPJS Aktif
                                                    </option>
                                                    <option value="Tidak Aktif">
                                                        BPJS Tidak Aktif
                                                    </option>
                                                    <option value="Baru">
                                                        BPJS Baru / Pendaftaran
                                                        Baru
                                                    </option>
                                                    <option value="PBI">
                                                        BPJS PBI (KIS)
                                                    </option>
                                                    <option value="Non BPJS">
                                                        Non BPJS / Umum
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.status_bpjs" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.status_bpjs }}
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
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Alamat
                                            </label>

                                            <div class="flex items-start relative">
                                                <span
                                                    class="absolute left-0 pt-2 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M10 2a6 6 0 00-6 6c0 4.4 6 10 6 10s6-5.6 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                                    </svg>
                                                </span>

                                                <textarea v-model="form.alamat" placeholder="Masukkan alamat lengkap"
                                                    rows="3"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] focus:outline-none px-3 py-2 pl-10 text-sm rounded-md shadow-sm transition duration-300 placeholder-gray-400"></textarea>
                                            </div>

                                            <div v-if="form.errors.alamat" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.alamat }}
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
                            Edit Data Pasien
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
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nama Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="formEdit.nama"
                                                    placeholder="Masukkan nama lengkap pasien"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.nama" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.nama }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nik KTP
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h5v3H4V5zm0 5h12v2H4v-2zm0 4h8v2H4v-2z" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="formEdit.nik" placeholder="Masukkan nik ktp"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.nik" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.nik }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Tanggal Lahir
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" />
                                                        <path d="M18 8H2v8a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                                    </svg>
                                                </span>

                                                <input type="date" v-model="formEdit.tanggal_lahir
                                                    " :class="{
                                                        'text-gray-400':
                                                            !formEdit.status_bpjs,
                                                        'text-gray-700':
                                                            formEdit.status_bpjs,
                                                    }"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="
                                                formEdit.errors
                                                    .tanggal_lahir
                                            " class="text-red-500 text-xs mt-1 pl-1">
                                                {{
                                                    formEdit.errors
                                                        .tanggal_lahir
                                                }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                No Hp
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M2.003 5.884c-.05-1.33.97-2.543 2.293-2.593l2.29-.088c.927-.036 1.74.57 1.98 1.457l.55 2.02a2.04 2.04 0 01-.45 1.86l-1.12 1.25a11.64 11.64 0 005.09 5.09l1.25-1.12a2.04 2.04 0 011.86-.45l2.02.55c.887.24 1.493 1.053 1.457 1.98l-.088 2.29c-.05 1.323-1.263 2.343-2.593 2.293C9.943 18.82 1.18 10.057 2.003 5.884z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <input type="number" v-model="formEdit.telepon"
                                                    placeholder="Masukan no hp"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.telepon" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.telepon }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Elergi Pasien
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 2a1 1 0 01.894.553l7 14A1 1 0 0117 18H3a1 1 0 01-.894-1.447l7-14A1 1 0 0110 2zm0 5a1 1 0 00-1 1v3a1 1 0 002 0V8a1 1 0 00-1-1zm0 8a1.25 1.25 0 110-2.5A1.25 1.25 0 0110 15z" />
                                                    </svg>
                                                </span>

                                                <input type="text" v-model="formEdit.alergi"
                                                    placeholder="Contoh: Debu, Obat tertentu, Makanan laut, dll."
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="formEdit.errors.alergi" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.alergi }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Jenis Kelamin
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12 2a4 4 0 100 8 4 4 0 000-8zM9 14a1 1 0 011-1h1v-1a1 1 0 112 0v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 01-1-1z" />
                                                    </svg>
                                                </span>

                                                <select v-model="formEdit.jenis_kelamin
                                                    " :class="{
                                                        'text-gray-400':
                                                            !formEdit.status_bpjs,
                                                        'text-gray-700':
                                                            formEdit.status_bpjs,
                                                    }"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 rounded-md">
                                                    <option value="" disabled>
                                                        Pilih jenis kelamin
                                                    </option>
                                                    <option value="L">
                                                        Laki-laki
                                                    </option>
                                                    <option value="P">
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="
                                                formEdit.errors
                                                    .jenis_kelamin
                                            " class="text-red-500 text-xs mt-1 pl-1">
                                                {{
                                                    formEdit.errors
                                                        .jenis_kelamin
                                                }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Status BPJS
                                            </label>

                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h5v3H4V5zm0 5h12v2H4v-2zm0 4h8v2H4v-2z" />
                                                    </svg>
                                                </span>

                                                <select v-model="formEdit.status_bpjs
                                                    "
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 rounded-md"
                                                    :class="formEdit.status_bpjs
                                                        ? 'text-gray-700'
                                                        : 'text-gray-400'
                                                        ">
                                                    <option value="" disabled>
                                                        Pilih Status BPJS
                                                    </option>

                                                    <option value="Aktif">
                                                        BPJS Aktif
                                                    </option>
                                                    <option value="Tidak Aktif">
                                                        BPJS Tidak Aktif
                                                    </option>
                                                    <option value="Baru">
                                                        BPJS Baru / Pendaftaran
                                                        Baru
                                                    </option>
                                                    <option value="PBI">
                                                        BPJS PBI (KIS)
                                                    </option>
                                                    <option value="Non BPJS">
                                                        Non BPJS / Umum
                                                    </option>
                                                </select>
                                            </div>

                                            <div v-if="
                                                formEdit.errors.status_bpjs
                                            " class="text-red-500 text-xs mt-1 pl-1">
                                                {{
                                                    formEdit.errors.status_bpjs
                                                }}
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
                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Alamat
                                            </label>

                                            <div class="flex items-start relative">
                                                <span
                                                    class="absolute left-0 pt-2 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M10 2a6 6 0 00-6 6c0 4.4 6 10 6 10s6-5.6 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                                    </svg>
                                                </span>

                                                <textarea v-model="formEdit.alamat"
                                                    placeholder="Masukkan alamat lengkap" rows="3"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] focus:outline-none px-3 py-2 pl-10 text-sm rounded-md shadow-sm transition duration-300 placeholder-gray-400"></textarea>
                                            </div>

                                            <div v-if="formEdit.errors.alamat" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.alamat }}
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
                                    @click="isOpenEdit = false">
                                    Batal
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
                <strong>{{ selectedItem.nama }}</strong>?
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
import { Link } from '@inertiajs/vue3'

/* --- FORM SEARCH --- */
const searchForm = useForm({
    search: usePage().props.search ?? ''
})

function submitSearch() {
    searchForm.get(route('pasien.home'), {
        preserveState: true,
        replace: true,
    })
}

/* --- FORM TAMBAH --- */
const form = useForm({
    nama: "",
    nik: "",
    tanggal_lahir: "",
    jenis_kelamin: "",
    alamat: "",
    telepon: "",
    status_bpjs: "",
    alergi: "",
    catatan: "",
});

/* --- FORM EDIT --- */
const formEdit = useForm({
    nama: "",
    nik: "",
    tanggal_lahir: "",
    jenis_kelamin: "",
    alamat: "",
    telepon: "",
    status_bpjs: "",
    alergi: "",
    catatan: "",
});

/* --- STATE MODAL & PREVIEW --- */
const currentId = ref(null);
const isOpen = ref(false);
const isOpenEdit = ref(false);
const isDeleteOpen = ref(false);
const selectedItem = ref({});

/* --- ALERT & FLASH --- */
const message = ref(null);
const type = ref("success");
const page = usePage();

const formatTanggal = (tgl) =>
    tgl
        ? new Date(tgl).toLocaleDateString('id-ID')
        : '-'


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
function openEditModal(pasien) {
    // buka modal edit
    isOpenEdit.value = true;
    formEdit.nama = pasien.nama;
    formEdit.nik = pasien.nik;
    formEdit.tanggal_lahir = pasien.tanggal_lahir;
    formEdit.jenis_kelamin = pasien.jenis_kelamin;
    formEdit.alamat = pasien.alamat;
    formEdit.telepon = pasien.telepon;
    formEdit.status_bpjs = pasien.status_bpjs;
    formEdit.alergi = pasien.alergi;
    formEdit.catatan = pasien.catatan;
    currentId.value = pasien.id;
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

/* --- CRUD --- */
function submit() {
    form.post("/pendaftaran/pasien/store", {
        forceFormData: true,
        onSuccess: () => closeModal(),
    });
}
function submitUpdate() {
    formEdit
        .transform((d) => ({ ...d, _method: "PUT" }))
        .post(`/pendaftaran/pasien/update/${currentId.value}`, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
}
function deleteData() {
    form.delete(route("pasien.destroy", selectedItem.value.id), {
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
const pasiens = computed(() => usePage().props.pasiens);
</script>
