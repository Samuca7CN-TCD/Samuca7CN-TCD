<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BuffetList from '@/Components/BuffetCalculator/Buffet/BuffetList.vue';
defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    buffet_list: Object,
});
</script>
<template>
    <AppLayout title="Buffet" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buffets {{ activated_page == 0 ? ' - Lista de Buffet' : ' - Lista de Entradas' }}
            </h2>
        </template>
        <BuffetList :activated_page="activated_page" :buffet_list="buffet_list" />
    </AppLayout>
</template>