<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/core';
import { toMonetary, formatDate } from '/resources/js/shared_functions.js';

const props = defineProps({
    ceremony: Object,
    budget: Object,
    button_type: Number,
});

const calcProgress = (total, restante) => {
    if (total > 0) return 1 - (restante / total);
    else return -1;
}

const progress = ref(calcProgress(props.ceremony.total_negotiated_amount + props.ceremony.total_additions, ((props.ceremony.total_negotiated_amount + props.ceremony.total_additions) - props.ceremony.paid_amount)));
</script>
<template>
    <div
        class="w-full bg-stone-900 flex-col-config space-y-5 lg:space-y-0 lg:flex-row-config text-white py-5 px-5 lg:px-10">
        <div class="w-full lg:w-1/2 flex-col-config space-y-5">
            <div class="flex-col-config">
                <p class="text-5xl font-thin">{{ toMonetary(ceremony.total_negotiated_amount +
                    ceremony.total_additions) }}
                </p>
                <p class="text-xs">Valor do orçamento: {{ toMonetary(budget.budget_total_value) }}</p>
            </div>
            <a v-if="button_type == 0 && budget.status == 2" :href="route('financials.show', budget.id)"
                class="rounded-xl px-3 py-1 text-white bg-stone-700 hover:bg-stone-800 active:bg-stone-700 cursor-pointer select-none">Editar
                Pagamento</a>
            <a v-if="button_type == 0 && budget.status == 1" :href="route('financials.show', budget.id)"
                class="rounded-xl px-3 py-1 text-white bg-stone-700 hover:bg-stone-800 active:bg-stone-700 cursor-pointer select-none">Pagar</a>
            <a v-if="button_type == 0 && budget.status > 2" :href="route('financials.show', budget.id)"
                class="rounded-xl px-3 py-1 text-white bg-stone-700 hover:bg-stone-800 active:bg-stone-700 cursor-pointer select-none">Ver
                Pagamentos</a>
            <a v-if="button_type == 1" :href="route('budgets.show', budget.id)"
                class="rounded-xl px-3 py-1 text-white bg-stone-700 hover:bg-stone-800 active:bg-stone-700 cursor-pointer select-none">Ver
                orçamento</a>
        </div>
        <div class="w-full lg:w-1/2 flex flex-col">
            <div class="space-y-3 text-lg font-mono">
                <p>Restante: {{ toMonetary((ceremony.total_negotiated_amount + ceremony.total_additions) -
                    ceremony.paid_amount) }}</p>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 overflow-hidden" :title="(progress * 100) + '%'">
                    <div class="bg-gray-700 h-1.5" :class="{
                        'w-0': progress < 0.0833,
                        'w-1/12': progress >= 0.0833 && progress < 0.1667,
                        'w-2/12': progress >= 0.1667 && progress < 0.2500,
                        'w-3/12': progress >= 0.2500 && progress < 0.3333,
                        'w-4/12': progress >= 0.3333 && progress < 0.4167,
                        'w-5/12': progress >= 0.4167 && progress < 0.5000,
                        'w-6/12': progress >= 0.5000 && progress < 0.5833,
                        'w-7/12': progress >= 0.5833 && progress < 0.6667,
                        'w-8/12': progress >= 0.6667 && progress < 0.7500,
                        'w-9/12': progress >= 0.7500 && progress < 0.8333,
                        'w-10/12': progress >= 0.8333 && progress < 0.9167,
                        'w-11/12': progress >= 0.9167 && progress < 1.0000,
                        'w-full bg-green-500': progress >= 1.0000,
                    }"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full h-[3px]" :class="{
        'bg-gray-700': budget.status == 0,
        'bg-green-700': budget.status == 1,
        'bg-yellow-700': budget.status == 2,
        'bg-red-700': budget.status == 3,
        'bg-blue-700': budget.status == 4,
    }
        ">
    </div>
</template>