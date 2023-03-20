<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskList from '@/Components/Task/TaskList.vue';
import Tags from '@/Components/Task/Tags.vue';

const props = defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    task_list: Object,
    task_form_selects: Object,
    tags: Object,
});

</script>

<template>
    <AppLayout title="Tarefas" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas -
                <span v-if="activated_page == 'tasks'" class="inline-flex">Tarefas</span>
                <span v-if="activated_page == 'tags'" class="inline-flex">Tags</span>
            </h2>
        </template>
        <TaskList v-if="activated_page == 'tasks'" :task_list="task_list" :task_form_selects="task_form_selects">
        </TaskList>
        <Tags v-if="activated_page == 'tags'" :tags="tags" />
    </AppLayout>
</template >
