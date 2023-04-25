<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    clients: Object,
    budgets: Object,
    ceremonies: Object,
});

const valor_total = ref(0);
const valor_recebido = ref(0);
const valor_a_receber = ref(0);
const gastos_mensais = ref(0);
const gastos_cerimonias = ref(0);
const lucro = ref(0);

const registros = ref([{
    cliente: null,
    creimonia: null,
    valor_total: 0,
    valor_pago: 0,
    valor_restante: 0,
    gasto_total: 0,
    lucro: 0,
}]);


const toMonetary = (value) => {
    if (value !== null) return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}
</script>

<template>
    <AppLayout title="Calculadora de Buffet" :activated_page='-50'>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 m-5">
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Valor total</p>
                    <p>{{ toMonetary(valor_total) }}</p>
                </div>
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Valor recebido</p>
                    {{ toMonetary(valor_recebido) }}
                </div>
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Valor a receber</p>
                    {{ toMonetary(valor_a_receber) }}
                </div>
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Custos Mensais</p>
                    {{ toMonetary(gastos_mensais) }}
                </div>
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Custos das cerimônias</p>
                    {{ toMonetary(gastos_cerimonias) }}
                </div>
                <div class="w-full bg-gray-200 rounded-md py-5 flex flex-col align-middle items-center text-2xl">
                    <p>Lucro estimado</p>
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
                        <tr v-for="item in registros">
                            <td class="py-3 px-5 truncate">{{ item.cliente }}</td>
                            <td class="py-3 px-5 truncate">{{ item.cerimonia }}</td>
                            <td class="py-3 px-5 truncate">{{ item.valor_total }}</td>
                            <td class="py-3 px-5 truncate">{{ item.valor_pago }}</td>
                            <td class="py-3 px-5 truncate">{{ item.valor_restante }}</td>
                            <td class="py-3 px-5 truncate">{{ item.gasto_total }}</td>
                            <td class="py-3 px-5 truncate">{{ item.lucro }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
    </AppLayout>
</template>
