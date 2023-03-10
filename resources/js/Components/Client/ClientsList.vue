<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import ModalCreateClient from '@/Components/Client/Modals/ModalCreateClient.vue';
defineProps({
    clients_list: Object,
})

const modal_create_open = ref(false);

const toggleClientActive = (client) => {
    const form_toggle_active = useForm({
        name: client.name,
        contact: client.contact,
        email: client.email,
        active: !client.active,
    });
    form_toggle_active.put(route('clients.update', client.id), { preserveScroll: true });
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <table v-if="clients_list.length" class="w-full m-auto table-fixed">
            <thead>
                <tr class="bg-indigo-900 text-white">
                    <th class="py-3">Ativo</th>
                    <th class="py-3">Nome</th>
                    <th class="py-3">Contato</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients_list" :key="client.id"
                    class="bg-white text-center border-b-2 hover:bg-indigo-50">
                    <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate">
                        <div>
                            <input
                                class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-ml-[0.4rem] after:-mt-[0.2461rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-indigo-700 checked:after:absolute checked:after:z-[2] checked:after:-mt-[4px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-indigo-700 checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-indigo-700 checked:focus:bg-indigo-700 checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                type="checkbox" role="switch" name="client_table_status" id="client-table-status"
                                :checked="client.active" @input="toggleClientActive(client)" />
                        </div>
                    </td>
                    <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate">{{ client.name }}</td>
                    <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate"><a
                            :href="'tel:' + client.contact">{{
                                client.contact }}</a></td>
                    <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate"><a
                            :href="'mailto:' + client.email">{{ client.email }}</a></td>
                    <td class="py-3 text-center truncate">
                        <a class="text-indigo-500 hover:text-indigo-900 active:text-indigo-700"
                            :href="route('clients.show', client.id)">Ver mais</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="w-full text-center my-10">Não há clientes cadastrados!</div>
    </section>

    <button type="buttom"
        class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
        @click="modal_create_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>

    <ModalCreateClient v-if="modal_create_open" @modal_open="(open) => modal_create_open = open" />
</template>