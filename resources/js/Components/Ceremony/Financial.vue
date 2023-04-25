<script setup>
import { ref } from 'vue';
import { CheckBadgeIcon } from '@heroicons/vue/24/solid';
import ModalCreateInstallments from '@/Components/Ceremony/Modals/ModalCreateInstallments.vue';
import ModalManageInstallment from '@/Components/Ceremony/Modals/ModalManageInstallment.vue';
import Ceremony from '@/Components/Ceremony/Ceremony.vue';
import FinancialAdditions from '@/Components/Ceremony/FinancialAdditions.vue';
import FinancialExpenses from '@/Components/Ceremony/FinancialExpenses.vue';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    installments: Object,
    additions: Object,
    expenses: Object,
});

const open_create_installments_modal = ref(false);
const open_manage_installment_modal = ref(false);
const open_crud_extras = ref(false);
const selected_installment = ref({});

const openManagemantModal = (installment_id) => {
    selected_installment.value = JSON.parse(props.ceremony.installments).filter((el) => el.id == installment_id)[0];
    open_manage_installment_modal.value = true;
}

const formatDate = (date) => {
    date = date.split(/\-|\ |\:|\T|\./);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

const toMonetary = (value) => {
    if (value !== null) return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full min-h-[10px] bg-gray-900">
            <Ceremony :ceremony="ceremony" :budget="budget" :button_type="1" />
        </div>
        <div class="w-full bg-stone-700 text-white flex-row-config space-x-5 text-2xl py-5">
            <p>Excedente:</p><span class="inline-flex">{{ toMonetary(ceremony.total_negotiated_amount -
                ceremony.total_expenses)
            }}</span>
        </div>
        <div class="flex-col-config my-5 bg-stone-100 py-5 font-mono text-yellow-700">
            <p class="text-4xl">Parcelas</p>
            <p class="text-xl">{{ toMonetary(ceremony.total_installments) }}</p>
        </div>
        <div v-if="!installments.length" class="text-center">Não há parcelas cadastradas no momento</div>
        <div v-else class="bg-stone-50 grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3  gap-4 m-5">
            <div v-for="installment in JSON.parse(ceremony.installments)" :key="installment.id"
                class="bg-white border-2 group overflow-hidden border-gray-200 rounded-xl flex flex-row space-x-5 px-5 items-center align-middle cursor-pointer hover:shadow-2xl active:shadow-none"
                title="Opções da Parcela" @click="openManagemantModal(installment.id)">
                <CheckBadgeIcon class="w-10 h-10"
                    :class="{ 'text-green-500': installment.paid, 'text-gray-500': !installment.paid }" />
                <div class="p-2 w-full flex flex-col space-y-2">
                    <p class="text-xl text-gray-900">{{ installment.name }}</p>
                    <div>
                        <p class="text-xs text-gray-700">Restante: {{ toMonetary(installment.total_amount -
                            installment.paid_amount) }}</p>
                        <p class="text-lg text-gray-900">{{ toMonetary(installment.total_amount) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">{{ formatDate(installment.deadline).split(' ')[0] }}</p>
                        <p v-if="installment.entry" class="text-xs text-gray-400">Entrada</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="ceremony.status == 0" class="w-full flex-row-config">
            <button class="p-3 rounded-lg mt-5 bg-stone-900 text-white text-lg"
                @click="open_create_installments_modal = true">Cadastrar parcelas</button>
        </div>

        <FinancialAdditions :ceremony="ceremony" :additions="additions" />
        <FinancialExpenses :ceremony="ceremony" :expenses="expenses" />

        <ModalCreateInstallments v-if="open_create_installments_modal" :ceremony="ceremony" :budget="budget"
            @modal_open="(open) => open_create_installments_modal = open" />
        <ModalManageInstallment v-if="open_manage_installment_modal" :ceremony="ceremony"
            :installment="selected_installment" @modal_open="(open) => open_manage_installment_modal = open" />
    </section>
</template>