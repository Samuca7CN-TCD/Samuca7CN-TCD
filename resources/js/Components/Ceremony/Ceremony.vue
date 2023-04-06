<script setup>
import { ref } from 'vue';
const props = defineProps({
    ceremony: Object,
    budget: Object,
});

const emit = defineEmits(['financial']);

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

const calcProgress = (total, restante) => {
    if (total > 0) return 1 - (restante / total);
    else return -1;
}

const progress = ref(calcProgress(props.ceremony.total_negotiated_amount, (props.ceremony.total_negotiated_amount - props.ceremony.paid_amount)));

const goToFinancial = (mode) => {
    emit('financial', mode);
}

</script>
<template>
    <p class="text-white">
    <div class="w-full bg-gray-900 flex-col-config space-y-5 lg:space-y-0 lg:flex-row-config text-white py-5 px-5 lg:px-10">
        <div class="w-full lg:w-1/2 flex-col-config space-y-5">
            <p class="text-5xl font-bold">{{ toMonetary(ceremony.total_negotiated_amount) }}</p>
            <a v-if="budget.status == 2"
                class="rounded-xl px-3 py-1 text-white bg-gray-700 hover:bg-gray-800 active:bg-gray-700 cursor-pointer select-none"
                @click="goToFinancial(1)">Editar
                Pagamento</a>
            <a v-if="budget.status == 1"
                class="rounded-xl px-3 py-1 text-white bg-gray-700 hover:bg-gray-800 active:bg-gray-700 cursor-pointer select-none"
                @click="goToFinancial(2)">Pagar</a>
        </div>
        <div class="w-full lg:w-1/2 flex flex-col">
            <div class="space-y-3 text-lg font-mono">
                <p>Restante: {{ toMonetary(ceremony.total_negotiated_amount - ceremony.paid_amount) }}</p>
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
    </p>
</template>