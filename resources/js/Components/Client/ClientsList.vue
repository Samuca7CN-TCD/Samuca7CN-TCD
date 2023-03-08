<script setup>
import { ref } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import { useForm } from 'in'
defineProps({
    clients_list: Object,
})
const form = useForm({

});
const modal_create_open = ref(false);

const closeModal = () => {
    modal_create_open.value = false;
}
</script>
<template>
    <section class="w-11/12 m-auto px-5 sm:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white py-10 select-none">
        <table v-if="clients_list.length" class="w-full table-auto">
            <thead>
                <tr class="bg-slate-300">
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients_list" :key="client.id" class="bg-white"
                    :class="{ 'bg-slate-200': client.id % 2 }">
                    <td>{{ client.name }}</td>
                    <td>{{ client.contact }}</td>
                    <td>{{ client.email }}</td>
                    <td>
                        <a :href="route('clients', client.id)">Ver mais</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="w-full text-center">Não há clientes cadastrados!</div>
    </section>

    <button type="buttom"
        class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
        @click="modal_create_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>

    <Modal :show="modal_create_open">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-blue-100 p-2 rounded-full text-blue-400">
                    <PlusIcon class="w-5 h-5" />
                </span>
                <h2 class="text-2xl bold">Cadastrar Tarefa</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3">Formulário para cadastro de uma nova tarefa</p>
        </div>
        <form id="create_task" @submit.prevent="submit" class="w-full">

            <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                <div class="w-full m-0 p-0">
                    <!-- Nome -->
                    <div class="w-full">
                        <input type="text" name="task_title" id="task-title" autocomplete="off" placeholder="Título"
                            class="w-full border-none focus:outline-0 sm:text-md" v-model="form.title" />
                        <div v-if="form.errors.title" class="text-xs text-red-600 ml-3">{{ form.errors.title }}</div>
                    </div>
                </div>
                <div class="w-full px-4 py-3 space-x-2 text-right sm:px-6">
                    <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Cadastrar
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>