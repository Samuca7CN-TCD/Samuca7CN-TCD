<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Calculator from '@/Components/BuffetCalculator/Calculator.vue';
import Buffets from '@/Components/BuffetCalculator/Buffet/BuffetList.vue';
import Plates from '@/Components/BuffetCalculator/Plate/PlateList.vue';
import Ingredients from '@/Components/BuffetCalculator/Ingredient/Ingredients.vue';

defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    buffet_list: Object,
    options: Object,
    entry_plates: Object,
    buffet_plates: Object,
})
</script>

<template>
    <AppLayout title="Calculadora de Buffet" :submenu='submenu' :activated_page='activated_page'
        :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calculadora de Buffet
            </h2>
        </template>
        <Calculator v-if="activated_page == 0" :buffet_list="buffet_list" :options="options" :entry_plates="entry_plates"
            :buffet_plates="buffet_plates" />
    </AppLayout>
</template>
