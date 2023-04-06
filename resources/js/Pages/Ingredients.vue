<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Ingredients from '@/Components/BuffetCalculator/Ingredient/Ingredients.vue';
defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    plate: Object,
    ingredient_list: Object,
});
</script>
<template>
    <AppLayout title="Ingredient" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ingredientes
            </h2>
        </template>
        <Ingredients :activated_page="activated_page" :plate="plate" :ingredient_list="ingredient_list" />
    </AppLayout>
</template>