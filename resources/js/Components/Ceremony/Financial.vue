<script setup>
import { ref } from 'vue';
import { CheckBadgeIcon } from '@heroicons/vue/24/solid';
import ModalCreateInstallments from '@/Components/Ceremony/Modals/ModalCreateInstallments.vue';
import ModalManageInstallment from '@/Components/Ceremony/Modals/ModalManageInstallment.vue';
import Ceremony from '@/Components/Ceremony/Ceremony.vue';
import FinancialAdditions from '@/Components/Ceremony/FinancialAdditions.vue';
import FinancialExpenses from '@/Components/Ceremony/FinancialExpenses.vue';
import BudgetStatusButton from '@/Components/BudgetStatusButton.vue';
import { toMonetary, formatDate } from '/resources/js/shared_functions.js';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    installments: Object,
    additions: Object,
    expenses: Object,
    has_installment: Boolean,
});


const open_create_installments_modal = ref(false);
const open_manage_installment_modal = ref(false);
const selected_installment = ref({});
const vouchers = ref({});
const obs = ref(props.ceremony.observations || "");
const obs_rows = ref(obs.value.split('\n').length || 1);

const openManagemantModal = (installment) => {
    if (props.budget.status != 1) return;
    selected_installment.value = installment;

    axios.get(route('get-vouchers', installment.id))
        .then(response => {
            console.log(response.data);
            vouchers.value = response.data;
            open_manage_installment_modal.value = true;
        });
}

const saveObs = () => {
    obs_rows.value = obs.value.split('\n').length || 1;
    router.put(route('ceremonies.updade.obs', props.ceremony.id), { obs: obs.value }, {
        preserveScroll: true,
    });
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full min-h-[10px] bg-gray-900">
            <Ceremony :ceremony="ceremony" :budget="budget" :button_type="1" />
        </div>
        <div class="w-full bg-stone-700 text-white flex-row-config space-x-5 text-2xl py-5">
            <p>Excedente:</p><span class="inline-flex">{{ toMonetary(ceremony.total_negotiated_amount +
                ceremony.total_additions -
                ceremony.total_expenses)
            }}</span>
        </div>

        <div class="m-5 rounded-md border-2 border-stone-100">
            <div class="flex-col-config mb-5 bg-stone-100 py-5 font-mono text-yellow-700">
                <p class="text-4xl">Parcelas</p>
                <p class="text-xl">{{ toMonetary(ceremony.total_installments) }}</p>
            </div>
            <div v-if="!installments.length" class="text-center">Não há parcelas cadastradas no momento</div>
            <div v-else class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3  gap-4 m-5">
                <div v-for="installment in installments" :key="installment.id"
                    class="bg-white border-2 group overflow-hidden border-gray-200 rounded-xl flex flex-row space-x-5 px-5 items-center align-middle"
                    :class="{ 'cursor-pointer hover:shadow-2xl active:shadow-none': budget.status == 1 }"
                    title="Opções da Parcela" @click="openManagemantModal(installment)">
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

            <div v-if="budget.status == 2" class="w-full flex-row-config">
                <button class="p-3 rounded-lg my-2 bg-stone-900 text-white text-lg"
                    @click="open_create_installments_modal = true">Cadastrar parcelas</button>
            </div>
        </div>

        <div class="mx-10">
            <label for="obs" class="text-xs text-slate-700">Observações</label>
            <textarea id="obs" :rows="obs_rows" v-model="obs" placeholder="Observações sobre a Cerimônia"
                class="w-full border-slate-300 sm:text-md" @input="saveObs" autofocus="true"></textarea>
        </div>

        <div class="m-5 rounded-md border-2 border-stone-100">
            <FinancialAdditions :ceremony="ceremony" :budget="budget" :additions="additions" />
        </div>
        <div class="m-5 rounded-md border-2 border-stone-100">
            <FinancialExpenses :ceremony="ceremony" :budget="budget" :expenses="expenses" />
        </div>

        <div class="w-full p-10">
            <BudgetStatusButton :budget="budget" :ceremony="ceremony" :has_installment="has_installment" />
        </div>

        <ModalCreateInstallments v-if="open_create_installments_modal" :ceremony="ceremony" :budget="budget"
            @modal_open="(open) => open_create_installments_modal = open" />
        <ModalManageInstallment v-if="open_manage_installment_modal" :ceremony="ceremony" :installments="installments"
            :installment="selected_installment" :vouchers="vouchers"
            @modal_open="(open) => open_manage_installment_modal = open" />
    </section>
</template>