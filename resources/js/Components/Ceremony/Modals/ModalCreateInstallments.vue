<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import loadInstallments from './loadInstallments.js';
import { toMonetary } from '/resources/js/shared_functions.js';

const props = defineProps({
    ceremony: Object,
    budget: Object,
});

const emit = defineEmits(['modal_open']);
const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
const installments_config = ref({
    name: 'Parcela',
    payment_day: 10,
    type: 0, // 0 é payment_option = 1 mensal | 1 é payment_option = 1 mensal | 2 é payment_option = 2 | 2 é payment_option = 3 | 4 é payment_option = 4 |
    payment_option: 1,
});

const installments = ref(loadInstallments(installments_config.value, (props.budget.budget_total_value + props.ceremony.total_additions), props.budget.event_date));

const installment = useForm({
    id: installments.value[installments.value.length] + 1,
    name: 'Parcela',
    type: 0,
    paid_amount: 0,
    paid: 0,
    total_amount: 0,
    deadline: (new Date()).toISOString().slice(0, 19).replace('', 'T'),
    entry: false,
    vouchers: [],
});

const closeModal = () => {
    installments_config.value.name = "";
    installments_config.value.payment_option = 1;
    emit('modal_open', false);
}

const submit = () => {
    router.put(route('ceremonies.update', props.ceremony.id), { installment_list: installments.value }, {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
}
</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-blue-100 p-2 rounded-full text-blue-400">
                    <PlusIcon class="w-5 h-5" />
                </span>
                <h2 class="text-2xl bold">Cadastrar Parcelas</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro do parcelamento do pagamento da cerimônia</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">

            <div class="overflow-hidden m-5 md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0 space-y-2">

                    <!-- Nome -->
                    <div class="w-full">
                        <label for="installment_name" class="text-xs text-slate-700">Nome das
                            parcelas</label>
                        <input type="text" id="installment_name" placeholder="Ex: Primeiro parcelamento"
                            v-model="installments_config.name"
                            @keyup="installments = loadInstallments(installments_config, (ceremony.total_negotiated_amount + ceremony.total_additions), budget.event_date)"
                            class="w-full border-slate-300 sm:text-md" />
                    </div>

                    <!-- Dia de pagamento -->
                    <div v-if="installments_config.payment_option == 1 || installments_config.payment_option == 4"
                        class="w-full">
                        <label for="installment_payment_day" class="text-xs text-slate-700">Dia de pagamento das
                            parcelas</label>
                        <input type="number" step="1" min="1" max="28" id="installment_payment_day"
                            placeholder="Ex: Todo dia 10 (Dia máximo: 28)" v-model="installments_config.payment_day"
                            @keyup="installments = loadInstallments(installments_config, (ceremony.total_negotiated_amount + ceremony.total_additions), budget.event_date)"
                            class="w-full border-slate-300 sm:text-md" />
                    </div>

                    <!-- Opção de parcelamento -->
                    <div class="w-full">
                        <label for="installment_payment_option" class="text-xs text-slate-700">Condição de pagamento</label>
                        <select id="installment_payment_option" class="w-full border-slate-300 sm:text-md"
                            v-model="installments_config.payment_option"
                            @change="installments = loadInstallments(installments_config, (ceremony.total_negotiated_amount + ceremony.total_additions), budget.event_date)">
                            <option value="0" disabled>Escolha uma das opções abaixo</option>
                            <option value="1">15% de entrada + 70% parcelado + 15% duas semanas antes do evento
                            </option>
                            <option value="2">50% entrada + 50% uma mês antes do evento</option>
                            <option value="3">100% pix com 5% de desconto</option>
                            <option value="4">Dividir valor total igualmente</option>
                        </select>
                    </div>

                    <!--Mensal ou Semestral-->
                    <div v-if="installments_config.payment_option == 1" class="w-full py-3 flex flex-col">
                        <label class="text-xs text-slate-700">Tipo de mensalidade</label>
                        <span class="flex flex-row space-x-2 align-middle items-center">
                            <input id="mensal_input" type="radio" class="form-radio text-stone-500" value="0"
                                name="installment_type" v-model="installments_config.type"
                                @change="installments = loadInstallments(installments_config, (ceremony.total_negotiated_amount + ceremony.total_additions), budget.event_date)">
                            <label for="mensal_input" class="ml-2">Mensal</label>
                        </span>
                        <span class="flex flex-row space-x-2 align-middle items-center">
                            <input id="trimestral_input" type="radio" class="form-radio text-stone-500" value="1"
                                name="installment_type" v-model="installments_config.type"
                                @change="installments = loadInstallments(installments_config, (ceremony.total_negotiated_amount + ceremony.total_additions), budget.event_date)">
                            <label for="trimestral_input" class="ml-2">Trimestral</label>
                        </span>
                    </div>

                    <div class="mt-10 overflow-auto">
                        <!-- Orçamentos do cliente -->
                        <table class="w-full m-auto table-auto truncate">
                            <thead class="lg:border-b-2 lg:border-gray-500">
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Prazo</th>
                            </thead>
                            <tbody>
                                <tr v-for="(installment, index) in installments" :key="installment.id"
                                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                                    :class="{ 'bg-gray-100': (index % 2 != 0) }">
                                    <td class="py-3 px-5 truncate">#{{ installment.id }}</td>
                                    <td class="py-3 px-5 truncate">{{ installment.name }} {{ installment.paid ? '(pago)'
                                        : '' }}</td>
                                    <td class="py-3 px-5 truncate">{{ toMonetary(installment.total_amount) }}</td>
                                    <td class="py-3 px-5 truncate">{{ installment.deadline.split(' ')[0] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 text-right">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': installment.processing }"
                        :disabled="installment.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': installment.processing }"
                        :disabled="installment.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>