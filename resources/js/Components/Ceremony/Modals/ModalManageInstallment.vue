<script setup>
import { ref, useCssModule } from 'vue';
import { CheckBadgeIcon, PencilIcon, XMarkIcon, PaperClipIcon, ArrowUpOnSquareIcon } from '@heroicons/vue/24/solid';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import { toMonetary, formatDate, geraStringAleatoria } from '../../shared_functions.js';

const props = defineProps({
    ceremony: Object,
    installment: Object,
    installments: Object,
});

const installment = ref({
    id: props.installment.id,
    name: props.installment.name,
    paid_amount: props.installment.paid_amount,
    paid: props.installment.paid,
    total_amount: props.installment.total_amount,
    deadline: props.installment.deadline,
    entry: props.installment.entry,
    vouchers: props.installment.vouchers,
    processing: false,
});

const new_voucher = ref({
    id: installment.value.vouchers.length ? installment.value.vouchers[installment.value.vouchers.length - 1].id + 1 : 0,
    installment_id: installment.value.id,
    name: null,
    value: installment.value.total_amount - installment.value.paid_amount,
    file: null,
});

const pay = () => {
    if (installment.value.paid || new_voucher.value.value > installment.value.total_amount - installment.value.paid_amount) {
        alert('Você não pode pagar mais do que o valor restante!');
        return;
    }

    if (!new_voucher.value.value || new_voucher.value.value < 0) {
        alert('Insira um valor entre R$ 0,00 e ' + toMonetary(installment.value.total_amount - installment.value.paid_amount));
        return;
    }

    if (!new_voucher.value.file) {
        alert('O upload do comprovante é obrigatório!');
        return;
    }

    new_voucher.value.id = installment.value.vouchers.length;
    installment.value.processing = true;
    router.post(route('ceremonies.update.voucher', props.ceremony.id), new_voucher.value, {
        preserveScroll: true,
        onSuccess: () => recalc_conditions(),
    });
}

const deletePayment = (voucher_id) => {
    installment.value.processing = true;
    console.log(installment.value.vouchers);
    if (installment.value.vouchers.length == undefined) {
        installment.value.vouchers = Object.values(installment.value.vouchers);
    }
    console.log(installment.value.vouchers);
    const voucher_delete = installment.value.vouchers.find((v) => v.id == voucher_id);
    console.log(installment.value.vouchers);
    if (!voucher_delete) { alert('Comprovante não encontrado!'); return; }
    router.put(route('ceremonies.delete.voucher', props.ceremony.id), voucher_delete, {
        preserveScroll: true,
        onSuccess: () => recalc_conditions(),
    });
}

const recalc_conditions = () => {
    const response = props.installments.find((i) => i.id == installment.value.id);
    installment.value.paid_amount = response.paid_amount;
    installment.value.paid = response.paid;
    installment.value.total_amount = response.total_amount;
    installment.value.vouchers = response.vouchers;

    new_voucher.value.name = null;
    new_voucher.value.value = response.total_amount - response.paid_amount;
    new_voucher.value.file = null;

    installment.value.processing = false;
}

const emit = defineEmits(['modal_open']);
const closeModal = () => {
    //emit('modal_open', false);
    router.get(route('financials.index', props.ceremony.id), { preserveScroll: true, });
}

</script>
<template>
    <Modal :show="true">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="p-2 rounded-full">
                    <CheckBadgeIcon class="w-6 h-6 text-gray-500" :class="{ 'text-green-500': installment.paid }" />
                </span>
                <h2 class="text-2xl bold">{{ installment.name }}
                    <p class="text-xs">{{ installment.entry ? ' (Entrada)' : '' }}</p>
                </h2>
            </div>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">

            <div class="overflow-hidden m-5 md:m-0 p-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Informações da Parcela</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor total da parcela</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(installment.total_amount) }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor pago</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(installment.paid_amount) }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Valor restante</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ toMonetary(installment.total_amount - installment.paid_amount) }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Prazo de Pagamento</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    {{ formatDate(installment.deadline) }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Pagamento e Comprovantes</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                        <li v-for="voucher in installment.vouchers" :key="voucher.id"
                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm group">
                                            <div class="flex w-0 flex-1 items-center">
                                                <PaperClipIcon
                                                    class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:hidden"
                                                    aria-hidden="true" />
                                                <XMarkIcon
                                                    class="h-5 w-5 flex-shrink-0 text-gray-400 hidden group-hover:inline-flex cursor-pointer"
                                                    title="Excluir pagamento" aria-hidden="true"
                                                    @click="deletePayment(voucher.id)" />
                                                <span class="ml-2 w-0 flex-1 truncate text-gray-500">{{ voucher.name
                                                }}</span>
                                                <span class="ml-2 w-0 flex-1">{{ toMonetary(parseFloat(voucher.value))
                                                }}</span>
                                            </div>
                                            <div class=" ml-4 flex-shrink-0">
                                                <a :href="voucher.file" target="_blank"
                                                    class="font-medium text-indigo-600 hover:text-indigo-500">Baixar</a>
                                            </div>
                                        </li>
                                        <li v-if="!installment.paid"
                                            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">
                                                <div class="ml-2 flex-1 space-y-2 w-full">
                                                    <div class="w-full">
                                                        <label for="payment_amount" class="text-gray-400">Valor de pagamento
                                                            (R$)</label>
                                                        <input id="payment_amount" type="number" step="0.01" min="0.00"
                                                            :max="installment.total_amount - installment.paid_amount"
                                                            class="w-full border-gray-300" v-model="new_voucher.value"
                                                            placeholder="Valor" />
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
                                            <div class="ml-4 flex-shrink-0">
                                                <p class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                                    @click=" pay() ">
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
                    <SecondaryButton :type=" 'button' " class="ml-4" :class=" { 'opacity-25': installment.processing } "
                        :disabled=" installment.processing " @click=" closeModal ">
                        Fechar
                    </SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>