<template>
    <div
        class="col-span-1 lg:col-span-12 space-y-6 bg-white rounded-2xl shadow"
    >
        <div
            class="p-4 bg-gray-50 rounded-3xl shadow-2xl border border-gray-200"
        >
            <header class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-3">
                    💻 Panel Admin Antrian
                </h1>
                <p class="text-gray-500 mt-2">
                    Kelola antrian dan panggil nomor berikutnya.
                </p>
            </header>

            <section
                class="mb-8 p-6 bg-white rounded-xl shadow-lg border-l-4 border-green-500"
            >
                <h2 class="text-xl font-semibold text-gray-700 mb-4">
                    Aksi Cepat
                </h2>
                <button
                    @click="callNext"
                    class="w-full px-6 py-3 text-lg rounded-lg font-bold bg-green-600 text-white shadow-md transform transition duration-300 hover:bg-green-700 hover:scale-[1.01] active:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 disabled:opacity-50"
                    :disabled="waiting.length === 0"
                >
                    Panggil Nomor Berikutnya ({{
                        waiting.length > 0
                            ? "#" + waiting[0].number
                            : "Antrian Kosong"
                    }})
                </button>
                <p
                    v-if="waiting.length === 0"
                    class="text-sm text-center text-gray-500 mt-2"
                >
                    Tidak ada tiket menunggu untuk dipanggil.
                </p>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div
                    class="p-6 bg-blue-100 rounded-xl shadow-inner border border-blue-300"
                >
                    <h2 class="text-xl font-bold text-blue-800 mb-4">
                        Sedang Dilayani
                    </h2>

                    <div v-if="current" class="text-center">
                        <div class="text-7xl font-black text-blue-600 mb-3">
                            {{ current.number }}
                        </div>
                        <div class="text-sm text-gray-600 mb-4">
                            Waktu Panggil: **{{ current.created_at }}**
                        </div>

                        <button
                            @click="finish(current.id)"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            ✅ Selesai Layani
                        </button>
                    </div>

                    <div v-else class="text-center py-6 text-gray-500">
                        <p class="text-3xl font-bold">---</p>
                        <p>Tidak ada nomor yang sedang aktif dipanggil.</p>
                    </div>
                </div>

                <div
                    class="p-6 bg-white rounded-xl shadow-lg border border-gray-200"
                >
                    <h3 class="text-xl font-bold text-gray-700 mb-4">
                        Menunggu:
                        <span class="text-blue-500">{{ waiting.length }}</span>
                        Tiket
                    </h3>

                    <ul class="space-y-3 max-h-72 overflow-y-auto pr-2">
                        <li
                            v-for="t in waiting"
                            :key="t.id"
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100 shadow-sm"
                        >
                            <span class="text-2xl font-semibold text-gray-800">
                                #{{ t.number }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Masuk: {{ t.created_at }}
                            </span>
                        </li>
                        <li
                            v-if="waiting.length === 0"
                            class="text-center text-gray-400 py-4"
                        >
                            Semua antrian telah kosong.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const current = ref(null);
const waiting = ref([]);

async function load() {
    try {
        const res = await fetch("/api/antrian/status");
        if (!res.ok) throw await res.text(); // Debug mudah

        const data = await res.json();
        current.value = data.current;
        waiting.value = data.waiting;
    } catch (error) {
        console.error("ERROR LOAD STATUS:", error);
        alert("Gagal load status antrian! Cek route API.");
    }
}

async function callNext() {
    const res = await fetch("/antrian/call-next", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
                .content,
        },
    });

    const data = await res.json();
    current.value = data.ticket;
    waiting.value.shift();
}

async function finish(id) {
    await fetch(`/antrian/${id}/finish`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
                .content,
        },
    });
}

onMounted(load);

// === REALTIME LISTENER ===
if (window.Echo) {
    window.Echo.channel("antrian").listen(".ticket.updated", (e) => {
        if (e.meta?.type === "called") {
            current.value = e.ticket;
            waiting.value = waiting.value.filter((w) => w.id !== e.ticket.id);
        } else if (e.meta?.type === "created") {
            waiting.value.push(e.ticket);
        } else if (e.meta?.type === "finished") {
            if (current.value && current.value.id === e.ticket.id) {
                current.value = null;
            }
        }
    });
}
</script>
