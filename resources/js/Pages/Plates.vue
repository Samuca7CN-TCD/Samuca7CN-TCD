<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PlateList from '@/Components/BuffetCalculator/Plate/PlateList.vue';
defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    buffet: Object,
    plate_list: Object,
});
</script>
<template>
    <AppLayout title="Plate" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pratos
            </h2>
        </template>
        <PlateList :activated_page="activated_page" :buffet="buffet" :plate_list="plate_list" />
    </AppLayout>
</template>