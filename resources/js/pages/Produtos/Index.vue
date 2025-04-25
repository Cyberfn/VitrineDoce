<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import ProdutoModal from '@/components/ProdutoModal.vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = usePage().props;
const produtos = computed(() => props.produtos ?? []);
const produto_selecionado = ref(null);
const mostrar_modal = ref(false);

function abrir_modal(produto: any) {
    produto_selecionado.value = { ...produto };
    mostrar_modal.value = true;
}

function salvar_produto({ id, form }: any) {
    router.post(`/produtos/${id}`, form, {
        preserveScroll: true,
        onSuccess: () => {
            fechar_modal();
        },
        onError: (errors) => {
            console.error('Erros ao salvar produto:', errors);
        },
    });
    location.reload();
}

function excluir_produto(produtoId: number) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        router.delete(`/produtos/${produtoId}`, {
            preserveScroll: true,
            onSuccess: () => {
                fechar_modal();
            },
            onError: (errors) => {
                console.error('Erro ao excluir produto:', errors);
            },
        });
    }
    location.reload();
}

function fechar_modal() {
    mostrar_modal.value = false;
}
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
                                style="
                                    background-color: transparent;
                                    border: none;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: black;
                                    font-size: 30px;
                                "
                            >
                                &lt;
                            </button>

                            <button
                                v-if="(produto.produto_imagens || []).length > 1"
                                class="carousel-control-next"
                                type="button"
                                :data-bs-target="'#carousel_' + produto.id"
                                data-bs-slide="next"
                                style="
                                    background-color: transparent;
                                    border: none;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: black;
                                    font-size: 30px;
                                "
                            >
                                &gt;
                            </button>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ produto.nome }}</h5>
                            <p class="card-text">{{ produto.descricao }}</p>
                            <p class="card-text fw-bold mt-auto">
                                Preço: R$ {{ produto.valor ? parseFloat(produto.valor).toFixed(2) : 'Indisponível' }}
                            </p>
                            <button @click="abrir_modal(produto)" class="btn btn-primary mt-2 w-100">Ver mais</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ProdutoModal
            v-if="mostrar_modal"
            :produto="produto_selecionado"
            :mostrar="mostrar_modal"
            :confeitarias="confeitarias"
            @fechar="fechar_modal"
            @salvar="salvar_produto"
            @excluir="excluir_produto"
        />
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
