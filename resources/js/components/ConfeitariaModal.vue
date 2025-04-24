<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
    confeitaria: any;
    mostrar: boolean;
    produtos: Array<any>;
}>();

const emit = defineEmits(['fechar', 'salvar', 'excluir']);
const confeitaria_edicao = ref({ ...props.confeitaria });
const modo_edicao = ref(false);

watch(
    () => props.confeitaria,
    (nova) => {
        confeitaria_edicao.value = { ...nova };
    },
    { immediate: true },
);

watch(
    () => confeitaria_edicao.value.cep,
    (novo_cep) => {
        if (novo_cep && novo_cep.length === 8) {
            buscar_cep(novo_cep);
        }
    },
);

function habilitar_edicao() {
    modo_edicao.value = true;
}

function salvar_alteracoes() {
    const form = new FormData();
    form.append('nome', confeitaria_edicao.value.nome);
    form.append('descricao', confeitaria_edicao.value.descricao ?? '');
    form.append('endereco', confeitaria_edicao.value.endereco ?? '');
    form.append('telefone', confeitaria_edicao.value.telefone ?? '');
    form.append('cep', confeitaria_edicao.value.cep ?? '');
    form.append('rua', confeitaria_edicao.value.rua ?? '');
    form.append('numero', confeitaria_edicao.value.numero ?? '');
    form.append('complemento', confeitaria_edicao.value.complemento ?? '');
    form.append('bairro', confeitaria_edicao.value.bairro ?? '');
    form.append('cidade', confeitaria_edicao.value.cidade ?? '');
    form.append('estado', confeitaria_edicao.value.estado ?? '');
    form.append('latitude', confeitaria_edicao.value.latitude);
    form.append('longitude', confeitaria_edicao.value.longitude);
    form.append('_method', 'PUT');

    emit('salvar', { id: confeitaria_edicao.value.id, form });
    modo_edicao.value = false;
    emit('fechar');

    window.location.reload();
}

function excluir_confeitaria() {
    emit('excluir', confeitaria_edicao.value.id);
    modo_edicao.value = false;
    emit('fechar');
}

function buscar_cep(cep: string) {
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then((res) => res.json())
        .then((data) => {
            if (!data.erro) {
                confeitaria_edicao.value.rua = data.logradouro;
                confeitaria_edicao.value.bairro = data.bairro;
                confeitaria_edicao.value.cidade = data.localidade;
                confeitaria_edicao.value.estado = data.uf;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${data.logradouro},${data.localidade},${data.uf}`)
                    .then((res) => res.json())
                    .then((coords) => {
                        if (coords.length > 0) {
                            confeitaria_edicao.value.latitude = coords[0].lat;
                            confeitaria_edicao.value.longitude = coords[0].lon;
                        }
                    });
            }
        });
}
</script>

<template>
    <div class="modal fade" :class="{ show: mostrar }" style="display: block" tabindex="-1" role="dialog" v-if="mostrar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da Confeitaria</h5>
                    <button type="button" class="btn-close" @click="$emit('fechar')"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label class="form-label">Nome</label>
                            <input class="form-control" v-model="confeitaria_edicao.nome" :disabled="!modo_edicao" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Telefone</label>
                            <input
                                class="form-control"
                                v-model="confeitaria_edicao.telefone"
                                :disabled="!modo_edicao"
                                v-mask="confeitaria_edicao.telefone.replace(/\D/g, '').length > 10 ? '(##) #####-####' : '(##) ####-####'"
                                required
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CEP</label>
                            <input
                                class="form-control"
                                v-model="confeitaria_edicao.telefone"
                                :disabled="!modo_edicao"
                                maxlength="10"
                                @input="confeitaria_edicao.telefone = confeitaria_edicao.telefone.replace(/\D/g, '').slice(0, 10)"
                                required
                            />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Rua</label>
                            <input class="form-control" v-model="confeitaria_edicao.rua" :disabled="!modo_edicao" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número</label>
                            <input class="form-control" v-model="confeitaria_edicao.numero" :disabled="!modo_edicao" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Complemento</label>
                            <input class="form-control" v-model="confeitaria_edicao.complemento" :disabled="!modo_edicao" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bairro</label>
                            <input class="form-control" v-model="confeitaria_edicao.bairro" :disabled="!modo_edicao" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Cidade</label>
                            <input class="form-control" v-model="confeitaria_edicao.cidade" :disabled="!modo_edicao" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <input class="form-control" v-model="confeitaria_edicao.estado" :disabled="!modo_edicao" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button v-if="!modo_edicao" class="btn btn-warning" @click="habilitar_edicao">Editar</button>
                    <button v-if="modo_edicao" class="btn btn-success" @click="salvar_alteracoes">Salvar</button>
                    <button v-if="modo_edicao" class="btn btn-danger" @click.prevent="excluir_confeitaria">Excluir</button>
                    <button class="btn btn-secondary" @click="$emit('fechar')">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</template>
