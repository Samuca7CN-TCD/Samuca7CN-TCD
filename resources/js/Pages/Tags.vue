<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskList from '@/Components/Task/TaskList.vue';
import Tags from '@/Components/Task/Tags.vue';

const props = defineProps({
    activated_page: Number,
    submenu: Object,
    submenu_category: String,
    tags: Object,
});

</script>

<template>
    <AppLayout title="Tarefas" :submenu='submenu' :activated_page='activated_page' :submenu_category="submenu_category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas -
                <span class="inline-flex">Tags</span>
            </h2>
        </template>
        <Tags :tags="tags" />
    </AppLayout>
</template >
