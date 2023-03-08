<script setup>
import SubNavLink from '@/Components/SubNavLink.vue';
defineProps({
    submenu: Object,
    page_url_base: String,
    activated_page: Number,
})
</script>
<template>
    <SubNavLink v-for="(option, index) in submenu" :href="'/' + page_url_base + '/' + option.id"
        :active="(option.id == activated_page) || (!index && !activated_page)">
        <li>
            <span class="inline-block mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 md:w-4 md:h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" :d="option.icon" />
                </svg>
            </span>
            <span class="hidden md:inline-block">{{ option.name }}</span>
        </li>
    </SubNavLink>
</template>