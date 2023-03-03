<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Today from '@/Components/Task/Today.vue';
import Soon from '@/Components/Task/Soon.vue';
import Tags from '@/Components/Task/Tags.vue';
import Filters from '@/Components/Task/Filters.vue';

defineProps({
    activated_page: Number,
    page_url_base: String,
    submenu: Object,
    task_list: Object,
    task_form_selects: Object,
});
</script>

<template>
    <AppLayout title="Dashboard" :submenu='submenu' :activated_page='activated_page' :page_url_base="page_url_base">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas
            </h2>
        </template>
        <Today v-if="!activated_page || activated_page == 1" :task_list="task_list" :task_form_selects="task_form_selects">
        </Today>
        <Soon v-if="activated_page == 2" />
        <Tags v-if="activated_page == 3" />
        <Filters v-if="activated_page == 4" />
    </AppLayout>
</template>
