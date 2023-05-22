<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    buffet_id: Number,
})

const emit = defineEmits(['modal_open']);

const form_plate = useForm({
    status: 1,
    name: null,
    description: null,
    qtd_per_ten_people: 1,
    measure_unity: 'unidades',
    buffet_id: props.buffet_id,
});

const closeModal = () => {
    form_plate.reset();
    form_plate.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    form_plate.post(route('plates.store'), {
        preserveScroll: true,
        onFinish: () => { console.log(form_plate.errors) },
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
                <h2 class="text-2xl bold">Cadastrar plate</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro de um novo plate</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">
            <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-2">
                    <div v-if="form_plate.errors.buffet_id" class="text-xs text-red-600 ml-3">{{
                        form_plate.errors.buffet_id }} </div>

                    <!-- Nome do plate -->
                    <div class="w-full">
                        <label for="plate_name" class="text-xs text-slate-700">Nome do plate</label>
                        <input type="text" id="plate_name" placeholder="Nome do prato"
                            class="w-full border-slate-300 sm:text-md" v-model="form_plate.name" required="required"
                            autofocus />
                        <div v-if="form_plate.errors.name" class="text-xs text-red-600 ml-3">{{ form_plate.errors.name
                        }}
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="w-full">
                        <label for="plate_description" class="text-xs text-slate-700">Descrição</label>
                        <textarea id="plate_description" placeholder="Descrição" class="w-full border-slate-300 sm:text-md"
                            v-model="form_plate.description" rows="2"></textarea>
                        <div v-if="form_plate.errors.description" class="text-xs text-red-600 ml-3">{{
                            form_plate.errors.description }}
                        </div>
                    </div>

                    <!-- Quantidade para 10 pessoas -->
                    <div class="w-full">
                        <label for="plate_qtd_per_ten_people" class="text-xs text-slate-700">Quantidade para 10
                            pessoas</label>
                        <input type="number" step="1" min="1" id="plate_qtd_per_ten_people" placeholder="Descrição"
                            class="w-full border-slate-300 sm:text-md" required v-model="form_plate.qtd_per_ten_people" />
                        <div v-if="form_plate.errors.qtd_per_ten_people" class="text-xs text-red-600 ml-3">{{
                            form_plate.errors.qtd_per_ten_people }}
                        </div>
                    </div>

                    <!-- Unidade de medida-->
                    <div class="w-full">
                        <label for="plate_measure_unity" class="text-xs text-slate-700">Unidade de medida</label>
                        <input type="text" id="plate_measure_unity" placeholder="Descrição"
                            class="w-full border-slate-300 sm:text-md" required v-model="form_plate.measure_unity" />
                        <div v-if="form_plate.errors.measure_unity" class="text-xs text-red-600 ml-3">{{
                            form_plate.errors.measure_unity }}
                        </div>
                    </div>

                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 flex-col-config space-y-8 sm:flex-row-config sm:space-y-0">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form_plate.processing }"
                        :disabled="form_plate.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form_plate.processing }"
                        :disabled="form_plate.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>

        </form>
    </Modal>
</template>