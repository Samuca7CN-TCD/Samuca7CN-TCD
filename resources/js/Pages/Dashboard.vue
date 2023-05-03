<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toMonetary } from '..//Components/shared_functions.js';

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

const registros = ref([{
    cliente: null,
    cerimonia: null,
    valor_total: 0,
    valor_pago: 0,
    valor_restante: 0,
    gasto_total: 0,
    lucro: 0,
}]);



</script>

<template>
    <AppLayout title="Dashboard" :activated_page='-50'>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
            <div class="pt-7 px-5">
                <h2 class="text-2xl">Valor total:
                    <span>{{ toMonetary(valor_total) }}</span>
                </h2>
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
                    <p>Lucro total estimado</p>
                    {{ toMonetary(lucro) }}
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
