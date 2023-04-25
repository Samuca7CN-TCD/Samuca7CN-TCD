<script setup>
import { ref } from 'vue';
import ModalManageAdditions from './Modals/ModalManageAdditions.vue';
import { PencilIcon, XMarkIcon, PlusIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    ceremony: Object,
    additions: Object,
});

const open_modal = ref(false);
const selected_option = ref({
    name: '',
    amount: 0,
});
const op_type = ref(0);

const openModal = (selected_option_id) => {
    if (selected_option_id) {
        selected_option.value.name = selected_option_id;
        selected_option.value.amount = props.additions[selected_option_id];
        op_type.value = 1;
    } else {
        selected_option.value.name = '';
        selected_option.value.amount = 0;
        op_type.value = 0;
    }
    open_modal.value = true;
}

const deleteItem = (selected_option_id) => {
    op_type.value = 2;
    router.put(route('ceremonies.update.addition', props.ceremony.id), { name: selected_option_id, amount: props.additions[selected_option_id], op_type: op_type.value }, {
        preserveScroll: true,
    });
}

const toMonetary = (value) => {
    if (value !== null) return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}
</script>
<template>
    <!--Adições-->
    <div class="flex-col-config my-5 bg-stone-100 py-5 font-mono text-green-700">
        <p class="text-4xl">Adições</p>
        <p class="text-xl">{{ toMonetary(ceremony.total_additions) }}</p>
    </div>
    <div v-if="Object.values(additions).length" class="mt-10 overflow-auto">
        <!-- Orçamentos do cliente -->
        <table class="w-full m-auto table-auto truncate">
            <thead class="lg:border-b-2 lg:border-gray-500">
                <th>Nome</th>
                <th>Valor</th>
                <th>Editar</th>
                <th>Excluir</th>
            </thead>
            <tbody>
                <tr v-for="(add, index, i = 0) in additions" :key="index"
                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                    :class="{ 'bg-gray-100': (i++) % 2 == 0 }">
                    <td class="py-3 px-5 truncate" :title="index">{{ index }}</td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(add) }} </td>
                    <td class="py-3 px-5 cursor-pointer" :title="'Editar ' + index" @click="openModal(index)">
                        <PencilIcon class=" w-full h-6 text-stone-500" />
                    </td>
                    <td class="py-3 px-5 cursor-pointer" :title="'Excluir ' + index" @click="deleteItem(index)">
                        <XMarkIcon class=" w-full h-6 text-stone-500" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="w-full text-center">
        <p>Não há adições cadastradas no momento!</p>
    </div>
    <p class="text-blue-400 hover:text-blue-600 active:text-blue-800 cursor-pointer flex-row-config space-x-1 py-5"
        @click="openModal(null)">
        <PlusIcon class="w-4 h-4" />
        <span>Cadastrar adição</span>
    </p>
    <ModalManageAdditions v-if="open_modal" :ceremony_id="ceremony.id" :addition="selected_option" :op_type="op_type"
        @modal_open="(open) => open_modal = open" />
</template>