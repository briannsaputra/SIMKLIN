<template>
    <nav class="w-full bg-[#064e88] text-white shadow-md relative">
        <div class="absolute right-0 top-0 h-[250px] opacity-15 pointer-events-none hidden md:block">
            <img :src="logobackround" alt="logo-backround" class="h-full object-cover opacity-40" />
        </div>

        <div class="relative max-w-7xl mx-auto px-4 md:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img :src="logoKlinik" class="w-14 h-14 rounded-xl bg-gray-100" alt="logo-klinik" />
                    <div class="leading-tight">
                        <p class="text-sm opacity-80">SIM Klinik</p>
                        <h1 class="text-xl font-bold whitespace-nowrap">
                            Klinik Sejahtara Kita
                        </h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <div class="flex items-center gap-6">
                        <BellIcon class="w-6 h-6 cursor-pointer text-white" />
                        <Squares2X2Icon class="w-6 h-6 cursor-pointer text-white" />
                    </div>
                    <div class="relative">
                        <img :src="logo" alt="Logo" class="w-12 h-12 rounded-full border-2 border-white cursor-pointer"
                            @click="toggleAvatar" />
                        <div v-if="avatarOpen"
                            class="absolute right-0 mt-2 bg-white text-gray-700 rounded-lg shadow-lg py-2 w-40 z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Pengaturan</a>
                            <hr class="my-2 border-gray-200" />
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
                <button class="md:hidden" @click="toggleMobileMenu">
                    <Bars3Icon class="w-8 h-8 cursor-pointer hover:opacity-70" />
                </button>
            </div>
            <div class="hidden md:flex flex-row gap-x-10 mt-5 text-sm font-semibold">
                <div class="relative w-fit">
                    <Link :href="$route('home')" class="relative pb-1 text-base hover:opacity-80 transition">
                    Beranda

                    <span :class="[
                        'absolute -bottom-4 left-0 h-1 bg-white rounded transition-all duration-200',
                        page.url === '/'
                            ? 'w-full opacity-100'
                            : 'w-0 opacity-0',
                    ]"></span>
                    </Link>
                </div>
                <div class="relative group w-fit">
                    <button class="flex items-center gap-1 text-base hover:opacity-80 transition relative">
                        Dokter
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-gray-100 transition-transform group-hover:rotate-180" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-2 w-60 bg-white text-[#064e88] rounded-lg shadow-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transform transition-all duration-200 origin-top invisible group-hover:visible z-50">
                        <div class="p-2">
                            <Link :href="$route('dokter.home')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <UserGroupIcon class="w-5 h-5" />
                            <span>List Dokter</span>
                            </Link>
                        </div>
                        <div class="p-2">
                            <Link :href="$route('poli.home')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <BuildingOffice2Icon class="w-5 h-5" />
                            <span>Poli Dokter</span>
                            </Link>
                        </div>
                    </div>
                    <span :class="[
                        'absolute -bottom-4 left-0 h-1 bg-white rounded transition-all duration-200',
                        page.url.startsWith('/dokter')
                            ? 'w-full opacity-100'
                            : 'w-0 opacity-0',
                    ]"></span>
                </div>
                <div class="relative group w-fit">
                    <button class="flex items-center gap-1 text-base hover:opacity-80 transition relative">
                        Pendaftaran Pasien
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-gray-100 transition-transform group-hover:rotate-180" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-2 w-[250px] bg-white text-[#064e88] rounded-lg shadow-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transform transition-all duration-200 origin-top invisible group-hover:visible z-50">
                        <div class="p-2">
                            <Link :href="$route('pasien.home')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <UserIcon class="w-5 h-5" />
                            <span>Pasien</span>
                            </Link>
                        </div>
                        <div class="p-2">
                            <Link :href="$route('kunjungan.home')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <ClipboardDocumentListIcon class="w-5 h-5" />
                            <span>Kunjungan Pasien</span>
                            </Link>
                        </div>
                    </div>
                    <span :class="[
                        'absolute -bottom-4 left-0 h-1 bg-white rounded transition-all duration-200',
                        page.url.startsWith('/pendaftaran')
                            ? 'w-full opacity-100'
                            : 'w-0 opacity-0',
                    ]"></span>
                </div>
                <div class="relative group w-fit">
                    <button class="flex items-center gap-1 text-base hover:opacity-80 transition relative">
                        Antrian
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-gray-100 transition-transform group-hover:rotate-180" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-2 w-[250px] bg-white text-[#064e88] rounded-lg shadow-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transform transition-all duration-200 origin-top invisible group-hover:visible z-50">
                        <div class="p-2">
                            <Link :href="$route('antrian.index')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <TicketIcon class="w-5 h-5" />
                            <span>Ambil Nomor Antrian</span>
                            </Link>
                        </div>
                        <div class="p-2">
                            <Link :href="$route('admin.antrian')"
                                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#064e88] hover:text-white transition border-b border-[#064e88]">
                            <SpeakerWaveIcon class="w-5 h-5" />
                            <span>Tampilkan Nomor Antrian</span>
                            </Link>
                        </div>
                    </div>
                    <span :class="[
                        'absolute -bottom-4 left-0 h-1 bg-white rounded transition-all duration-200',
                        page.url.startsWith('/antrian')
                            ? 'w-full opacity-100'
                            : 'w-0 opacity-0',
                    ]"></span>
                </div>
            </div>
        </div>
    </nav>
    <!-- MOBILE SIDEBAR -->
    <div class="fixed inset-0 bg-black/40 z-50 md:hidden" v-if="mobileMenu" @click.self="toggleMobileMenu">
        <div class="w-[80%] max-w-xs h-full bg-white text-[#064e88] p-6 overflow-y-auto">
            <div class="flex justify-end mb-6">
                <button @click="toggleMobileMenu"
                    class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full shadow">
                    ✕
                </button>
            </div>
            <div class="flex items-center gap-4 mb-8">
                <img :src="logoKlinik" class="w-14 h-14 rounded-xl" />
                <div>
                    <p class="text-xs opacity-70">SIM Klinik</p>
                    <h1 class="text-lg font-bold">Klinik Pratama Citra Medika</h1>
                </div>
            </div>
            <div class="text-sm font-semibold space-y-5">
                <Link class="block pb-2 border-b">Beranda</Link>
                <div>
                    <div class="flex justify-between cursor-pointer" @click="jadwalOpen = !jadwalOpen">
                        <span>Pendaftaran Pasien</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition"
                            :class="{ 'rotate-180': jadwalOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div v-if="jadwalOpen" class="ml-4 mt-3 text-sm space-y-2">
                        <Link class="block">List Dokter</Link>
                        <Link class="block">Tambah Dokter</Link>
                    </div>
                    <div class="border-b mt-3"></div>
                </div>
                <div>
                    <div class="flex justify-between cursor-pointer" @click="jadwalOpen = !jadwalOpen">
                        <span>Booking</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition"
                            :class="{ 'rotate-180': jadwalOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div v-if="jadwalOpen" class="ml-4 mt-3 text-sm space-y-2">
                        <Link class="block">List Dokter</Link>
                        <Link class="block">Tambah Dokter</Link>
                    </div>
                    <div class="border-b mt-3"></div>
                </div>
                <div>
                    <div class="flex justify-between cursor-pointer" @click="jadwalOpen = !jadwalOpen">
                        <span>Antrian</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition"
                            :class="{ 'rotate-180': jadwalOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div v-if="jadwalOpen" class="ml-4 mt-3 text-sm space-y-2">
                        <Link class="block">List Dokter</Link>
                        <Link class="block">Tambah Dokter</Link>
                    </div>
                    <div class="border-b mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto p-4 lg:p-4 grid grid-cols-1 lg:grid-cols-12 gap-5 mt-0">
        <slot />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    BellIcon,
    Squares2X2Icon,
    Bars3Icon,
    UserGroupIcon,
    SpeakerWaveIcon,
    TicketIcon,
    UserIcon,
    ClipboardDocumentListIcon,
    BuildingOffice2Icon,
} from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";

import logo from "@/assets/images/brian-saputra.jpg";
import logoKlinik from "@/assets/images/logo-klinik.png";
import logobackround from "@/assets/images/backround-patrent.png";

const page = usePage();

const avatarOpen = ref(false);
const jadwalOpen = ref(false);

function toggleAvatar() {
    avatarOpen.value = !avatarOpen.value;
}

const mobileMenu = ref(false);
function toggleMobileMenu() {
    mobileMenu.value = !mobileMenu.value;
}
</script>
