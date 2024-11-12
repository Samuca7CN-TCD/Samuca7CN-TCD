<script setup>
import { ref } from 'vue';
import ModalManageAdditions from './Modals/ModalManageAdditions.vue';
import ModalPayAdditions from './Modals/ModalPayAdditions.vue';
import { PencilIcon, XMarkIcon, PlusIcon, CheckBadgeIcon, BanknotesIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';
import { toMonetary } from '/resources/js/shared_functions.js';
import axios from 'axios';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    additions: Object,
});

const open_modal = ref(false);
const open_payment_modal = ref(false);

const addition = ref({});
const add_vouchers = ref({});
const openModal = (add = null) => {
    addition.value = add;
    open_modal.value = true;
}

const pay_additon = (add) => {
    axios.get(route('get-addition-vouchers', add.id))
        .then(response => {
            add_vouchers.value = response.data;
            addition.value = add;
            open_payment_modal.value = true;
        });
}

const delete_additon = (add_id) => {
    router.delete(route('ceremonies.delete.addition', add_id), {
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
    <div v-if="additions.length" class="mt-10 overflow-auto">
        <!-- Orçamentos do cliente -->
        <table class="w-full m-auto table-auto truncate">
            <thead class="lg:border-b-2 lg:border-gray-500">
                <th>Pago</th>
                <th>Nome</th>
                <th>Valor Total</th>
                <th>Valor Restante</th>
                <th v-if="budget.status == 1">Pagar</th>
                <th v-if="budget.status == 2">Editar</th>
                <th v-if="budget.status == 2">Excluir</th>
            </thead>
            <tbody>
                <tr v-for="(add, i = 0) in additions" :key="add.id"
                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                    :class="{ 'bg-gray-100': (i++) % 2 == 0 }">
                    <td class="py-3 px-5 flex flex-col items-center align-middle">
                        <CheckBadgeIcon class="w-5 h-5"
                            :class="{ 'text-green-500': add.paid, 'text-gray-500': !add.paid }" />
                    </td>
                    <td class="py-3 px-5 truncate" :title="add.name">{{ add.name }}</td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(add.amount) }} </td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(add.left_amount) }} </td>
                    <td v-if="budget.status == 1" class="py-3 px-5 cursor-pointer" :title="'Pagar ' + add.name"
                        @click="pay_additon(add)">
                        <BanknotesIcon class=" w-full h-6 text-stone-500" />
                    </td>
                    <td v-if="budget.status == 2" class="py-3 px-5 cursor-pointer" :title="'Editar ' + add.name"
                        @click="openModal(add)">
                        <PencilIcon class=" w-full h-6 text-stone-500" />
                    </td>
                    <td v-if="budget.status == 2" class="py-3 px-5 cursor-pointer" :title="'Excluir ' + add.name"
                        @click="delete_additon(add.id)">
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
    <ModalManageAdditions v-if="open_modal" :ceremony="ceremony" :addition="addition"
        @modal_open="(open) => open_modal = open" />
    <ModalPayAdditions v-if="open_payment_modal" :ceremony="ceremony" :addition="addition" :additions="additions"
        :add_vouchers="add_vouchers" @modal_payment_open="(open) => open_payment_modal = open" />
</template>