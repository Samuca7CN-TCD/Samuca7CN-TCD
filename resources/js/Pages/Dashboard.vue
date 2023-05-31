<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toMonetary, formatDate } from '/resources/js/shared_functions.js';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    budgets: Object,
    valor_total: Number,
    total_recebido: Number,
    total_a_receber: Number,
    total_custos: Number,
    total_gastos_mensais: Number,
    total_lucro: Number,
});

const valor_total = ref(props.valor_total);
const valor_recebido = ref(props.total_recebido);
const valor_a_receber = ref(props.total_a_receber);
const gastos_mensais = ref(props.total_gastos_mensais);
const gastos_cerimonias = ref(props.total_custos);
const lucro = ref(props.total_lucro);
const a_receber = ref(0);

const dashboard_date = ref({
    begin: '2023-05-29',
    end: '2023-05-29',
    option: 0,
})

const registros = ref([{
    cliente: null,
    cerimonia: null,
    valor_total: 0,
    valor_pago: 0,
    valor_restante: 0,
    gasto_total: 0,
    lucro: 0,
}]);

const setDateRange = (option) => {
    dashboard_date.value.option = option

    const today = new Date();
    const startDate = new Date();
    const endDate = new Date();

    switch (option) {
        case 0: // Hoje
            break;
        case 1: // Amanhã
            startDate.setDate(today.getDate() + 1);
            endDate.setDate(today.getDate() + 1);
            break;
        case 2: // Primeiro dia da semana atual (domingo) até o último dia da semana atual (sábado)
            startDate.setDate(today.getDate() - today.getDay());
            endDate.setDate(startDate.getDate() + 6);
            break;
        case 3: // Próximo domingo até o último dia da semana seguinte (sábado)
            startDate.setDate(today.getDate() + ((6 - today.getDay()) % 6) + 1);
            endDate.setDate(startDate.getDate() + 6);
            break;
        case 4: // Primeiro dia do mês atual até o último dia do mês atual
            startDate.setDate(1);
            endDate.setMonth(today.getMonth() + 1, 0);
            break;
        case 5: // Primeiro dia do próximo mês até o último dia do próximo mês
            startDate.setMonth(today.getMonth() + 1, 1);
            endDate.setMonth(today.getMonth() + 2, 0);
            break;
        case 6: // 1º de janeiro do ano atual até 31 de dezembro do ano atual
            startDate.setMonth(0, 1);
            endDate.setMonth(11, 31);
            break;
        case 7: // 1º de janeiro do próximo ano até 31 de dezembro do próximo ano
            startDate.setFullYear(today.getFullYear() + 1, 0, 1);
            endDate.setFullYear(today.getFullYear() + 1, 11, 31);
            break;
        default:
            break;
    }

    // Formatar as datas para o formato 'YYYY-MM-DD'
    dashboard_date.value.begin = patternDate(startDate);
    dashboard_date.value.end = patternDate(endDate);

    getDashboardValues();
}
const getDashboardValues = () => {
    axios.get(route('to-receive', { begin: dashboard_date.value.begin, end: dashboard_date.value.end }))
        .then(response => {
            a_receber.value = response.data ? response.data : 0
        });
}

const patternDate = (date) => {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}

getDashboardValues();

</script>

<template>
    <AppLayout title="Dashboard" :activated_page='-50'>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
            <div
                class="bg-stone-900 text-white rounded-md py-5 flex flex-row space-x-5 px-14 align-middle items-center text-2xl mx-5 mt-5">
                <p>Valor Total:</p>
                <p class="text-xs text-white"></p>
                {{ toMonetary(valor_total) }}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 m-5">
                <div class="w-full bg-orange-600 text-white rounded-md py-5 flex-col-config text-2xl">
                    <p>Valor recebido</p>
                    {{ toMonetary(valor_recebido) }}
                </div>
                <div class="w-full bg-yellow-600 text-white rounded-md py-5 flex-col-config text-2xl">
                    <p>Valor a receber</p>
                    {{ toMonetary(valor_a_receber) }}
                </div>
                <div class="w-full bg-red-600 text-white rounded-md py-5 flex-col-config text-2xl">
                    <p>Custos</p>
                    <span class="flex-row-config space-x-10">
                        <span>
                            <p class="text-xs">Cerimônias</p>
                            <p class="text-lg">{{ toMonetary(gastos_cerimonias) }}</p>
                        </span>
                        <span>
                            <a :href="route('monthly_expenses.index')">
                                <p class="text-xs">Gastos Mensais</p>
                                <p class="text-lg">{{ toMonetary(gastos_mensais) }}</p>
                            </a>
                        </span>
                    </span>
                </div>
                <div
                    class="w-full bg-green-600 text-white rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Lucro das Cerimônias</p>
                    {{ toMonetary(lucro) }}
                </div>
            </div>

            <div class="m-10 p-10 rounded-lg bg-gray-50">
                <div class="w-full rounded-md text-center items-center text-2xl">
                    <p>A receber no período</p>
                    <span>{{ toMonetary(a_receber) }}</span>
                    <p class="text-xs text-gray-900">Selecine um período nos campos abaixo para saber quanto dinhero irá
                        entrar</p>
                </div>

                <div class="col-row-config md:flex-row-config my-5 md:space-x-10">
                    <!-- Data -->
                    <div class="w-full md:w-1/3">
                        <label for="dashboard-begin" class="text-xs text-slate-700">Início</label>
                        <input type="date" id="dashboard-begin" placeholder="Data de Início"
                            class="w-full border-slate-300 sm:text-md" v-model="dashboard_date['begin']" />
                    </div>

                    <div class="w-full md:w-1/3">
                        <label for="dashboard-end" class="text-xs text-slate-700">Fim</label>
                        <input type="date" id="dashboard-end" placeholder="Data de Fim"
                            class="w-full border-slate-300 sm:text-md" v-model="dashboard_date['end']" />
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <ul class="flex-row-config divide-x-2 border-2 border-full w-fit m-auto">
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 0 }" @click="setDateRange(0)">Hoje
                        </li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 1 }" @click="setDateRange(1)">Amanhã
                        </li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 2 }" @click="setDateRange(2)">Esta
                            Semana</li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 3 }" @click="setDateRange(3)">Próxima
                            Semana</li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 4 }" @click="setDateRange(4)">Este Mês
                        </li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 5 }" @click="setDateRange(5)">Próximo
                            Mês</li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 6 }" @click="setDateRange(6)">Este Ano
                        </li>
                        <li class="px-5 py-2 hover:bg-gray-100 cursor-pointer"
                            :class="{ 'bg-gray-200': dashboard_date['option'] == 7 }" @click="setDateRange(7)">Próximo
                            Ano</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 overflow-auto">
                <!-- Orçamentos do cliente -->
                <table class="w-full m-auto table-auto truncate">
                    <thead class="lg:border-b-2 lg:border-gray-500">
                        <th>Cliente</th>
                        <th>Cerimômia</th>
                        <th>Valor total</th>
                        <th>Valor Pago</th>
                        <th>Valor restante</th>
                        <th>Gasto total</th>
                        <th>Lucro estimado</th>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in      budgets     " :key="item.id" class="cursor-pointer"
                            :class="{ 'bg-gray-100': index % 2 == 0 }">
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        item.client_name
                                    }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        item.event_name
                                    }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        toMonetary(item.total_negociado + item.total_adicionado) }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        toMonetary(item.valor_pago)
                                    }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        toMonetary(item.total_negociado + item.total_adicionado - item.valor_pago)
                                    }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        toMonetary(item.total_gastos)
                                    }}</a></td>
                            <td class="py-3 px-5 truncate text-center"><a :href="route('budgets.show', item.id)"
                                    target="_blank">{{
                                        toMonetary(item.total_negociado + item.total_adicionado - item.total_gastos)
                                    }}</a></td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="!budgets.length" class="w-full text-center py-5 text-lg">
                    <p>Não há orçamentos ativos no momento</p>
                </div>
            </div>

        </section>
    </AppLayout>
</template>
