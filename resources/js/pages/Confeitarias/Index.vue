<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = usePage().props;
const confeitarias = computed(() => props.confeitarias ?? []);
</script>
<template>
    <div class="min-vh-100 bg-light">
        <Navbar />
        <div class="container mt-5">
            <h2 class="mb-5"><i class="bi bi-shop-window"></i> Confeitarias</h2>
            <div class="row">
                <div v-for="confeitaria in confeitarias" :key="confeitaria.id" class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ confeitaria.nome }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>