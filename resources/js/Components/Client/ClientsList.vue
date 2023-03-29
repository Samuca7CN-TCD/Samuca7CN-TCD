<script setup>
import { ref } from 'vue';
import { PlusIcon, EyeIcon } from '@heroicons/vue/24/solid';
import { router, useForm } from '@inertiajs/vue3';
import ModalCreateClient from '@/Components/Client/Modals/ModalCreateClient.vue';

const props = defineProps({
    clients_list: Object,
});

const modal_create_open = ref(false);
const clients = ref(props.clients_list);
const filterInput = ref('');

const toggleClientActive = (client) => {
    const form_toggle_active = useForm({
        name: client.name,
        contact: client.contact,
        email: client.email,
        active: !client.active,
    });
    form_toggle_active.put(route('clients.update', client.id), {
        preserveScroll: true,
        onSuccess: () => filterClients(),
    });
}

const closeModal = (open) => {
    modal_create_open.value = open;
    filterClients();
}

const filterClients = () => {
    if (!filterInput.value.length) {
        clients.value = props.clients_list;
    } else {
        props.clients_list.filter((client) => client.name.toLowerCase().indexOf(filterInput.value.toLowerCase()) > -1);
    }
}

const clearFilter = () => {
    filterInput.value = "";
    filterClients();
}

const formatDate = (date) => {
    date = date.split(/\-|\T|\:/);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

const goToClient = (client_id) => {
    router.get(route('clients.show', client_id));
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div v-if="clients_list.length" class="my-5">
            <input class="w-full border-none outline-0" placeholder="Pesquise o nome do cliente" id="searchClient"
                type="text" v-model="filterInput" @keyup="filterClients()" />
            <span v-if="filterInput.length"
                class="text-ms text-gray-500 px-5 hover:text-gray-900 active:text-gray-700 cursor-pointer"
                @click="clearFilter()">Limpar filtro</span>
        </div>
        <div v-if="clients_list.length" class="w-full overflow-auto">
            <table class="w-full m-auto table-fixed overflow-auto">
                <thead class="lg:border-b-2 lg:border-gray-500">
                    <!--<th>Status</th>-->
                    <th>Ativo</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Email</th>
                    <th>Data de cadastro</th>
                    <!--<th>Duplicar</th>-->
                </thead>
                <tbody>
                    <tr v-for="(client, index) in clients" :key="client.id"
                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                        :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + client.name">
                        <!--<td @click="toggleBuffetStatus(buffet)"><div v-if="buffet.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="buffet_table_status" id="buffet-table-status" :checked="buffet.status" /></div><span v-else class="text-orange-600">Pendente</span></td>-->

                        <td class="py-3 px-5 truncate">
                            <input
                                class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-ml-[0.4rem] after:-mt-[0.2461rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-indigo-700 checked:after:absolute checked:after:z-[2] checked:after:-mt-[4px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-indigo-700 checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-indigo-700 checked:focus:bg-indigo-700 checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                type="checkbox" role="switch" name="client_table_status" id="client-table-status"
                                :checked="client.active" @input="toggleClientActive(client)" />
                        </td>
                        <td class="py-3 px-5 truncate" @click="goToClient(client.id)">{{ client.name }}
                        </td>
                        <td class="py-3 px-5 truncate" @click="goToClient(client.id)"><a :href="'tel:' + client.contact"
                                :target="'_blank'">{{
                                    client.contact }}</a></td>
                        <td class="py-3 px-5 truncate" @click="goToClient(client.id)"><a :href="'mailto:' + client.email"
                                :target="'_blank'">{{
                                    client.email }}</a></td>
                        <td class="py-3 px-5 truncate" @click="goToClient(client.id)">{{ formatDate(client.created_at) }}
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="w-full text-center my-10">Não há clientes cadastrados!</div>
    </section>

    <button type="buttom"
        class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
        @click="modal_create_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>

    <ModalCreateClient v-if="modal_create_open" @modal_open="(open) => closeModal(open)" />
</template>