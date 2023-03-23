<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Calculator from '@/Components/BuffetCalculator/Calculator.vue';
import Buffets from '@/Components/BuffetCalculator/Buffet/Buffets.vue';
import Plates from '@/Components/BuffetCalculator/Plate/Plates.vue';
import Ingredients from '@/Components/BuffetCalculator/Ingredient/Ingredients.vue';

defineProps({
    activated_page: Number,
    submenu_category: String,
    submenu: Object,
    buffet_list: Object,
    buffet: Object,
    plate: Object,
    content_type: String,
    content_buffet_type: String,
    content_list: Object,
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
        <Calculator v-if="activated_page == 0" />
        <Buffets v-if="activated_page != 0" :buffet_list="buffet_list" />
        <Plates v-if="activated_page != 0" :buffet="buffet" :content_buffet_type="content_buffet_type"
            :content_list="content_list" />
        <Ingredients v-if="activated_page != 0" :plate="plate" :content_list="content_list" />
    </AppLayout>
</template>
