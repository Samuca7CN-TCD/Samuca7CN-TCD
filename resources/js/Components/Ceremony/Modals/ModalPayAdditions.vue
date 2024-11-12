<script setup>
import { ref, useCssModule } from 'vue';
import { CheckBadgeIcon, PencilIcon, XMarkIcon, PaperClipIcon, ArrowUpOnSquareIcon } from '@heroicons/vue/24/solid';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import { toMonetary, formatDate } from '/resources/js/shared_functions.js';
import axios from 'axios';

const props = defineProps({
    ceremony: Object,
    addition: Object,
    additions: Object,
    add_vouchers: Object,
});

const addition = ref({
    id: props.addition.id,
    ceremony_id: props.addition.ceremony_id,
    name: props.addition.name,
    amount: props.addition.amount,
    left_amount: props.addition.left_amount,
    paid: props.addition.paid,
    processing: false,
});

const add_vouchers = ref(props.add_vouchers);

const new_voucher = ref({
    budget_additional_id: addition.value.id,
    name: null,
    value: addition.value.left_amount,
    file: null,
    payment_date: new Date().toISOString().slice(0, 10),
});

const pay = () => {
    if (addition.value.paid || new_voucher.value.value > addition.value.left_amount) {
        alert('Você não pode pagar mais do que o valor restante!');
        return;
    }

    if (!new_voucher.value.value || new_voucher.value.value < 0) {
        alert('Insira um valor entre R$ 0,00 e ' + toMonetary(addition.value.left_amount));
        return;
    }

    if (!new_voucher.value.file) {
        alert('O upload do comprovante é obrigatório!');
        return;
    }

    addition.value.processing = true;
    router.post(route('ceremonies.pay.addition.voucher', props.ceremony.id), new_voucher.value, {
        preserveScroll: true,
        onSuccess: () => recalc_conditions(),
    });
}

const recalc_conditions = () => {
    const response = props.additions.find((i) => i.id == addition.value.id);
    addition.value.amount = response.amount;
    addition.value.left_amount = response.left_amount;
    addition.value.paid = response.paid;

    new_voucher.value.name = null;
    new_voucher.value.value = response.left_amount;
    new_voucher.value.file = null;

    addition.value.processing = false;
    axios.get(route('get-addition-vouchers', props.addition.id))
        .then(response => {
            add_vouchers.value = response.data;
        }).catch(error => {
            console.error(error);
        });
}

const deletePayment = (voucher_id) => {
    addition.value.processing = true;
    router.put(route('ceremonies.delete.addition.voucher', props.ceremony.id), { id: voucher_id }, {
        preserveScroll: true,
        //onSuccess: () => recalc_conditions(),
    });
}

const emit = defineEmits(['modal_payment_open']);
const closeModal = () => {
    emit('modal_payment_open', false);
    // router.get(route('financials.index', props.ceremony.id), { preserveScroll: true, });
}

</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="p-2 rounded-full">
                    <CheckBadgeIcon class="w-6 h-6 text-gray-500" :class="{ 'text-green-500': addition.paid }" />
                </span>
                <h2 class="text-2xl bold">{{ addition.name }}
                </h2>
            </div>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">

            <div class="w-full overflow-hidden m-5 md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Informações do Adicional</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor total</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(addition.amount) }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor pago</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(addition.amount - addition.left_amount) }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor restante</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(addition.left_amount) }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Comprovantes</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                        <li v-for="voucher in add_vouchers" :key="voucher.id"
                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm group">
                                            <div class="flex w-0 flex-1 items-center">
                                                <PaperClipIcon
                                                    class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:hidden"
                                                    aria-hidden="true" />
                                                <XMarkIcon
                                                    class="h-5 w-5 flex-shrink-0 text-gray-400 hidden group-hover:inline-flex cursor-pointer"
                                                    title="Excluir pagamento" aria-hidden="true"
                                                    @click="deletePayment(voucher.id)" />
                                                <span class="ml-2 w-0 flex-1 truncate text-gray-500"
                                                    :title="voucher.name">{{ voucher.name
                                                    }}</span>
                                                <span class="ml-2 w-0 flex-1">{{ toMonetary(parseFloat(voucher.value))
                                                }}</span>
                                                <span class="text-xs text-gray-500">{{
                                                    formatDate(voucher.payment_date).substr(0, 10) }}</span>
                                            </div>
                                            <div class=" ml-4 flex-shrink-0">
                                                <a :href="'../storage/addition_files/' + voucher.file" target="_blank"
                                                    class="font-medium text-indigo-600 hover:text-indigo-500">Baixar</a>
                                            </div>
                                        </li>
                                        <li v-if="!addition.paid"
                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-2 flex-1 space-y-2 w-full">
                                                    <div class="w-full space-y-5">
                                                        <div>
                                                            <label for="payment_amount" class="text-gray-400">Valor de
                                                                pagamento
                                                                (R$)</label>
                                                            <input id="payment_amount" type="number" step="0.01" min="0.00"
                                                                :max="addition.left_amount" class="w-full border-gray-300"
                                                                v-model="new_voucher.value" placeholder="Valor" />
                                                        </div>
                                                        <div>
                                                            <label for="payment_date" class="text-gray-400">Data do
                                                                pagamento</label>
                                                            <input type="date" id="payment_date"
                                                                placeholder="Data do pagamento"
                                                                class="w-full border-slate-300 sm:text-md"
                                                                v-model="new_voucher.payment_date" />
                                                        </div>
                                                        <div class="flex flex-row items-center align-middle space-x-3">
                                                            <label for="voucher"
                                                                class="flex-col-config p-2 w-fit bg-blue-500 rounded-xl cursor-pointer"
                                                                title="Inserir comprovante">
                                                                <ArrowUpOnSquareIcon class="w-6 h-6 text-white" />
                                                            </label>
                                                            <span class="w-full flex-wrap">{{ new_voucher.name != null ?
                                                                new_voucher.name : 'Insira o comprovante (obrigatório)'
                                                            }}</span>
                                                            <input id="voucher"
                                                                @input="new_voucher.name = $event.target.files[0].name; new_voucher.file = $event.target.files[0]"
                                                                type="file" accept=".pdf" class="hidden" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <p class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                                    @click="pay()">
                                                    Adicionar</p>
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 text-right">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': addition.processing }"
                        :disabled="addition.processing" @click="closeModal">
                        Fechar
                    </SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>