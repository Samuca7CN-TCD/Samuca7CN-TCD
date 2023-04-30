<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { PlusIcon, DocumentDuplicateIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import Plate from '@/Components/BuffetCalculator/Plate/Plate.vue';
import ModalCreateIngredient from '@/Components/BuffetCalculator/Ingredient/Modals/ModalCreateIngredient.vue';
import { toMonetary } from '../shared_functions.js';

const props = defineProps({
    activated_page: Number,
    plate: Object,
    ingredient_list: Object,
});

/*
const form_ingredient = useForm({
    name: '',
    description: null,
    quantity: 0,
    cost: 0.0,
    buffet_plate_id: props.plate.id,
});

const setAttributes = (ingredient) => {
    form_ingredient.status = ingredient.status;
    form_ingredient.name = ingredient.name;
    form_ingredient.description = ingredient.description;
    form_ingredient.price = ingredient.price;
    form_ingredient.qtd_per_ten_people = ingredient.qtd_per_ten_people;
    form_ingredient.ingredients = ingredient.ingredients;
}

const toggleIngredientStatus = (ingredient) => {
    setAttributes(ingredient);
    form_ingredient.status = Number(!ingredient.status);
    form_ingredient.put(route('ingredients.update', ingredient.id), { preserveScroll: true });
}

const duplicateIngredient = (ingredient) => {
    setAttributes(ingredient);
    form_ingredient.status = 2;
    form_ingredient.name = form_ingredient.name + ' - ' + String(new Date());
    form_ingredient.post(route('ingredients.store'), { preserveScroll: true });
}
*/

const deleteIngredient = (ingredient_id) => {
    router.delete(route('ingredients.destroy', ingredient_id), { preserveScroll: true, })
}
</script>
<template>
    <Plate :plate="plate">
        <section class="my-1 select-none overflow-hidden">
            <div v-if="ingredient_list.length" class="p-5 overflow-auto">
                <p class="text-gray-700">Lista de ingredientes</p>
                <div class="w-full overflow-auto rounded-xl shadow-lg border border-gray-300">
                    <table class="w-full m-auto table-auto overflow-auto">
                        <thead class="lg:border-b-2 lg:border-gray-500">
                            <!--<th>Status</th>-->
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Und. medida</th>
                            <th>Custo p/ unidade</th>
                            <th>Custo total</th>
                            <th>Excluir</th>
                        </thead>
                        <tbody>
                            <tr v-for="(ingredient, index) in ingredient_list" :key="ingredient.id"
                                class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                                :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="ingredient.description">
                                <!--<td @click="toggleingredientStatus(ingredient)"><div v-if="ingredient.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="ingredient_table_status" id="ingredient-table-status" :checked="ingredient.status" /></div> <span v-else class="text-orange-600">Pendente</span></td>-->
                                <td class="py-3 px-5 truncate">
                                    {{ ingredient.name }}
                                </td>
                                <td class="py-3 px-5 truncate">
                                    {{ ingredient.quantity }}
                                </td>
                                <td class="py-3 px-5 truncate">
                                    {{ ingredient.measure_unity }}
                                </td>
                                <td class="py-3 px-5 truncate">
                                    {{ toMonetary(ingredient.cost) }}
                                </td>
                                <td class="py-3 px-5 truncate">
                                    {{ toMonetary(ingredient.quantity * ingredient.cost) }}
                                </td>
                                <td class="py-3 px-5 truncate flex-col-config cursor-pointer" title="Excluir Ingrediente"
                                    @click="deleteIngredient(ingredient.id)">
                                    <XMarkIcon class="w-6 h-6" />
                                </td>
                                <!--<td class="py-3 px-5 truncate flex-row-config"><XMarkIcon v-if="ingredient.status == 2" class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Deletar ingredient Pendente" @click="deleteingredient(ingredient)" /><DocumentDuplicateIcon v-else class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Duplicar ingredient" @click="duplicateingredient(ingredient)" /></td>-->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else class="w-full text-center my-5">{{ plate.name }} não possui pratos cadastrados!</div>
            <div class="w-full py-3 mb-10 text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle select-none"
                @click="create_modal_open = true">
                <PlusIcon class="w-5 h-5" />
                <span>Cadastrar novo Ingrediente</span>
            </div>
        </section>
        <ModalCreateIngredient v-if="create_modal_open" :plate="plate" @modal_open="(open) => create_modal_open = open" />
    </Plate>
</template>