<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { PlusIcon, UserIcon, PhoneIcon, InboxIcon, SparklesIcon, EyeIcon, XCircleIcon } from '@heroicons/vue/24/solid';
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

const submit = () => {
    client_form.put(route('clients.update', client_form.id), {
        preserveScroll: true,
    })
}

</script>
<template>
    <section class="w-11/12 m-auto px-5 md:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white overflow-hidden">
        <div class="w-full flex-col-config md:flex-row-config divide-y-2 md:divide-y-0 md:divide-x-2 border-b-2">
            <!-- Nome -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-2 py-0 md:py-2 hover:bg-indigo-50">
                <UserIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                <input type="text" placeholder="Nome do Cliente"
                    class="w-full sm:text-md border-none text-center group-hover:bg-indigo-50" v-model="client_form.name"
                    @input="submit" />
                <div v-if="client_form.errors.name" class="text-xs text-red-600 ml-3">{{ client_form.errors.name }}</div>
            </div>

            <!-- Contato -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-2 py-0 md:py-2 hover:bg-indigo-50">
                <a :href="'tel:' + client_form.contact">
                    <PhoneIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                </a>
                <input type="tel" placeholder="Whatsapp"
                    class="w-full sm:text-md border-none text-center  group-hover:bg-indigo-50"
                    v-model="client_form.contact" minlength="8" maxlength="20" @input="submit" />
                <div v-if="client_form.errors.contact" class="text-xs text-red-600 ml-3">{{ client_form.errors.contact }}
                </div>
            </div>

            <!-- E-mail -->
            <div
                class="group w-full md:w-1/3 flex-row-config space-x-2 md:flex-col-config md:space-x-0 md:space-y-2 py-0 md:py-2 hover:bg-indigo-50">
                <a :href="'mailto:' + client_form.email">
                    <InboxIcon class="w-5 h-5 md:w-10 md:h-10 text-indigo-700" />
                </a>
                <input type="email" placeholder="E-mail"
                    class="w-full sm:text-md border-none text-center group-hover:bg-indigo-50" v-model="client_form.email"
                    @input="submit" />
                <div v-if="client_form.errors.email" class="text-xs text-red-600 ml-3">{{ client_form.errors.email }}</div>
            </div>
        </div>
        <div v-if="client_budgets.length" class="mt-10 overflow-auto">
            <!-- Orçamentos do cliente -->
            <table class="w-full m-auto table-auto truncate">
                <thead class="lg:border-b-2 lg:border-gray-500">
                    <th>Status</th>
                    <th>Evento</th>
                    <th>Convidados</th> 
                    <th>Data</th>
                </thead>
                <tbody>
                    <tr v-for="(budget, index) in client_budgets" :key="budget.id"
                        class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 text-center"
                        :class="{ 'bg-gray-100': (index % 2 != 0) }">
                        <td class="py-3 px-5">
                            {{ budget.ceremony_status }}
                            <SparklesIcon class="w-6 h-6 text-center" :class="{
                                'text-green-500': budget.ceremony_status == 'Ativo',
                                'text-red-500': budget.ceremony_status == 'Concluído'
                            }" />
                        </td>
                        <td class="py-3 px-5 truncate">
                            {{ budget.event_name }}
                        </td>
                        <td class="py-3 px-5 truncate">{{ budget.guests_quantity }} convidados</td>
                        <td class="py-3 px-5 truncate">{{ formatDate(budget.event_date) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="w-full text-center my-5">{{ client.name }} não possui(em) orçamentos cadastrados!</div>
        <div class="w-full py-3 mb-10 text-sky-500 hover:text-sky-900 active:text-sky-700 cursor-pointer flex-row-config space-x-2 align-middle select-none"
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