<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { PlusIcon, DocumentDuplicateIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import ModalCreateBuffet from '@/Components/BuffetCalculator/Buffet/Modals/ModalCreateBuffet.vue';

const props = defineProps({
    activated_page: Number,
    buffet_list: Object,
});

/*
const form_buffet = useForm({
    status: 2,
    name: '',
    description: null,
    price: 0.0,
    plates: null,
    type: 1,
});
*/

// const buffet_type = props.activated_page + 1;
// const create_modal_open = ref(false);

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

const formatDate = (date) => {
    date = date.split(/\-|\T|\:/);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

/* 
const setAttributes = (buffet) => {
    form_buffet.status = buffet.status;
    form_buffet.name = buffet.name;
    form_buffet.description = buffet.description;
    form_buffet.plates = buffet.plates;
    form_buffet.price = buffet.price;
    form_buffet.type = buffet.type;
}

const toggleBuffetStatus = (buffet) => {
    setAttributes(buffet);
    form_buffet.status = Number(!buffet.status);
    form_buffet.put(route('buffets.update', buffet.id), { preserveScroll: true });
}

const duplicateBuffet = (buffet) => {
    setAttributes(buffet);
    form_buffet.status = 2;
    form_buffet.name = form_buffet.name + ' - ' + (props.buffet_list.length + 1) + ' Novo';
    form_buffet.post(route('buffets.store'), { preserveScroll: true });
}

const deleteBuffet = (buffet_id) => {
    router.delete(route('buffets.destroy', buffet_id), { preserveScroll: true, })
}

*/

const goToBuffet = (buffet_id) => {
    router.get(route('plates.index', buffet_id));
}

</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div v-if="buffet_list.length" class="py-2 overflow-auto">
            <div class="w-full overflow-auto">
                <table class="w-full m-auto table-fixed overflow-auto">
                    <thead class="lg:border-b-2 lg:border-gray-500">
                        <!--<th>Status</th>-->
                        <th>Nome</th>
                        <th>Preço (10 pessoas)</th>
                        <th>Custo (10 pessoas)</th>
                        <th>Descrição</th>
                        <!--<th>Duplicar</th>-->
                    </thead>
                    <tbody>
                        <tr v-for="(buffet, index) in buffet_list" :key="buffet.id"
                            class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                            :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + buffet.name">
                            <!--<td @click="toggleBuffetStatus(buffet)"><div v-if="buffet.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="buffet_table_status" id="buffet-table-status" :checked="buffet.status" /></div><span v-else class="text-orange-600">Pendente</span></td>-->
                            <td class="py-3 px-5 truncate" @click="goToBuffet(buffet.id)">
                                {{ buffet.name }}
                            </td>
                            <td class="py-3 px-5 truncate" @click="goToBuffet(buffet.id)">
                                {{ toMonetary(buffet.price) }}
                            </td>
                            <td class="py-3 px-5 truncate" @click="goToBuffet(buffet.id)">
                                {{ toMonetary(buffet.cost) }}
                            </td>
                            <td class="py-3 px-5 truncate" :title="buffet.description" @click="goToBuffet(buffet.id)">{{
                                buffet.description }}</td>
                            <!--<td class="py-3 px-5 truncate flex-row-config"><XMarkIcon v-if="buffet.status == 2" class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Deletar Buffet Pendente" @click="deleteBuffet(buffet)" /> <DocumentDuplicateIcon v-else class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Duplicar Buffet" @click="duplicateBuffet(buffet)" /></td>-->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else class="w-full text-center my-5">{{ buffet.name }} não possui(em) buffets cadastrados!</div>
    </section>
    <!--<button type="buttom" class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5" @click="create_modal_open = true"><PlusIcon class="w-5 h-5" /></button>-->
    <!--<ModalCreateBuffet v-if="create_modal_open" :buffet_type="buffet_type" @modal_open="(open) => create_modal_open = open" />-->
</template>