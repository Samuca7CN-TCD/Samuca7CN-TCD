<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/core';

const props = defineProps({
    ceremony: Object,
    budget: Object,
});

const emit = defineEmits(['modal_open']);
const processing = ref(false);

const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }


const installments = ref([]);

const installments_config = ref({
    name: 'Parcelamento',
    payment_option: 1,
});

const calcularParcelas = (dataEvento, valorTotal, option) => {
    if (option == 1) {
        const valorEntrada = valorTotal * 0.15;
        const dataEntrada = new Date();
        dataEntrada.setDate(dataEntrada.getDate() + 14); // adiciona 2 semanas para pagamento da entrada

        const dataFechamento = new Date(dataEvento);
        dataFechamento.setDate(dataFechamento.getDate() - 14); // subtrai 2 semanas para data de fechamento

        let mesesEntreDatas = 0;
        if (dataEntrada.getFullYear() < dataFechamento.getFullYear()) mesesEntreDatas = (dataFechamento.getFullYear() - dataEntrada.getFullYear() - 1) * 12
        mesesEntreDatas += dataFechamento.getMonth() - dataEntrada.getMonth() - 1;

        const valorFechamento = valorTotal * 0.15;

        const valorParcelas = (valorTotal * 0.7) / mesesEntreDatas;

        let parcelas = [];
        parcelas.push({ valor: valorEntrada, data: dataEntrada });

        for (let i = 1; i <= mesesEntreDatas; i++) {
            const dataParcela = new Date(dataEntrada);
            dataParcela.setMonth(dataParcela.getMonth() + i);

            parcelas.push({ valor: valorParcelas, data: dataParcela });
        }

        parcelas.push({ valor: valorFechamento, data: dataFechamento });

        return parcelas;

    }

    if (option == 2) {
        dataEvento = new Date(dataEvento);
        const dataAtual = new Date();
        const dataLimiteEntrada = new Date(dataAtual.getTime() + 14 * 24 * 60 * 60 * 1000); // 2 semanas após a data atual
        const dataLimiteFechamento = new Date(dataEvento.getTime() - 30 * 24 * 60 * 60 * 1000); // 30 dias antes da data do evento

        const valorEntrada = valorTotal * 0.5;
        const valorFechamento = valorTotal * 0.5;

        const parcelas = [
            {
                valor: valorEntrada,
                data: dataLimiteEntrada,
            },
            {
                valor: valorFechamento,
                data: dataLimiteFechamento,
            },
        ];

        return parcelas;
    }
    if (option == 3) {
        dataEvento = new Date(dataEvento);
        const hoje = new Date();
        const dataLimite = new Date();
        dataLimite.setDate(hoje.getDate() + 14); // adiciona 14 dias (duas semanas) à data de hoje

        const valorComDesconto = valorTotal * 0.95; // desconto de 5%
        return [{
            valor: valorComDesconto,
            data: dataLimite,
        }];
    }
    if (option == 4) {
        dataEvento = new Date(dataEvento);
        const hoje = new Date();

        const primeiraParcela = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate() + 14);
        const ultimaParcela = new Date(dataEvento.getFullYear(), dataEvento.getMonth(), dataEvento.getDate() - 14);

        const totalMeses = ultimaParcela.getMonth() - primeiraParcela.getMonth();
        const valorParcela = valorTotal / totalMeses;

        let parcelas = [];
        let valorRestante = valorTotal;

        for (let i = 0; i < totalMeses; i++) {
            parcelas.push({
                valor: valorParcela,
                data: new Date(primeiraParcela.getFullYear(), primeiraParcela.getMonth() + i, primeiraParcela.getDate())
            });
            valorRestante -= valorParcela;
        }

        parcelas[parcelas.length - 1].valor += valorRestante; // ajusta a última parcela

        return parcelas;
    }
}

const loadInstallments = () => {
    const config = installments_config.value;

    installments.value = [];
    let parcelas = calcularParcelas(props.budget.event_date, props.ceremony.total_negotiated_amount, config.payment_option);
    let lastKey = 0;
    parcelas.forEach((parcela, index) => {
        installments.value.push({
            id: lastKey,
            name: config.name + ' #' + lastKey,
            paid_amount: 0,
            paid: false,
            total_amount: parcela.valor,
            deadline: parcela.data.getFullYear() + '-' + dateZeroFiller(parcela.data.getMonth() + 1) + '-' + dateZeroFiller(parcela.data.getDate()) + ' 23:59:59',
            entry: !index ? true : false,
            vouchers: JSON.stringify({}),
        });
        lastKey += 1;
    });
}
loadInstallments();

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}
const closeModal = () => {
    installments_config.name = "";
    installments_config.payment_option = 1;
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
                            v-model="installments_config.name" @keyup="loadInstallments"
                            class="w-full border-slate-300 sm:text-md" />
                    </div>

                    <!-- Opção de parcelamento -->
                    <div class="w-full">
                        <label for="installment_payment_option" class="text-xs text-slate-700">Condição de pagamento</label>
                        <select id="installment_payment_option" class="w-full border-slate-300 sm:text-md"
                            v-model="installments_config.payment_option" @change="loadInstallments">
                            <option value="0" disabled>Escolha uma das opções abaixo</option>
                            <option value="1">15% de entrada + 70% parcelado + 15% duas semanas antes do evento</option>
                            <option value="2">50% entrada + 50% uma mês antes do evento</option>
                            <option value="3">100% pix com 5% de desconto</option>
                            <option value="4">Dividir valor total igualmente</option>
                        </select>
                    </div>

                    <ul class="space-y-5 py-5">
                        <div class="mt-10 overflow-auto">
                            <!-- Orçamentos do cliente -->
                            <table class="w-full m-auto table-auto truncate">
                                <thead class="lg:border-b-2 lg:border-gray-500">
                                    <th>Nome</th>
                                    <th>Valor</th>
                                    <th>Prazo</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(installment, index) in installments" :key="installment.id"
                                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                                        :class="{ 'bg-gray-100': (index % 2 != 0) }">
                                        <td class="py-3 px-5 truncate">{{ installment.name }} {{ installment.paid ? '(pago)'
                                            : '' }}</td>
                                        <td class="py-3 px-5 truncate">{{ toMonetary(installment.total_amount) }}</td>
                                        <td class="py-3 px-5 truncate">{{ installment.deadline.split(' ')[0] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </ul>
                </div>
                <div class="w-full px-4 py-3 sm:px-6 mt-5 text-right">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': processing }"
                        :disabled="processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>