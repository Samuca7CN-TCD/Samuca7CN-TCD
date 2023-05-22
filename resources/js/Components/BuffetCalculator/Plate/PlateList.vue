<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { PlusIcon, DocumentDuplicateIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import Buffet from '@/Components/BuffetCalculator/Buffet/Buffet.vue';
import ModalCreatePlate from '@/Components/BuffetCalculator/Plate/Modals/ModalCreatePlate.vue';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    activated_page: Number,
    buffet: Object,
    plate_list: Object,
});

const form_plate = useForm({
    status: 2,
    name: '',
    description: null,
    price: 0.0,
    qtd_per_ten_people: 1,
    buffet_id: props.buffet.id,
    ingredients: null,
});

const create_modal_open = ref(false);

const formatDate = (date) => {
    date = date.split(/\-|\T|\:/);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

const setAttributes = (plate) => {
    form_plate.status = plate.status;
    form_plate.name = plate.name;
    form_plate.description = plate.description;
    form_plate.price = plate.price;
    form_plate.qtd_per_ten_people = plate.qtd_per_ten_people;
    form_plate.ingredients = plate.ingredients;
}

/*c

const togglePlateStatus = (plate) => {
    setAttributes(plate);
    form_plate.status = Number(!plate.status);
    form_plate.put(route('plates.update', plate.id), { preserveScroll: true });
}

const duplicatePlate = (plate) => {
    setAttributes(plate);
    form_plate.status = 2;
    form_plate.name = form_plate.name + ' - ' + String(new Date());
    form_plate.post(route('plates.store'), { preserveScroll: true });
}
*/

const deletePlate = (plate_id) => {
    router.delete(route('plates.destroy', plate_id), { preserveScroll: true, })
}

const goToPlate = (plate_id) => {
    router.get(route('ingredients.index', plate_id));
}
</script>
<template>
    <Buffet :buffet="buffet">
        <section class="my-1 select-none overflow-hidden">
            <div v-if="plate_list.length" class="p-5 overflow-auto">
                <p class="text-gray-700">Lista de ingredientes</p>
                <div class="w-full overflow-auto rounded-xl shadow-lg border border-gray-300">
                    <table class="w-full m-auto table-auto overflow-auto">
                        <thead class="lg:border-b-2 lg:border-gray-500">
                            <!--<th>Status</th>-->
                            <th>Nome</th>
                            <th>Qtd. / Buffet (10 pessoas)</th>
                            <th>Custo / Buffet (10 pessoas)</th>
                            <!--<th>Duplicar</th>-->
                        </thead>
                        <tbody>
                            <tr v-for="(plate, index) in plate_list" :key="plate.id"
                                class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                                :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + plate.name">
                                <!--<td @click="toggleplateStatus(plate)"><div v-if="plate.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="plate_table_status" id="plate-table-status" :checked="plate.status" /></div> <span v-else class="text-orange-600">Pendente</span></td>-->
                                <td class="py-3 px-5 truncate" @click="goToPlate(plate.id)">
                                    {{ plate.name }}
                                </td>
                                <td class="py-3 px-5 truncate" @click="goToPlate(plate.id)">{{
                                    plate.qtd_per_ten_people }} {{ plate.qtd_per_ten_people > 1 ? 'pratos' : 'prato' }}</td>
                                <td class="py-3 px-5 truncate" @click="goToPlate(plate.id)">{{ toMonetary(plate.cost) }}
                                </td>
                                <td class="py-3 px-5 truncate flex-row-config">
                                    <XMarkIcon class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300"
                                        title="Deletar plate Pendente" @click="deletePlate(plate.id)" />
                                    <!--<DocumentDuplicateIcon v-else
                                        class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300"
                                        title="Duplicar plate" @click="duplicateplate(plate)" />-->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else class="w-full text-center my-5">{{ buffet.name }} não possui pratos cadastrados!</div>
            <div class="w-full py-3 mb-10 text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle"
                @click="create_modal_open = true">
                <PlusIcon class="w-5 h-5" /> <span>Cadastrar novo prato</span>
            </div>
        </section>
        <ModalCreatePlate v-if="create_modal_open" :buffet_id="buffet.id"
            @modal_open="(open) => create_modal_open = open" />
    </Buffet>
</template>