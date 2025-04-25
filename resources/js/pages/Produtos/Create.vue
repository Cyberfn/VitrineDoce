<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    confeitarias: Array,
});

const form = useForm({
    nome: '',
    valor: '',
    descricao: '',
    imagens: [],
    confeitaria_id: '',
});

const preview_urls = ref([]);

function get_imagens_input(e) {
    const files = Array.from(e.target.files);
    form.imagens.push(...files);
    files.forEach((file) => {
        preview_urls.value.push(URL.createObjectURL(file));
    });
}

function remove_image(index) {
    form.imagens.splice(index, 1);
    preview_urls.value.splice(index, 1);
}

function submit() {
    const valor_num = parseFloat(form.valor.toString());

    if (isNaN(valor_num) || valor_num <= 0) {
        alert('O valor do produto deve ser maior que zero.');
        return;
    }

    if (valor_num > 99999.99) {
        alert('O valor do produto é muito alto. Máximo permitido: R$99.999,99.');
        return;
    }

    form.post(route('produtos.store'), {
        forceFormData: true,
        onSuccess: () => {
            alert('Produto cadastrado com sucesso!');
        },
        onError: () => {
            alert('Erro ao cadastrar. Verifique os campos.');
        },
    });
}
</script>

<template>
    <div class="min-h-screen bg-white">
        <Navbar />

        <div class="mx-auto mt-10 max-w-3xl rounded-2xl bg-white p-6 shadow-md">
            <h1 class="mb-6 text-center text-2xl font-bold">Cadastro de Produto</h1>

            <form @submit.prevent="submit" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block font-semibold">Nome do Produto</label>
                    <input v-model="form.nome" type="text" class="w-full rounded border p-2" required />
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Valor (R$)</label>
                    <input v-model="form.valor" type="number" step="0.01" min="0.01"  max="99999.99" class="w-full rounded border p-2" required />
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-semibold">Descrição</label>
                    <textarea v-model="form.descricao" class="w-full rounded border p-2" rows="3" style="resize: none" required></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-semibold">Imagens</label>
                    <input
                        type="file"
                        class="w-full rounded border p-2"
                        multiple
                        @change="get_imagens_input"
                        accept=".jpg, .jpeg, image/jpeg"
                        required
                    />
                    <div v-if="preview_urls.length" class="mt-4 flex flex-wrap gap-4">
                        <div v-for="(url, index) in preview_urls" :key="index" class="relative">
                            <img :src="url" class="h-24 rounded shadow" />
                            <button
                                type="button"
                                @click="remove_image(index)"
                                class="absolute -top-2 -right-2 rounded-full bg-red-500 px-2 text-xs text-white hover:bg-red-600"
                            >
                                ×
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block font-semibold">Confeitaria</label>
                    <select v-model="form.confeitaria_id" class="w-full rounded border p-2" required>
                        <option value="" disabled>Selecione uma confeitaria</option>
                        <option v-for="confeitaria in confeitarias" :key="confeitaria.id" :value="confeitaria.id">
                            {{ confeitaria.nome }}
                        </option>
                    </select>
                </div>

                <div class="col-span-full mt-4 text-center">
                    <button type="submit" class="rounded-xl bg-pink-500 px-6 py-2 text-white transition hover:bg-pink-600">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</template>
