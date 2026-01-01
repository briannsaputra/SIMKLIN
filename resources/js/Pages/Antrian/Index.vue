<template>
    <div
        class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow"
    >
        <div class="p-8 bg-white rounded-3xl shadow-2xl border border-gray-100">
            <header class="text-center mb-10">
                <h1
                    class="text-4xl font-extrabold text-blue-700 tracking-tight"
                >
                    🎟️ Layanan Antrian Digital
                </h1>
                <p class="text-gray-500 mt-2">
                    Sistem pengambilan dan pemanggilan nomor antrian.
                </p>
            </header>

            <section
                class="mb-10 p-6 bg-blue-50 rounded-xl border-2 border-blue-200"
            >
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">
                    Ambil Tiket Anda
                </h2>
                <div class="text-center">
                    <button
                        @click="ambil"
                        class="w-full sm:w-auto px-10 py-4 text-lg rounded-full font-bold bg-blue-600 text-white shadow-lg transform transition duration-300 hover:bg-blue-700 hover:scale-[1.02] active:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Ambil Tiket (Nomor **{{ nextNumber }}**)
                    </button>
                </div>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div
                    class="p-6 bg-green-50 rounded-xl shadow-inner border border-green-200"
                >
                    <h2
                        class="text-xl font-bold text-green-700 mb-3 flex items-center"
                    >
                        <svg
                            class="w-6 h-6 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5.882l-7 3.5v6.5m14 0v-6.5l-7-3.5m0 0a3.978 3.978 0 01-2 1.5c.5.5 1.5 1 2 1.5s1.5.5 2 1.5m-2-1.5z"
                            ></path>
                        </svg>
                        Sedang Dipanggil
                    </h2>
                    <div v-if="current" class="text-center">
                        <div
                            class="text-8xl font-black text-green-600 animate-pulse"
                        >
                            {{ current.number }}
                        </div>
                        <div class="text-sm text-gray-500 mt-2">
                            Dipanggil pada: **{{ current.called_at }}**
                        </div>
                    </div>
                    <div v-else class="text-center py-6">
                        <div class="text-4xl font-bold text-gray-400">---</div>
                        <div class="text-gray-500 mt-1">
                            Belum ada yang dipanggil
                        </div>
                    </div>
                </div>

                <div
                    class="p-6 bg-yellow-50 rounded-xl shadow-inner border border-yellow-200"
                >
                    <h2
                        class="text-xl font-bold text-yellow-700 mb-3 flex items-center"
                    >
                        <svg
                            class="w-6 h-6 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        Antrian Menunggu
                    </h2>
                    <div class="text-center py-6">
                        <div class="text-8xl font-black text-yellow-600">
                            {{ waiting_count }}
                        </div>
                        <div class="text-gray-500 mt-2">
                            Jumlah tiket dalam antrian
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

// ❌ HAPUS — tidak dibutuhkan & menyebabkan error
// import { Inertia } from '@inertiajs/inertia'

// Props dari Inertia
const props = defineProps({
    current: Object,
    nextNumber: Number,
    waiting_count: Number,
});

const current = ref(props.current);
const nextNumber = props.nextNumber;
const waiting_count = ref(props.waiting_count);

// Ambil tiket baru
function ambil() {
    fetch("/antrian/take", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
                .content,
        },
    })
        .then((r) => r.json())
        .then((data) => {
            alert("Tiket anda: " + data.ticket.number);
        });
}

// Realtime Echo Listener
if (window.Echo) {
    window.Echo.channel("antrian").listen(".ticket.updated", (e) => {
        if (e.meta?.type === "called") {
            current.value = e.ticket;
        } else if (e.meta?.type === "created") {
            waiting_count.value += 1;
        } else if (e.meta?.type === "finished") {
            if (current.value && current.value.id === e.ticket.id) {
                current.value = null;
            }
            waiting_count.value = Math.max(0, waiting_count.value - 1);
        }
    });
}
</script>
