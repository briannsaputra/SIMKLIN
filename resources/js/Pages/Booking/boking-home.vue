<template>
    <div class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow">
        <div class=" bg-gray-50">
            <div class="mx-5 my-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Riwayat Booking</h1>
                        <p class="text-gray-500 text-sm">Kelola dan pantau status janji temu medis Anda.</p>
                    </div>
                    <button @click="isOpen = true"
                        class="px-3 py-3 text-sm bg-[#064e88] text-white font-semibold rounded-lg shadow-xl hover:bg-[#064e88] transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#064e88] flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Data Dokter</span>
                    </button>
                    <!-- ALERT -->
                    <div v-if="message" :class="alertClasses"
                        class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg transition-all duration-300">
                        <span>{{ message }}</span>
                        <button @click="close" class="ml-4 font-bold">×</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <div v-for="(item, index) in bokings" :key="item.id"
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
                                                {{ item.kode_booking }} </span>
                                            <span
                                                class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-50 text-green-600">
                                                {{ item.status }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight">{{
                                            item.dokter.nama_dokter }}
                                        </h3>
                                        <p class="text-gray-500 text-sm mt-1">Pasien: <span
                                                class="font-medium text-gray-700">{{ item.nama_pemboking }}</span></p>
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
                                            <span class="text-sm font-medium">{{ formatTanggal(item.tanggal_booking)
                                                }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-widest mb-1">
                                            Keluhan</p>
                                        <p class="text-sm text-gray-600 line-clamp-1 italic">{{ item.keluhan }}</p>
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
                            Form Booking
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
                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Nama Lengkap
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

                                                <input type="text" v-model="form.nama_pemboking"
                                                    placeholder="Masukkan nama lengkap dokter"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.nama_pemboking"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.nama_pemboking }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-2">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Pilih Dokter
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
                                                <select v-model="form.dokter_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Dokter
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
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-[#064e88]">
                                                Pilih Hari
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
                                                <select v-model="form.jadwal_dokter_id"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] px-3 py-2 pl-10 text-sm rounded-md">
                                                    <option value="" disabled>
                                                        Pilih Hari
                                                    </option>

                                                    <option v-for="jadwal in jadwalDokter" :key="jadwal.id"
                                                        :value="jadwal.id">
                                                        Hari : {{ jadwal.hari }} . jam : {{ jadwal.jam_mulai }} - {{ jadwal.jam_selesai }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="form.errors.jadwal_dokter_id" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.jadwal_dokter_id }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Tanggal Boking
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

                                                <input type="date" v-model="form.tanggal_booking"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 group-hover:border-[#064e88] focus:outline-none focus:ring-0 focus:border-[#064e88] px-3 py-2 pl-10 text-sm shadow-sm transition duration-300 placeholder-gray-400 rounded-md" />
                                            </div>
                                            <div v-if="form.errors.tanggal_booking"
                                                class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.tanggal_booking }}
                                            </div>
                                        </div>

                                        <div class="group relative mb-4">
                                            <label
                                                class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 transition-colors duration-200 group-focus-within:text-[#064e88]">
                                                Keluhan
                                            </label>
                                            <div class="flex items-center relative">
                                                <span
                                                    class="absolute left-0 pt-2 pl-3 text-gray-400 group-focus-within:text-[#064e88] transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.516 11.586c.75 1.334-.213 2.999-1.742 2.999H3.483c-1.53 0-2.492-1.665-1.743-2.999L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-6a1 1 0 00-1 1v3a1 1 0 002 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                <textarea v-model="form.keluhan" placeholder="Masukan keluhan anda"
                                                    rows="1"
                                                    class="w-full bg-gray-50 border-b-2 border-gray-300 focus:border-[#064e88] focus:outline-none px-3 py-2 pl-10 text-sm rounded-md shadow-sm transition duration-300 placeholder-gray-400"></textarea>
                                            </div>
                                            <div v-if="form.errors.keluhan" class="text-red-500 text-xs mt-1 pl-1">
                                                {{ form.errors.keluhan }}
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
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watchEffect } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { watch } from "vue";

function formatTanggal(tanggal) {
    if (!tanggal) return '-'

    const date = new Date(tanggal)

    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(date)
}

/* --- JADWAL DOKTER --- */
const jadwal_dokter_id = ref(null)

const jadwalDokter = computed(() => {
    if (!form.dokter_id) return []

    const dokter = dokterList.value.find(
        (d) => d.id === form.dokter_id
    )

    return dokter ? dokter.jadwal : []
})

/* --- FORM TAMBAH --- */
const form = useForm({
    dokter_id: "",
    jadwal_dokter_id: "",
    nama_pemboking: "",
    tanggal_booking: null,
    status: "",
    keluhan: "",
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

/* --- CRUD --- */
function submit() {
    form.post("/boking/store", {
        forceFormData: true,
        onSuccess: () => closeModal(),
    });
}

/* --- COMPUTED --- */
const bokings = computed(() => usePage().props.bokings);
const dokterList = computed(() => usePage().props.dokterList);
</script>