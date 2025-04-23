<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = usePage().props;
const produtos = computed(() => props.produtos ?? []);
console.log(produtos.value);
</script>

<template>
    <div class="min-vh-100 bg-light">
        <Navbar />
        <div class="container mt-5">
            <h2 class="mb-5"><i class="bi bi-shop-window"></i> Produtos</h2>
            <div class="row">
                <div v-for="produto in produtos" :key="produto.id" class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <div :id="'carousel_' + produto.id" class="carousel slide produto-carousel" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div
                                    v-if="(produto.produto_imagens || []).length > 0"
                                    v-for="(imagem, index) in produto.produto_imagens"
                                    :key="index"
                                    class="carousel-item"
                                    :class="{ active: index === 0 }"
                                >
                                    <div class="imagem-wrapper">
                                        <img :src="imagem.imagem" class="imagem-ajustada" alt="Imagem do produto" />
                                    </div>
                                </div>
                                <div v-else class="carousel-item active">
                                    <div class="imagem-wrapper">
                                        <i class="bi bi-image-alt" style="font-size: 50px; color: #ddd"></i>
                                        <p class="text-center" style="color: #aaa">Sem imagem disponível</p>
                                    </div>
                                </div>
                            </div>

                            <button
                                v-if="(produto.produto_imagens || []).length > 1"
                                class="carousel-control-prev"
                                type="button"
                                :data-bs-target="'#carousel_' + produto.id"
                                data-bs-slide="prev"
                            >
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button
                                v-if="(produto.produto_imagens || []).length > 1"
                                class="carousel-control-next"
                                type="button"
                                :data-bs-target="'#carousel_' + produto.id"
                                data-bs-slide="next"
                            >
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ produto.nome }}</h5>
                            <p class="card-text">{{ produto.descricao }}</p>
                            <p class="card-text fw-bold mt-auto">
                                Preço: R$ {{ produto.valor ? parseFloat(produto.valor).toFixed(2) : 'Indisponível' }}
                            </p>
                            <a :href="'/produto/' + produto.id" class="btn btn-primary mt-2 w-100">Ver mais</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.imagem-wrapper {
    height: 250px;
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.imagem-ajustada {
    width: 80%;
    height: 80%;
    object-fit: cover;
}
</style>
