<script setup lang="ts">
import { computed, ref, watch } from 'vue';

const props = defineProps<{
    produto: any;
    mostrar: boolean;
    confeitarias: any[];
}>();

const emit = defineEmits(['fechar', 'salvar', 'excluir']);
const produto_edicao = ref({ ...props.produto });
const modo_edicao = ref(false);
const novas_imagens = ref<File[]>([]);
const imagens_removidas = ref<number[]>([]);

watch(
    () => props.produto,
    (novoProduto) => {
        console.log('Novo produto recebido:', novoProduto); // 👀
        produto_edicao.value = { ...novoProduto };
    },
    { immediate: true },
);

const nome_confeitaria = computed(() => {
    const confeitaria = props.confeitarias.find((c) => c.id === produto_edicao.value.confeitaria_id);
    return confeitaria ? confeitaria.nome : 'Confeitaria não encontrada';
});

console.log('Confeitarias recebidas:', props.confeitarias);

function habilitar_edicao() {
    modo_edicao.value = true;
}

function adicionar_imagem(event: Event) {
    const input = event.target as HTMLInputElement;
    const files = input.files;
    if (files && files.length > 0) {
        novas_imagens.value.push(files[0]);

        if (!produto_edicao.value.produto_imagens) {
            produto_edicao.value.produto_imagens = [];
        }
        produto_edicao.value.produto_imagens.push({ imagem: URL.createObjectURL(files[0]) });
    }
}

function remover_imagem(index: number, imagem: any) {
    if (imagem.id) {
        imagens_removidas.value.push(imagem.id);
    }
    produto_edicao.value.produto_imagens.splice(index, 1);
}

function salvar_alteracoes() {
    const form = new FormData();
    form.append('nome', produto_edicao.value.nome);
    form.append('descricao', produto_edicao.value.descricao ?? '');
    form.append('valor', produto_edicao.value.valor);
    form.append('confeitaria_id', produto_edicao.value.confeitaria_id);
    form.append('_method', 'PUT');

    novas_imagens.value.forEach((file) => {
        form.append(`novas_imagens[]`, file);
    });

    imagens_removidas.value.forEach((id) => {
        form.append('imagens_removidas[]', id.toString());
    });

    emit('salvar', { id: produto_edicao.value.id, form });
    modo_edicao.value = false;
    emit('fechar');
}

function excluir_produto() {
    emit('excluir', produto_edicao.value.id);
    modo_edicao.value = false;
    emit('fechar');
}
</script>

<template>
    <div class="modal fade" :class="{ show: mostrar }" style="display: block" tabindex="-1" role="dialog" v-if="mostrar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes do Produto</h5>
                    <button type="button" class="btn-close" @click="$emit('fechar')"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label d-block">Imagens do Produto</label>
                        <div class="d-flex position-relative flex-wrap gap-3">
                            <div
                                v-for="(img, index) in produto_edicao.produto_imagens"
                                :key="index"
                                class="position-relative rounded border p-1"
                                style="width: 100px; height: 100px; overflow: hidden"
                            >
                                <img :src="img.imagem" class="h-100 w-100" style="object-fit: cover" />
                                <button
                                    v-if="modo_edicao"
                                    class="btn-close position-absolute end-0 top-0 m-1"
                                    @click="remover_imagem(index, img)"
                                ></button>
                            </div>
                            <div v-if="modo_edicao" class="d-flex align-items-center">
                                <label class="btn btn-sm btn-outline-secondary">
                                    + Adicionar imagem
                                    <input type="file" hidden @change="adicionar_imagem" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input class="form-control" v-model="produto_edicao.nome" :disabled="!modo_edicao" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" v-model="produto_edicao.descricao" :disabled="!modo_edicao"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Valor</label>
                        <input type="number" class="form-control" v-model="produto_edicao.valor" :disabled="!modo_edicao" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button v-if="!modo_edicao" class="btn btn-warning" @click="habilitar_edicao">Editar</button>
                    <button v-if="modo_edicao" class="btn btn-success" @click="salvar_alteracoes">Salvar</button>
                    <button v-if="modo_edicao" class="btn btn-danger" @click.prevent="excluir_produto">Excluir</button>
                    <button class="btn btn-secondary" @click="$emit('fechar')">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</template>
