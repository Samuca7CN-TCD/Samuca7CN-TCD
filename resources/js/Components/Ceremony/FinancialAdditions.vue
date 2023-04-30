<script setup>
import { ref } from 'vue';
import ModalManageAdditions from './Modals/ModalManageAdditions.vue';
import { PencilIcon, XMarkIcon, PlusIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';
import { toMonetary, formatDate } from '../shared_functions.js';
import loadInstallments from './Modals/loadInstallments';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    first_installment: Object,
    additions: Object,
});

const open_modal = ref(false);
const selected_option = ref({
    name: '',
    amount: 0,
});
const op_type = ref(0);
const options = [1, 1, 2, 3, 4];

const installment_info = ref({
    config: props.first_installment ? {
        name: props.first_installment.name || null,
        payment_day: parseInt(formatDate(props.first_installment.deadline).split('/')[0]) || null,
        type: props.first_installment.type || null,
        payment_option: options[props.first_installment.type] || null,
    } : null,
    total_value: (props.ceremony.total_negotiated_amount + props.ceremony.total_additions),
    event_date: props.budget.event_date,
});

const openModal = (selected_option_id) => {
    installment_info.value.config = props.first_installment ? {
        name: props.first_installment.name || null,
        payment_day: parseInt(formatDate(props.first_installment.deadline).split('/')[0]) || null,
        type: props.first_installment.type || null,
        payment_option: options[props.first_installment.type] || null,
    } : null;
    installment_info.value.total_value = (props.ceremony.total_negotiated_amount + props.ceremony.total_additions);
    installment_info.value.event_date = props.budget.event_date;

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
        onSuccess: () => setTimeout(updateInstallments(), 500)
    });
}

const updateInstallments = () => {
    if (installment_info.value.config == null) return;

    installment_info.value.config = {
        name: props.first_installment.name || null,
        payment_day: parseInt(formatDate(props.first_installment.deadline).split('/')[0]) || null,
        type: props.first_installment.type || null,
        payment_option: options[props.first_installment.type] || null,
    };
    installment_info.value.total_value = (props.ceremony.total_negotiated_amount + props.ceremony.total_additions);
    installment_info.value.event_date = props.budget.event_date;

    const installments = loadInstallments(installment_info.value.config, installment_info.value.total_value, installment_info.value.event_date);
    router.put(route('ceremonies.update', props.ceremony.id), { installment_list: installments }, {
        preserveScroll: true,
    });
}
</script>
<template>
    <!--Adições-->
    <div class="flex-col-config mb-5 bg-stone-100 py-5 font-mono text-green-700">
        <p class="text-4xl">Adições</p>
        <p class="text-xl">{{ toMonetary(ceremony.total_additions) }}</p>
    </div>
    <div v-if="Object.values(additions).length" class="mt-10 overflow-auto">
        <!-- Orçamentos do cliente -->
        <table class="w-full m-auto table-auto truncate">
            <thead class="lg:border-b-2 lg:border-gray-500">
                <th>Nome</th>
                <th>Valor</th>
                <th v-if="budget.status == 2">Editar</th>
                <th v-if="budget.status == 2">Excluir</th>
            </thead>
            <tbody>
                <tr v-for="(add, index, i = 0) in additions" :key="index"
                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                    :class="{ 'bg-gray-100': (i++) % 2 == 0 }">
                    <td class="py-3 px-5 truncate" :title="index">{{ index }}</td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(add) }} </td>
                    <td v-if="budget.status == 2" class="py-3 px-5 cursor-pointer" :title="'Editar ' + index"
                        @click="openModal(index)">
                        <PencilIcon class=" w-full h-6 text-stone-500" />
                    </td>
                    <td v-if="budget.status == 2" class="py-3 px-5 cursor-pointer" :title="'Excluir ' + index"
                        @click="deleteItem(index)">
                        <XMarkIcon class=" w-full h-6 text-stone-500" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="w-full text-center">
        <p>Não há adições cadastradas no momento!</p>
    </div>
    <p v-if="budget.status == 2"
        class="text-blue-400 hover:text-blue-600 active:text-blue-800 cursor-pointer flex-row-config space-x-1 py-5"
        @click="openModal(null)">
        <PlusIcon class="w-4 h-4" />
        <span>Cadastrar adição</span>
    </p>
    <ModalManageAdditions v-if="open_modal" :ceremony="ceremony" :budget="budget" :first_installment="first_installment"
        :addition="selected_option" :op_type="op_type" @modal_open="(open) => open_modal = open" />
</template>