<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    plate: Object,
});

const emit = defineEmits(['modal_open']);

const form_ingredient = useForm({
    name: '',
    description: null,
    quantity: 1,
    measure_unity: 'unidades',
    cost: 0.00,
    buffet_plate_id: props.plate.id,
});

const closeModal = () => {
    form_ingredient.reset();
    form_ingredient.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    form_ingredient.post(route('ingredients.store'), {
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
                <h2 class="text-2xl bold">Cadastrar Ingrediente</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro de um novo Ingrediente</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">
            <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-2">

                    <!-- Nome do Ingrediente -->
                    <div class="w-full">
                        <label for="ingredient_name" class="text-xs text-slate-700">Nome do Ingrediente</label>
                        <input type="text" id="Ingredient_name" placeholder="Nome do Ingrediente"
                            class="w-full border-slate-300 sm:text-md" v-model="form_ingredient.name" />
                        <div v-if="form_ingredient.errors.name" class="text-xs text-red-600 ml-3">{{
                            form_ingredient.errors.name }}
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="w-full">
                        <label for="ingredient_description" class="text-xs text-slate-700">Descrição (opcional)</label>
                        <textarea id="ingredient_description" placeholder="Descrição"
                            class="w-full border-slate-300 sm:text-md" v-model="form_ingredient.description"
                            rows="2"></textarea>
                        <div v-if="form_ingredient.errors.description" class="text-xs text-red-600 ml-3">{{
                            form_ingredient.errors.description }}
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <div class="w-full">
                        <label for="ingredient_quantity" class="text-xs text-slate-700">Quantidade por {{
                            plate.measure_unity }} de {{ plate.name }}</label>
                        <input type="number" step="1" min="1" id="ingredient_quantity" placeholder="Quantidade"
                            class="w-full border-slate-300 sm:text-md" v-model="form_ingredient.quantity" />
                        <div v-if="form_ingredient.errors.quantity" class="text-xs text-red-600 ml-3">{{
                            form_ingredient.errors.quantity }}
                        </div>
                    </div>

                    <!--Unidade de Medida-->
                    <div class="w-full">
                        <label for="measure_unit" class="text-xs text-slate-700">Unidade de Medida do ingrediente</label>
                        <input type="text" id="measure_unit" placeholder="Unidade de Medida"
                            class="w-full border-slate-300 sm:text-md" v-model="form_ingredient.measure_unity" />
                        <div v-if="form_ingredient.errors.measure_unity" class="text-xs text-red-600 ml-3">{{
                            form_ingredient.errors.measure_unity }}
                        </div>
                    </div>

                    <!--Custo por unidade-->
                    <div class="full">
                        <label for="ingredient_cost" class="block text-sm font-medium leading-6 text-gray-900">Custo por
                            unidade</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"> <span
                                    class="text-gray-500 sm:text-sm">R$</span></div>
                            <input type="number" step="0.01" min="0.00" name="ingredient_cost" id="ingredient_cost"
                                class="block w-full rounded-md border-0 py-1.5 pl-10 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-grey-600 sm:text-sm sm:leading-6"
                                placeholder="Custo por unidade" v-model="form_ingredient.cost">
                            <div v-if="form_ingredient.errors.cost" class="text-xs text-red-600 ml-3">{{
                                form_ingredient.errors.cost }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 flex-col-config space-y-8 sm:flex-row-config sm:space-y-0">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form_ingredient.processing }"
                        :disabled="form_ingredient.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form_ingredient.processing }"
                        :disabled="form_ingredient.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>

        </form>
    </Modal>
</template>