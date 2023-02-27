<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Today from '@/Components/TasksToday.vue';
import Soon from '@/Components/TasksSoon.vue';
import Tags from '@/Components/TasksTags.vue';
import Filters from '@/Components/TasksFilters.vue';

defineProps({
    activated_page: String,
    page_options: Object,
    task_list: Object,
});
</script>

<template>
    <AppLayout title="Dashboard" :page_options='page_options' :activated_page='activated_page'>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas
            </h2>
        </template>

        <Today v-if="activated_page == 'today'" :task_list="task_list" />
        <Soon v-if="activated_page == 'soon'" />
        <Tags v-if="activated_page == 'tags'" />
        <Filters v-if="activated_page == 'filters'" />
    </AppLayout>
</template>
