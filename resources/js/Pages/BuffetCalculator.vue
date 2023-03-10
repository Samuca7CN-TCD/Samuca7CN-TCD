<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Buffets from '@/Components/BuffetCalculator/Buffets.vue';
import Plates from '@/Components/BuffetCalculator/Plates.vue';
import Ingredients from '@/Components/BuffetCalculator/Ingredients.vue';

defineProps({
    activated_page: Number,
    page_url_base: String,
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
        :page_url_base="page_url_base">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calculadora de Buffet
            </h2>
        </template>
        <Buffets v-if="buffet_list && !content_type" :buffet_list="buffet_list" />
        <Plates v-if="content_type == 'plates'" :buffet="buffet" :content_buffet_type="content_buffet_type"
            :content_list="content_list" />
        <Ingredients v-if="content_type == 'ingredients'" :plate="plate" :content_list="content_list" />
    </AppLayout>
</template>
