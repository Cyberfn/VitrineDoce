<script setup lang="ts">
import ConfeitariaModal from '@/components/ConfeitariaModal.vue';
import Navbar from '@/components/Navbar.vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = usePage().props;
const confeitarias = computed(() => props.confeitarias ?? []);
const produtos = computed(() => props.produtos ?? []); 
const confeitaria_selecionada = ref(null);
const mostrar_modal = ref(false);

function abrir_modal(confeitaria: any) {
    confeitaria_selecionada.value = { ...confeitaria };
    mostrar_modal.value = true;
}

function salvar_confeitaria({ id, form }: any) {
    router.post(`/confeitarias/${id}`, form, {
        preserveScroll: true,
        onSuccess: () => {
            fechar_modal();
            
            const index = confeitarias.value.findIndex(c => c.id === id);
            if (index !== -1) {
                confeitarias.value[index] = { ...form }; 
            }
        },
        onError: (errors) => console.error(errors),
    });
}

function excluir_confeitaria(confeitariaId: number) {
    if (confirm('Tem certeza que deseja excluir esta confeitaria?')) {
        router.delete(`/confeitarias/${confeitariaId}`, {
            preserveScroll: true,
            onSuccess: () => {
                fechar_modal();
                
                const index = confeitarias.value.findIndex(c => c.id === confeitariaId);
                if (index !== -1) {
                    confeitarias.value.splice(index, 1); 
                }
            },
            onError: (errors) => console.error(errors),
        });
    }
}

function fechar_modal() {
    mostrar_modal.value = false;
}
</script>

<template>
    <div class="min-vh-100 bg-light">
        <Navbar />
        <div class="container mt-5">
            <h2 class="mb-5"><i class="bi bi-cake"></i> Confeitarias</h2>
            <div class="row">
                <div v-for="conf in confeitarias" :key="conf.id" class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ conf.nome }}</h5>
                            <button class="btn btn-primary mt-auto" @click="abrir_modal(conf)">Ver mais</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ConfeitariaModal
            v-if="mostrar_modal"
            :confeitaria="confeitaria_selecionada"
            :mostrar="mostrar_modal"
            :produtos="produtos"
            @fechar="fechar_modal"
            @salvar="salvar_confeitaria"
            @excluir="excluir_confeitaria"
        />
    </div>
</template>
