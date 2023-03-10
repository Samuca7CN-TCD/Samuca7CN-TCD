<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

const props = defineProps({
    buffet_type: {
        type: String,
        default: 'main'
    },
    buffet: Object,
});

const emit = defineEmits(['modal_open']);
const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
let budget_event_date = new Date(Date.now() + 2592000000);
const min_date = ref(new Date());
min_date.value = min_date.value.getFullYear() + '-' + dateZeroFiller(min_date.value.getMonth() + 1) + '-' + dateZeroFiller(min_date.value.getDate()) + 'T' + dateZeroFiller(min_date.value.getHours()) + ':' + dateZeroFiller(min_date.value.getMinutes());
budget_event_date = budget_event_date.getFullYear() + '-' + dateZeroFiller(budget_event_date.getMonth() + 1) + '-' + dateZeroFiller(budget_event_date.getDate()) + 'T' + dateZeroFiller(budget_event_date.getHours()) + ':' + dateZeroFiller(budget_event_date.getMinutes());


const form = useForm({
    name: props.buffet ? props.buffet.name : null,
    description: props.buffet ? props.buffet.description : null,
    price: props.buffet ? props.buffet.price : 0.0,
    plates: props.buffet ? JSON.parse(props.buffet.plates) : [],
});

const plate = ref({
    name: null,
    description: null,
    price: 0.0,
    qtd_per_ten_people: null,
    ingredients: []
});

const ingredient = ref({
    name: null,
    description: null,
    quantity: null,
    price: 0.0,
});

const closeModal = () => {
    form.reset();
    form.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    form.post(route('budgets.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
}
</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-blue-100 p-2 rounded-full text-blue-400">
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
                            class="w-full border-slate-300 sm:text-md" v-model="form.name" />
                        <div v-if="form.errors.name" class="text-xs text-red-600 ml-3">{{ form.errors.name }}</div>
                    </div>

                    <!-- Descrição -->
                    <div class="w-full">
                        <label for="buffet_description" class="text-xs text-slate-700">Descrição</label>
                        <input type="text" id="buffet_description" placeholder="Descrição"
                            class="w-full border-slate-300 sm:text-md" v-model="form.description" />
                        <div v-if="form.errors.description" class="text-xs text-red-600 ml-3">{{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Preço -->
                    <div class="w-full">
                        <label for="buffet_price" class="text-xs text-slate-700">Preço</label>
                        <input type="text" id="buffet_price" placeholder="Preço" class="w-full border-slate-300 sm:text-md"
                            v-model="form.price" readonly />
                        <div v-if="form.errors.price" class="text-xs text-red-600 ml-3">{{ form.errors.price }}</div>
                    </div>

                    <div class="py-2 flex flex-col lg:flex-row lg:space-x-14">
                        <div class="flex items-center">
                            <input :checked="buffet_type == 'entry'" id="buffet_type_entry" type="radio" value="1"
                                name="buffet_type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="buffet_type_entry"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Entrada</label>
                        </div>
                        <div class="flex items-center">
                            <input :checked="buffet_type == 'main'" id="buffet_type_main" type="radio" value="2"
                                name="buffet_type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="buffet_type_main"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Buffet</label>
                        </div>
                    </div>

                    <div>Aqui acontece a mágica</div>

                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 flex-col-config space-y-8 sm:flex-row-config sm:space-y-0">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>

        </form>
    </Modal>
</template>