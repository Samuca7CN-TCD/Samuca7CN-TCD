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

const closeModal = (open) => {
    modal_create_open.value = open;
    filterClients();
}

const filterClients = () => {
    if (!filterInput.value.length) {
        clients.value = props.clients_list;
    } else {
        clients.value = props.clients_list.filter((client) => client.name.toLowerCase().indexOf(filterInput.value.toLowerCase()) > -1);
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
                    <th title="O cliente só é ativo se houver pelo menos uma cerimônia ativa">Ativo</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Email</th>
                    <th>Data de cadastro</th>
                    <!--<th>Duplicar</th>-->
                </thead>
                <tbody>
                    <tr v-for="(client, index) in clients" :key="client.id"
                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                        :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + client.name"
                        @click="goToClient(client.id)">
                        <!--<td @click="toggleBuffetStatus(buffet)"><div v-if="buffet.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="buffet_table_status" id="buffet-table-status" :checked="buffet.status" /></div><span v-else class="text-orange-600">Pendente</span></td>-->

                        <td class="py-3 px-5 truncate flex flex-col items-center align-middle"
                            title="O cliente só é ativo se houver pelo menos uma cerimônia ativa">
                            <div class="w-3 h-3 rounded-full"
                                :class="{ 'bg-green-700': client.active, 'bg-red-700': !client.active, }">
                            </div>
                        </td>
                        <td class="py-3 px-5 truncate">{{ client.name }}
                        </td>
                        <td class="py-3 px-5 truncate"><a :href="'tel:' + client.contact" :target="'_blank'">{{
                            client.contact }}</a></td>
                        <td class="py-3 px-5 truncate"><a :href="'mailto:' + client.email" :target="'_blank'">{{
                            client.email }}</a></td>
                        <td class="py-3 px-5 truncate">{{ formatDate(client.created_at) }}
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