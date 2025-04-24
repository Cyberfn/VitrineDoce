<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const form = ref({
    nome: '',
    telefone: '',
    cep: '',
    rua: '',
    numero: '',
    complemento: '',
    bairro: '',
    cidade: '',
    estado: '',
    latitude: '',
    longitude: '',
});
watch(
    () => form.value.cep,
    (newCep) => {
        const cep = newCep.replace(/\D/g, '');
        if (cep.length === 8) {
            buscar_cep(cep);
        }
    },
); 
function buscar_cep(cep: string) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then((res) => res.json())
        .then((data) => {
            if (!data.erro) {
                form.value.rua = data.logradouro;
                form.value.bairro = data.bairro;
                form.value.cidade = data.localidade;
                form.value.estado = data.uf;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${data.logradouro},${data.localidade},${data.uf}`)
                    .then((res) => res.json())
                    .then((coords) => {
                        if (coords.length > 0) {
                            form.value.latitude = coords[0].lat;
                            form.value.longitude = coords[0].lon;
                        }
                    });
            }
        });
}

const buscar_cepManual = () => {
    const cep = form.value.cep.replace(/\D/g, '');
    if (cep.length === 8) {
        buscar_cep(cep);
    }
};

const submit = () => {
    router.post('/confeitarias', form.value, {
        onSuccess: () => {
            alert('Confeitaria cadastrada com sucesso!');
        },
        onError: () => {
            alert('Erro ao cadastrar. Verifique os campos.');
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-white">
        <Navbar />

        <div class="mx-auto mt-10 max-w-3xl rounded-2xl bg-white p-6 shadow-md">
            <h1 class="mb-6 text-center text-2xl font-bold">Cadastro de Confeitaria</h1>

            <form @submit.prevent="submit" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block font-semibold">Nome da Confeitaria</label>
                    <input v-model="form.nome" type="text" class="w-full rounded border p-2"  required/>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Telefone</label>
                    <input v-model="form.telefone" type="text" class="w-full rounded border p-2" required/>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">CEP</label>
                    <div class="flex items-center gap-2">
                        <input v-model="form.cep" type="text" placeholder="CEP" class="w-full rounded border p-2" required/>
                        <button type="button" @click="buscar_cepManual" class="rounded bg-gray-300 px-3 py-2 hover:bg-gray-400">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Rua</label>
                    <input v-model="form.rua" type="text" class="w-full rounded border p-2" required/>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Complemento</label>
                    <input v-model="form.complemento" type="text" class="w-full rounded border p-2"/>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Bairro</label>
                    <input v-model="form.bairro" type="text" class="w-full rounded border p-2" required/>
                </div>

                <div>
                    <label class="mb-1 block font-semibold">Cidade</label>
                    <input v-model="form.cidade" type="text" class="w-full rounded border p-2" required/>
                </div>

                <div class="flex gap-4">
                    <div class="flex flex-col">
                        <label class="mb-1 block font-semibold">Número</label>
                        <input v-model="form.numero" type="text" placeholder="Número" class="w-32 rounded border p-2" required/>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-1 block font-semibold">UF</label>
                        <input v-model="form.estado" type="text" placeholder="UF" class="w-20 rounded border p-2 uppercase" maxlength="2" required/>
                    </div>
                </div>

                <input hidden v-model="form.latitude" type="text" required/>
                <input hidden v-model="form.longitude" type="text" required/>

                <div class="col-span-full mt-4 text-center">
                    <button type="submit" class="rounded-xl bg-pink-500 px-6 py-2 text-white transition hover:bg-pink-600">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</template>
