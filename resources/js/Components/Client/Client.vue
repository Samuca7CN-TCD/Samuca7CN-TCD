<script setup>
import { useForm } from '@inertiajs/vue3';
import { PlusIcon, UserIcon, PhoneIcon, InboxIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    client: Object,
    client_budgets: Object,
    budget_selects_options: Object,
})

const client_form = useForm({
    id: props.client.id,
    name: props.client.name,
    contact: props.client.contact,
    email: props.client.email,
    active: props.client.active,
});

</script>
<template>
    <section
        class="w-11/12 m-auto px-5 sm:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full flex-col-config lg:flex-row-config divide-x-2 border-b-2">
            <!-- Nome -->
            <div class="group w-full lg:w-1/3 flex-row-config lg:flex-col-config py-10 space-y-5 hover:bg-indigo-50">
                <UserIcon class="w-3 h-3 lg:w-10 lg:h-10 text-indigo-700" />
                <input type="text" placeholder="Nome do Cliente"
                    class="w-full sm:text-md border-none text-center  group-hover:bg-indigo-50"
                    v-model="client_form.name" />
                <div v-if="client_form.errors.name" class="text-xs text-red-600 ml-3">{{ client_form.errors.name }}</div>
            </div>

            <!-- Contato -->
            <div class="group w-full lg:w-1/3 flex-row-config lg:flex-col-config py-10 space-y-5 hover:bg-indigo-50">
                <a :href="'tel:' + client_form.contact">
                    <PhoneIcon class=" w-3 h-3 lg:w-10 lg:h-10 text-indigo-700" />
                </a>
                <input type="tel" placeholder="Whatsapp"
                    class="w-full sm:text-md border-none text-center  group-hover:bg-indigo-50"
                    v-model="client_form.contact" @keydown="teste($event)" minlength="8" maxlength="20" />
                <div v-if="client_form.errors.contact" class="text-xs text-red-600 ml-3">{{ client_form.errors.contact }}
                </div>
            </div>

            <!-- E-mail -->
            <div class="group w-full lg:w-1/3 flex-row-config lg:flex-col-config py-10 space-y-5 hover:bg-indigo-50">
                <a :href="'mailto:' + client_form.email">
                    <InboxIcon class=" w-3 h-3 lg:w-10 lg:h-10 text-indigo-700" />
                </a>
                <input type="email" placeholder="E-mail"
                    class="w-full sm:text-md border-none text-center group-hover:bg-indigo-50"
                    v-model="client_form.email" />
                <div v-if="client_form.errors.email" class="text-xs text-red-600 ml-3">{{ client_form.errors.email }}</div>
            </div>
        </div>

        <div class="my-5 p-5">
            <!-- Orçamentos do cliente -->
            <table v-if="client_budgets.length" class="w-full m-auto table-auto">
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
                    <tr v-for="client, index in clients_list" :key="client.id"
                        class="bg-white text-center border-b-2 hover:bg-indigo-50">
                        <td class="py-3">
                            <div>
                                <input
                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-ml-[0.4rem] after:-mt-[0.2461rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transclient_form_0.2s] after:content-[''] checked:bg-indigo-700 checked:after:absolute checked:after:z-[2] checked:after:-mt-[4px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-indigo-700 checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transclient_form_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transclient_form_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-indigo-700 checked:focus:bg-indigo-700 checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transclient_form_0.2s]"
                                    type="checkbox" role="switch" name="client_table_status" id="client-table-status"
                                    :checked="client.active" @input="toggleClientActive(client)" />
                            </div>
                        </td>
                        <td class="py-3">{{ client.name }}</td>
                        <td class="py-3"><a :href="'tel:' + client.contact">{{ client.contact }}</a></td>
                        <td class="py-3"><a :href="'mailto:' + client.email">{{ client.email }}</a></td>
                        <td class="py-3">
                            <a class="text-indigo-500 hover:text-indigo-900 active:text-indigo-700"
                                :href="route('clients.show', client.id)">Ver mais</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="w-full text-center">{{ client.name }} não possui(em) orçamentos cadastrados!</div>
        </div>
        <div class="w-full text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle"
            @click="modal_budget_create_open = true">
            <PlusIcon class="w-5 h-5" />
            <span>Cadastrar novo orçamento</span>
        </div>

    </section>
</template>