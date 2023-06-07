<script setup>

import { router } from '@inertiajs/vue3';

const props = defineProps({
    budget: Object,
    ceremony: Object,
    has_installment: Boolean,
});

const cycleCerimony = (budget_id, option) => {
    router.post(route('ceremonies.cycle', [budget_id, option], {
        preserveScroll: true,
    }));
}
</script>

<template>
    <div class="flex flex-row space-x-5 justify-end">
        <button v-if="budget.status == 0" class="bg-yellow-600 text-white py-3 px-5 rounded-lg"
            @click="cycleCerimony(budget.id, 0)">
            Criar Cerimônia
        </button>
        <button v-if="budget.status == 2 && has_installment" class="bg-green-600 text-white py-3 px-5 rounded-lg"
            @click="cycleCerimony(budget.id, 1)">
            Ativar Cerimônia
        </button>
        <button v-if="budget.status == 1 && ceremony.status == 1" class="bg-blue-600 text-white py-3 px-5 rounded-lg"
            @click="cycleCerimony(budget.id, 4)">
            Concluir Cerimônia
        </button>
        <button v-if="budget.status == 1 || budget.status == 2" class="bg-red-600 text-white py-3 px-5 rounded-lg"
            @click="cycleCerimony(budget.id, 2)">
            Cancelar Cerimônia
        </button>
        <button v-if="budget.status == 3" class="bg-gray-600 text-white py-3 px-5 rounded-lg"
            @click="cycleCerimony(budget.id, 3)">
            Duplicar Cerimônia
        </button>
    </div>
</template>