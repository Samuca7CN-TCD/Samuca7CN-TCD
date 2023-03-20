<script setup>
import { UserIcon, CalendarIcon, TagIcon } from '@heroicons/vue/24/solid';
import SubNavLink from '@/Components/SubNavLink.vue';
defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,
});
</script>
<template>
    <!--Clients-->
    <ul v-if="submenu_category == 'clients'" class="w-full px-10">
        <SubNavLink v-for="client in submenu" :href="route('clients.show', client.id)"
            :active="activated_page == client.id">
            <li class="li_submenu">
                <UserIcon class="w-6 h-6" />
                <span>{{ client.name }}</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Tasks-->
    <ul v-if="submenu_category == 'tasks'" class="w-full px-10">
        <SubNavLink :href="route('tasks.index')" :active="activated_page == 0">
            <li class="li_submenu">
                <CalendarIcon class="w-6 h-6" />
                <span>Tarefas</span>
            </li>
        </SubNavLink>
        <SubNavLink :href="route('tags.index')" :active="activated_page == 1">
            <li class="li_submenu">
                <TagIcon class="w-6 h-6" />
                <span>Tags</span>
            </li>
        </SubNavLink>
    </ul>
</template>