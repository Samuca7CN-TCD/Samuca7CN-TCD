<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskList from '@/Components/Task/TaskList.vue';
import Tags from '@/Components/Task/Tags.vue';

const props = defineProps({
    activated_page: Number,
    page_url_base: String,
    submenu: Object,
    task_list: Object,
    task_form_selects: Object,
    tags: Object,
});

const active = (option) => {
    return {
        'task_list': (!props.activated_page || props.activated_page == 1),
        'tags': (props.activated_page == 2),
    }[option]
}
</script>

<template>
    <AppLayout title="Dashboard" :submenu='submenu' :activated_page='activated_page' :page_url_base="page_url_base">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas - {{
                    active('task_list')
                    ? 'Lista de tarefas'
                    : 'Gerenciador de Tags'
                }}
            </h2>
        </template>
        <TaskList v-if="active('task_list')" :task_list="task_list" :task_form_selects="task_form_selects">
        </TaskList>
        <Tags v-if="active('tags')" :tags="tags" />
    </AppLayout>
</template>
