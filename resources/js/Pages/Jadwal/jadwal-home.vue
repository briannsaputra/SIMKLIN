<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <main class="bg-gray-50 p-6 rounded-2xl">
            <div class="max-w-7xl mx-auto">
                <div class="mb-5 flex items-center justify-between">
                    <h1 class="text-[22px] font-bold text-gray-900 mb-2">
                        List Jadwal Dokter
                    </h1>

                    <button @click="isOpen = true"
                        class="px-3 py-3 text-sm bg-[#064e88] text-white font-semibold rounded-lg shadow-xl hover:bg-[#064e88] transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#064e88] flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Data Jadwal Dokter</span>
                    </button>
                </div>
                <!-- ALERT -->
                <!-- <div v-if="message" :class="alertClasses"
                    class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg transition-all duration-300">
                    <span>{{ message }}</span>
                    <button @click="close" class="ml-4 font-bold">×</button>
                </div> -->
                <div class="shadow bg-white">
                    <!-- Search -->
                    <!-- <div class="pt-3 px-4">
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
                    </div> -->
                    <div class="overflow-x-auto bg-white rounded-xl shadow">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-100">
                                    <th class="px-3 py-3 text-left text-sm font-semibold text-gray-600">
                                        No
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Nama Dokter
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Hari
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Jam Mulai
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Jam Selesai
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Kaota
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in jadwalDokters" :key="item.id"
                                    class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-700">
                                        {{ item.dokter.nama_dokter }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.hari }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ item.jam_mulai }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.jam_selesai }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ item.kuota }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ item.aktif }}
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

                                            <!-- <Link :href="$route('kunjungan.show', item.id)"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-semibold rounded-full shadow-sm text-gray-800 bg-gray-200 hover:bg-gray-300 hover:shadow-md transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Detail
                                            </Link> -->
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
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watchEffect } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";


/* --- COMPUTED --- */
const jadwalDokters = computed(() => usePage().props.jadwalDokters);
</script>