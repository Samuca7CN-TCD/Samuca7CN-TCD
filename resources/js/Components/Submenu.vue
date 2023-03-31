<script setup>
import { ref } from 'vue';
import { UserIcon, CalendarIcon, TagIcon, ListBulletIcon } from '@heroicons/vue/24/solid';
import SubNavLink from '@/Components/SubNavLink.vue';
defineProps({
    submenu: Object,
    submenu_category: String,
    activated_page: Number,
});

const months = ref([
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
]);
</script>
<template>
    <!--Clients-->
    <ul v-if="submenu_category == 'clients'" class="w-full px-10">
        <SubNavLink v-for="client in submenu" :href="route('clients.show', client.id)"
            :active="activated_page == client.id">
            <li class=" li_submenu">
                <UserIcon class="w-6 h-6" />
                <span>{{ client.name }}</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Budgets-->
    <ul v-if="submenu_category == 'budgets'" class="w-full px-10">
        <SubNavLink v-for="record in submenu" :href="route('budgets.show', record.id)"
            :active="activated_page == record.id">
            <li class="li_submenu" :title="'Data do evento: ' + record.event_date">
                <UserIcon class="w-6 h-6" />
                <span>{{ record.event_name }}</span>
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

    <!--Buffet Calculator-->
    <ul v-if="submenu_category == 'buffet_calculator'" class="w-full px-10">
        <SubNavLink :href="route('buffets.index')">
            <li class="li_submenu">
                <CalendarIcon class="w-6 h-6" />
                <span>Ver lista de buffets</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Buffet-->
    <ul v-if="submenu_category == 'buffets'" class="w-full px-10">
        <SubNavLink :href="route('buffets.index', 1)" :active="activated_page == 0">
            <li class="li_submenu">
                <ListBulletIcon class="w-6 h-6" />
                <span>Buffets</span>
            </li>
        </SubNavLink>
        <SubNavLink :href="route('buffets.index', 2)" :active="activated_page == 1">
            <li class="li_submenu">
                <ListBulletIcon class="w-6 h-6" />
                <span>Entradas</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Plates-->
    <ul v-if="submenu_category == 'plates'" class="w-full px-10">
        <SubNavLink v-for="buffet in submenu" :href="route('plates.index', buffet.id)"
            :active="activated_page == buffet.id">
            <li class="li_submenu">
                <UserIcon class="w-6 h-6" />
                <span>{{ buffet.name }}</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Ingredients-->
    <ul v-if="submenu_category == 'ingredients'" class="w-full px-10">
        <SubNavLink v-for="plate in submenu" :href="route('ingredients.index', plate.id)"
            :active="activated_page == plate.id">
            <li class="li_submenu">
                <UserIcon class="w-6 h-6" />
                <span>{{ plate.name }}</span>
            </li>
        </SubNavLink>
    </ul>

    <!--Monthly Expenses-->
    <ul v-if="submenu_category == 'monthly_expenses'" class="w-full px-10">
        <SubNavLink v-for="record in submenu" :href="route('monthly_expenses.show', record.id)"
            :active="activated_page == record.id">
            <li class="li_submenu">
                <UserIcon class="w-6 h-6" />
                <span>{{ months[record.month - 1] + ' / ' + record.year }}</span>
            </li>
        </SubNavLink>
    </ul>
</template>