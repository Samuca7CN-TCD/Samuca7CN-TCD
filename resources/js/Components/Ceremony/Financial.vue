<script setup>
import { ref } from 'vue';
import { CheckBadgeIcon, PencilIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import ModalCreateInstallments from '@/Components/Ceremony/Modals/ModalCreateInstallments.vue';
const props = defineProps({
    ceremony: Object,
    budget: Object,
    financial: Number,
});

const open_create_installments_modal = ref(false);
const formatDate = (date) => {
    date = date.split(/\-|\ |\:|\T|\./);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}
</script>
<template>
    <div class="w-full bg-gray-700 text-white">
        <p>Excedente:</p><span class="inline-flex">{{ toMonetary(ceremony.total_negotiated_amount - ceremony.total_expenses)
        }}</span>
    </div>
    <p>Parcelas e Pagamentos</p>
    <div v-if="!JSON.parse(ceremony.installments)">Não há parcelamentos cadastrados no momento</div>
    <div v-else class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3  gap-4 m-5">
        <div v-for="installment in JSON.parse(ceremony.installments)" :key="installment.id"
            class="bg-white border-2 group overflow-hidden border-gray-200 rounded-xl flex flex-row space-x-5 px-5 items-center align-middle cursor-pointer hover:shadow-2xl active:shadow-none"
            title="Opções da Parcela">
            <CheckBadgeIcon class="w-10 h-10"
                :class="{ 'text-green-500': installment.paid, 'text-gray-500': !installment.paid }" />
            <div class="p-2 w-full flex flex-col space-y-2">
                <p class="text-xl text-gray-900 my-2">{{ installment.name }}</p>

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
    <button @click="open_create_installments_modal = true">Cadastrar parcelamemntos</button>
    <ModalCreateInstallments v-if="open_create_installments_modal" :ceremony="ceremony" :budget="budget"
        @modal_open="(open) => open_create_installments_modal = open" />


    <p>Despesas</p>
    <div v-if="JSON.parse(ceremony.expenses)" class="mt-10 overflow-auto">
        <!-- Orçamentos do cliente -->
        <table class="w-full m-auto table-auto truncate">
            <thead class="lg:border-b-2 lg:border-gray-500">
                <th>Custo</th>
                <th>Valor</th>
                <th>Editar</th>
                <th>Excluir</th>
            </thead>
            <tbody>
                <tr v-for="(expense, index, i = 0) in JSON.parse(ceremony.expenses)" :key="budget.id"
                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                    :class="{ 'bg-gray-100': (i++) % 2 == 0 }">
                    <td class="py-3 px-5 truncate" :title="index">{{ index }}</td>
                    <td class="py-3 px-5 truncate">{{ toMonetary(expense) }} </td>
                    <td class="py-3 px-5">
                        <PencilIcon class="w-6 h-6 cursor-pointer" @click="alert('editar')" />
                    </td>
                    <td class="py-3 px-5">
                        <XMarkIcon class="w-6 h-6 cursor-pointer" @click="alert('excluir')" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="w-full text-center my-5">Não há custos cadastrados no momento!</div>
</template>