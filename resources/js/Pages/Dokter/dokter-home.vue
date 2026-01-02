<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <main class="bg-gray-50 p-6 rounded-2xl">
            <div class="max-w-7xl mx-auto">
                <div class="mb-5 flex items-center justify-between">
                    <h1 class="text-[22px] font-bold text-gray-900 mb-2">
                        List Dokter
                    </h1>

                    <button @click="isOpen = true"
                        class="px-3 py-3 text-sm bg-[#064e88] text-white font-semibold rounded-lg shadow-xl hover:bg-[#064e88] transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#064e88] flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Data Dokter</span>
                    </button>
                </div>
                <!-- ALERT -->
                <div v-if="message" :class="alertClasses"
                    class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg transition-all duration-300">
                    <span>{{ message }}</span>
                    <button @click="close" class="ml-4 font-bold">×</button>
                </div>

                <div class="shadow bg-white">
                    <div class="overflow-x-auto bg-white rounded-xl shadow">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-100">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        No
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Foto
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Nama
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Spesialis
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        No Hp
                                    </th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in dokters" :key="item.id"
                                    class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center border">
                                                <img v-if="item.image_url" :src="item.image_url" alt="image"
                                                    class="w-full h-full object-cover" />

                                                <!-- SVG kalau foto null -->
                                                <svg v-else class="w-7 h-7 text-gray-500" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 
                    2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 
                    5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.nama_dokter }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.poli.nama_poli }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.no_hp }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button @click="openEditModal(item)"
                                            class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                            Edit
                                        </button>
                                        <button @click="openDeleteModal(item)"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded hover:bg-red-200 transition ml-2">
                                            Hapus
                                        </button>
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
                    class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-4 border-[#064e88]">
                    <!-- Header Modal -->
                    <div class="bg-blue-100 p-6 sm:p-7 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-[#064e88]" id="modal-title">
                            Tambah Data Dokter
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
                                    <div class="mt-2 space-y-6">
                                        <div class="group relative">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Foto Dokter
                                            </label>

                                            <div class="flex items-center space-x-4">
                                                <!-- Preview -->
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300 overflow-hidden">
                                                        <!-- Jika ada preview, tampilkan gambar -->
                                                        <img v-if="preview" :src="preview" alt="Preview"
                                                            class="h-full w-full object-cover rounded-full" />

                                                        <!-- Jika belum ada preview, tampilkan icon -->
                                                        <svg v-else class="h-8 w-8" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Upload -->
                                                <label for="file-upload"
                                                    class="relative cursor-pointer bg-white py-2 px-4 border border-[#064e88] rounded-full shadow-md text-sm font-semibold text-[#064e88] hover:bg-indigo-50 transition duration-150 ease-in-out focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#064e88]">
                                                    <span>Upload Foto</span>
                                                    <input id="file-upload" type="file" accept="image/*" class="sr-only"
                                                        @change="
                                                            handleFileChange
                                                        " />
                                                </label>

                                                <p class="text-sm text-gray-500 hidden sm:block">
                                                    Max. 5MB (JPG/PNG)
                                                </p>
                                            </div>
                                        </div>
                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nama Dokter
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

                                                <input type="text" v-model="form.nama_dokter"
                                                    placeholder="Masukkan nama lengkap dokter"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.nama_dokter" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.nama_dokter }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Poli Dokter
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88]">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M6 2a1 1 0 00-1 1v4a5 5 0 004 4v2a5 5 0 0010 0v-1a3 3 0 10-2 0v1a3 3 0 11-6 0v-2a5 5 0 004-4V3a1 1 0 10-2 0v4a3 3 0 01-6 0V3a1 1 0 00-1-1z" />
                                                    </svg>
                                                </span>
                                                <select v-model="form.poli_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Poli Dokter
                                                    </option>

                                                    <option v-for="poli in poliList" :key="poli.id" :value="poli.id">
                                                        {{ poli.nama_poli }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.poli_id" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.poli_id }}
                                            </div>
                                        </div>
                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                No. HP
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06L6 10.395a7 7 0 006.525 6.524l1.15-1.04a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                    </svg>
                                                </span>
                                                <input type="text" v-model="form.no_hp"
                                                    placeholder="Contoh: 081234567890"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.no_hp" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.no_hp }}
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

    <!-- Modal Edit -->
    <transition enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="isOpenEdit" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-4 border-[#064e88]">
                    <!-- Header -->
                    <div class="bg-blue-100 p-6 sm:p-7 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-[#064e88]">
                            Edit Data Dokter
                        </h3>
                        <button @click="isOpenEdit = false" class="text-[#053c66] hover:text-[#064e88] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <form @submit.prevent="submitUpdate">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <div class="mt-2 space-y-6">
                                        <!-- Foto -->
                                        <div class="group relative">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                                                Foto Dokter
                                            </label>

                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300 overflow-hidden">
                                                        <img v-if="previewEdit" :src="previewEdit"
                                                            class="h-full w-full object-cover rounded-full" />

                                                        <svg v-else class="h-8 w-8" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>

                                                <label
                                                    class="relative cursor-pointer bg-white py-2 px-4 border border-[#064e88] rounded-full shadow-md text-sm font-semibold text-[#064e88] hover:bg-indigo-50 transition">
                                                    <span>Upload Foto</span>
                                                    <input type="file" class="sr-only" accept="image/*" @change="
                                                        handleFileChangeEdit
                                                    " />
                                                </label>

                                                <p class="text-sm text-gray-500 hidden sm:block">
                                                    Max. 5MB (JPG/PNG)
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Nama -->
                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                                                Nama Dokter
                                            </label>
                                            <input type="text" v-model="formEdit.nama_dokter"
                                                class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 text-sm rounded-md" />
                                            <div v-if="
                                                formEdit.errors.nama_dokter
                                            " class="text-red-500 text-xs mt-1 pl-1">
                                                {{
                                                    formEdit.errors.nama_dokter
                                                }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Poli Dokter
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
                                                <select v-model="formEdit.poli_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Poli Dokter
                                                    </option>
                                                    <option v-for="poli in poliList" :key="poli.id" :value="poli.id">
                                                        {{ poli.nama_poli }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="formEdit.errors.poli_id" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.poli_id }}
                                            </div>
                                        </div>
                                        <!-- No HP -->
                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                                                No. HP
                                            </label>
                                            <input type="text" v-model="formEdit.no_hp"
                                                class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 text-sm rounded-md" />
                                            <div v-if="formEdit.errors.no_hp" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ formEdit.errors.no_hp }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg shadow-sm px-4 py-2 bg-[#064e88] text-base font-medium text-white hover:bg-[#053c66] sm:ml-3 sm:w-auto sm:text-sm">
                                    Update
                                </button>
                                <button type="button" @click="isOpenEdit = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base text-gray-700 hover:bg-gray-100 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
                <strong>{{ selectedItem.nama_dokter }}</strong>?
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
import { watch } from "vue";


/* --- FORM TAMBAH --- */
const form = useForm({
    poli_id: "",
    nama_dokter: "",
    image: null,
    no_hp: "",
    image_old: "",
});

/* --- FORM EDIT --- */
const formEdit = useForm({
    poli_id: "",
    nama_dokter: "",
    no_hp: "",
    image: null,
    image_old: "",
});

/* --- STATE MODAL & PREVIEW --- */
const currentId = ref(null);
const preview = ref(null); // preview gambar tambah
const previewEdit = ref(null); // preview gambar edit
const isOpen = ref(false);
const isOpenEdit = ref(false);
const isDeleteOpen = ref(false);
const selectedItem = ref({});

/* --- ALERT & FLASH --- */
const message = ref(null);
const type = ref("success");
const page = usePage();

let alertTimeout = null;

watch(
    () => page.props.flash,
    (flash) => {
        if (!flash) return;

        if (flash.success) {
            message.value = flash.success;
            type.value = "success";
        } else if (flash.error) {
            message.value = flash.error;
            type.value = "error";
        } else {
            return;
        }

        if (alertTimeout) clearTimeout(alertTimeout);

        alertTimeout = setTimeout(() => {
            message.value = null;
            alertTimeout = null;
        }, 3000);
    },
    { deep: true }
);

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
function openEditModal(dokter) {
    // buka modal edit
    isOpenEdit.value = true;
    formEdit.nama_dokter = dokter.nama_dokter;
    formEdit.spesialis = dokter.spesialis;
    formEdit.poli_id = dokter.poli_id;
    formEdit.no_hp = dokter.no_hp;
    formEdit.image_old = dokter.image;
    formEdit.image = null;
    previewEdit.value = dokter.image_url || null;
    currentId.value = dokter.id;
}
function closeModal() {
    // tutup semua modal
    isOpen.value = false;
    isOpenEdit.value = false;
    form.reset();
    form.clearErrors();
    formEdit.reset();
    formEdit.clearErrors();
    if (preview.value) URL.revokeObjectURL(preview.value);
    if (previewEdit.value) URL.revokeObjectURL(previewEdit.value);
    preview.value = null;
    previewEdit.value = null;
}

function openDeleteModal(item) {
    selectedItem.value = item;
    isDeleteOpen.value = true;
}

/* --- CRUD --- */
function submit() {
    form.post("/dokter/store", {
        forceFormData: true,
        onSuccess: () => closeModal(),
    });
}
function submitUpdate() {
    formEdit
        .transform((d) => ({ ...d, _method: "PUT" }))
        .post(`/dokter/update/${currentId.value}`, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
}
function deleteData() {
    form.delete(route("dokter.destroy", selectedItem.value.id), {
        onSuccess: () => (isDeleteOpen.value = false),
    });
}

/* --- INPUT GAMBAR --- */
function handleFileChange(e) {
    const f = e.target.files[0];
    if (!f) return;
    form.image = f;
    if (preview.value) URL.revokeObjectURL(preview.value);
    preview.value = URL.createObjectURL(f);
}
function handleFileChangeEdit(e) {
    const f = e.target.files[0];
    if (!f) return;
    formEdit.image = f;
    if (previewEdit.value) URL.revokeObjectURL(previewEdit.value);
    previewEdit.value = URL.createObjectURL(f);
}

/* --- ESCAPE KEY CLOSE MODAL --- */
const closeOnEscape = (e) => {
    if (e.key === "Escape") closeModal();
};
onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

/* --- COMPUTED --- */
const dokters = computed(() => usePage().props.dokters);
const poliList = computed(() => usePage().props.poliList);
</script>
