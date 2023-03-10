<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { PlusIcon, UserIcon, PhoneIcon, InboxIcon } from '@heroicons/vue/24/solid';
import ModalCreateBudget from '@/Components/Client/Modals/ModalCreateBudget.vue';

const props = defineProps({
    client: Object,
    client_budgets: Object,
    budget_selects_options: Object,
    budget_id: Number,
})

const client_form = useForm({
    id: props.client.id,
    name: props.client.name,
    contact: props.client.contact,
    email: props.client.email,
    active: props.client.active,
});

const modal_budget_create_open = ref(false);

const formatDate = (date) => {
    date = date.split(/\-|\ |\:/);
    return date[2] + "/" + date[1] + "/" + date[0] + " às " + date[3] + ":" + date[4];
}

</script>
<template>
    <section
        class="w-11/12 m-auto px-5 md:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white select-none overflow-hidden">
        <div class="w-full flex-col-config md:flex-row-config divide-y-2 md:divide-y-0 md:divide-x-2 border-b-2">
            <!-- Nome -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-10 py-0 md:py-10 hover:bg-indigo-50">
                <UserIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                <input type="text" placeholder="Nome do Cliente"
                    class="w-full sm:text-md border-none text-center group-hover:bg-indigo-50" v-model="client_form.name" />
                <div v-if="client_form.errors.name" class="text-xs text-red-600 ml-3">{{ client_form.errors.name }}</div>
            </div>

            <!-- Contato -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-10 py-0 md:py-10 hover:bg-indigo-50">
                <a :href="'tel:' + client_form.contact">
                    <PhoneIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                </a>
                <input type="tel" placeholder="Whatsapp"
                    class="w-full sm:text-md border-none text-center  group-hover:bg-indigo-50"
                    v-model="client_form.contact" @keydown="teste($event)" minlength="8" maxlength="20" />
                <div v-if="client_form.errors.contact" class="text-xs text-red-600 ml-3">{{ client_form.errors.contact }}
                </div>
            </div>

            <!-- E-mail -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-10 py-0 md:py-10 hover:bg-indigo-50">
                <a :href="'mailto:' + client_form.email">
                    <InboxIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                </a>
                <input type="email" placeholder="E-mail"
                    class="w-full sm:text-md border-none text-center group-hover:bg-indigo-50"
                    v-model="client_form.email" />
                <div v-if="client_form.errors.email" class="text-xs text-red-600 ml-3">{{ client_form.errors.email }}</div>
            </div>
        </div>

        <div class="my-5">
            <!-- Orçamentos do cliente -->
            <table v-if="client_budgets.length" class="w-full m-auto table-fixed">
                <thead>
                    <tr class="bg-indigo-900 text-white">
                        <th class="py-3">Evento</th>
                        <th class="py-3">Qtd. Convidados</th>
                        <th class="py-3">Data</th>
                        <th class="py-3">Ver detalhes</th>
                        <th class="py-3">Abrir orçamento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(budget, index) in client_budgets" :key="budget.id"
                        class="bg-white text-center border-b-2 hover:bg-indigo-50">
                        <td
                            class="py-3 text-center border border-r-slate-300 xl:border-none truncate flex-row-config space-x-5">
                            <span v-if="budget.id == budget_id" class="w-2 h-2 rounded-full bg-sky-500"></span>
                            <span>{{ budget.event_name }}</span>
                        </td>
                        <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate">{{
                            budget.guests_quantity }} convidados</td>
                        <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate">{{
                            formatDate(budget.event_date) }}</td>
                        <td class="py-3 text-center border border-r-slate-300 xl:border-none truncate"><a
                                class="text-indigo-500 hover:text-indigo-900 active:text-indigo-700"
                                :href="route('budgets.show', budget.id)">Ver detalhes</a></td>
                        <td class="py-3 text-center truncate">
                            <a v-if="budget.link" class="text-sky-500 hover:text-sky-900 active:text-sky-700"
                                :href="budget.link">Ver mais</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="w-full text-center">{{ client.name }} não possui(em) orçamentos cadastrados!</div>
        </div>
        <div class="w-full mb-10 text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle"
            @click="modal_budget_create_open = true">
            <PlusIcon class="w-5 h-5" />
            <span>Cadastrar novo orçamento</span>
        </div>

        <ModalCreateBudget v-if="modal_budget_create_open" :client_id="client.id"
            :budget_selects_options="budget_selects_options" @modal_open="(open) => modal_budget_create_open = open" />

        <main>
            <slot />
        </main>
    </section>
</template>