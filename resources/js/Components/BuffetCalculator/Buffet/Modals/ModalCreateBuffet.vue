<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    buffet_type: Number,
});

const emit = defineEmits(['modal_open']);

const form_buffet = useForm({
    status: 2,
    name: '',
    description: null,
    price: 0.0,
    plates: null,
    type: props.buffet_type,
});

const closeModal = () => {
    form_buffet.reset();
    form_buffet.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    form_buffet.post(route('buffets.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
}

</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-gray-100 p-2 rounded-full text-gray-400">
                    <PlusIcon class="w-5 h-5" />
                </span>
                <h2 class="text-2xl bold">Cadastrar Buffet</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro de um novo Buffet</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">
            <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-2">

                    <!-- Nome do Buffet -->
                    <div class="w-full">
                        <label for="buffet_name" class="text-xs text-slate-700">Nome do Buffet</label>
                        <input type="text" id="buffet_name" placeholder="Nome do Buffet"
                            class="w-full border-slate-300 sm:text-md" v-model="form_buffet.name" />
                        <div v-if="form_buffet.errors.name" class="text-xs text-red-600 ml-3">{{ form_buffet.errors.name }}
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="w-full">
                        <label for="buffet_description" class="text-xs text-slate-700">Descrição</label>
                        <textarea id="buffet_description" placeholder="Descrição" class="w-full border-slate-300 sm:text-md"
                            v-model="form_buffet.description" rows="2"></textarea>
                        <div v-if="form_buffet.errors.description" class="text-xs text-red-600 ml-3">{{
                            form_buffet.errors.description }}
                        </div>
                    </div>

                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 flex-col-config space-y-8 sm:flex-row-config sm:space-y-0">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form_buffet.processing }"
                        :disabled="form_buffet.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form_buffet.processing }"
                        :disabled="form_buffet.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>

        </form>
    </Modal>
</template>