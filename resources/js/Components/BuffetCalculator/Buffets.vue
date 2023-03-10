<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { XMarkIcon, ArrowRightIcon, PlusIcon, DocumentDuplicateIcon } from '@heroicons/vue/24/outline';
import ModalCreateBuffet from './Modals/ModalCreateBuffet.vue';

const props = defineProps({
    buffet_list: Object,
});

const form_buffet_entry = useForm({
    name: null,
    description: null,
    price: 0.0,
});

const form_buffet = useForm({
    name: null,
    description: null,
    price: 0.0,
});

const create_modal_type = ref('main');
const create_modal_open = ref(false);

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

const removeBuffet = (id, type) => {
    if (type == 'entry') {
        router.delete(route('buffet-entries.destroy', id), {
            preserveScroll: true,
        });
    } else if (type == 'buffet') {
        router.delete(route('buffets.destroy', id), {
            preserveScroll: true,
        });
    }
}

const openCreateModal = (type) => {
    create_modal_type.value = type;
    create_modal_open.value = true;
}

</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <h2 class="mt-5 mx-10 text-xl text-slate-700">
            Entradas
            <span class="inline-block text-xs" @click="openCreateModal('entry')">
                <p class="text-md text-indigo-500 hover:text-indigo-900 active:text-indigo-700 cursor-pointer">Adicionar</p>
            </span>
        </h2>
        <div class="flex-col-config">
            <div v-if="!buffet_list.entries">Não há entradas cadastradas no momento</div>
            <div v-for="entry in buffet_list.entries"
                class="w-11/12 m-auto my-2 flex-col-config md:flex-row-config rounded-xl border-2 border-indigo-200 p-2 hover:shadow-xl">
                <div class="w-full md:w-8/12 xl:w-10/12 flex flex-col space-y-1">
                    <!-- Nome -->
                    <div class="w-full">
                        <input type="text" placeholder="Nome"
                            class="w-full border-none focus:outline-0 sm:text-lg text-indigo-700" :value="entry.name" />
                    </div>
                    <span class="ml-3 text-md text-slate-600">{{ toMonetary(entry.price) }}</span>
                    <!-- Descrição -->
                    <div class="w-full">
                        <textarea placeholder="Descrição" class="w-full border-none focus:outline-0 sm:text-xs"
                            :value="entry.description"></textarea>
                    </div>
                </div>
                <div class="w-full md:w-4/12 lg:w-2/12 flex-row-config space-x-5">
                    <DocumentDuplicateIcon
                        class="w-6 h-6 text-slate-700 hover:text-indigo-500 active:text-indigo-800 cursor-pointer"
                        @click="duplicateBuffet(entry.id, 'entry')" />
                    <XMarkIcon class="w-6 h-6 text-slate-700 hover:text-red-500 active:text-red-800 cursor-pointer"
                        @click="removeBuffet(entry.id, 'entry')" />
                    <a :href="route('buffet-calculator.sub-itens', [entry.id, 'plates', 'buffet_entry'])">
                        <ArrowRightIcon
                            class="w-6 h-6 text-slate-700 hover:text-sky-500 active:text-sky-800 cursor-pointer" />
                    </a>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mx-10 text-xl text-slate-700">
            Buffets
            <span class="inline-block text-xs" @click="openCreateModal('main')">
                <p class="text-md text-indigo-500 hover:text-indigo-900 active:text-indigo-700 cursor-pointer">Adicionar</p>
            </span>
        </h2>
        <div class="flex-col-config">
            <div v-if="!buffet_list.buffets">Não há buffets cadastrados no momento</div>
            <div v-for="buffet in buffet_list.buffets"
                class="w-11/12 m-auto my-2 flex-col-config md:flex-row-config rounded-xl border-2 border-indigo-200 p-2 hover:shadow-xl">
                <div class="w-full md:w-8/12 xl:w-10/12 flex flex-col space-y-1">
                    <!-- Nome -->
                    <div class="w-full">
                        <input type="text" placeholder="Nome"
                            class="w-full border-none focus:outline-0 sm:text-lg text-indigo-700" :value="buffet.name" />
                    </div>
                    <span class=" inline-block ml-3 text-md text-slate-600">{{ toMonetary(buffet.price) }}</span>
                    <!-- Descrição -->
                    <div class="w-full">
                        <textarea placeholder="Descrição" class="w-full border-none focus:outline-0 sm:text-xs"
                            :value="buffet.description" rows="7"></textarea>
                    </div>
                </div>
                <div class="w-full md:w-4/12 lg:w-2/12 flex-row-config space-x-5">
                    <DocumentDuplicateIcon
                        class="w-6 h-6 text-slate-700 hover:text-indigo-500 active:text-indigo-800 cursor-pointer"
                        @click="duplicateBuffet(buffet.id, 'buffet')" />
                    <XMarkIcon class="w-6 h-6 text-slate-700 hover:text-red-500 active:text-red-800 cursor-pointer"
                        @click="removeBuffet(buffet.id, 'buffet')" />
                    <a :href="route('buffet-calculator.sub-itens', [buffet.id, 'plates', 'buffet'])">
                        <ArrowRightIcon
                            class="w-6 h-6 text-slate-700 hover:text-sky-500 active:text-sky-800 cursor-pointer" />
                    </a>
                </div>
            </div>
        </div>
    </section>
    <ModalCreateBuffet v-if="create_modal_open" :buffet_type="create_modal_type"
        @modal_open="(open) => create_modal_open = open" />
</template>