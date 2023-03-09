<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['modal_open']);

const form = useForm({
    name: null,
    contact: null,
    email: null,
    active: true,
});

const closeModal = () => {
    form.reset();
    form.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    form.post(route('clients.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })
}
</script>
<template>
    <Modal :show="true">
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
                <div class="w-full m-0 p-0 space-y-2">
                    <!-- Nome -->
                    <div class="w-full">
                        <input type="text" name="client_name" id="client-name" autocomplete="off"
                            placeholder="Nome do Cliente" class="w-full border-none focus:outline-0 sm:text-md"
                            v-model="form.name" />
                        <div v-if="form.errors.name" class="text-xs text-red-600 ml-3">{{ form.errors.name }}</div>
                    </div>

                    <!-- Contato -->
                    <div class="w-full">
                        <input type="tel" name="client_contact" id="client-contact" autocomplete="off"
                            placeholder="Whatsapp" class="w-full border-none focus:outline-0 sm:text-md"
                            v-model="form.contact" minlength="8" maxlength="20" />
                        <div v-if="form.errors.contact" class="text-xs text-red-600 ml-3">{{ form.errors.contact }}</div>
                    </div>

                    <!-- E-mail -->
                    <div class="w-full">
                        <input type="email" name="client_email" id="client-email" autocomplete="off" placeholder="E-mail"
                            class="w-full border-none focus:outline-0 sm:text-md" v-model="form.email" />
                        <div v-if="form.errors.email" class="text-xs text-red-600 ml-3">{{ form.errors.email }}</div>
                    </div>

                    <div class="w-full">
                        <div>
                            <input
                                class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-ml-[0.4rem] after:-mt-[0.2461rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[4px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                type="checkbox" role="switch" name="client_status" id="client-status" v-model="form.active"
                                :checked="form.active" />
                            <label class="inline-block pl-[0.15rem] hover:cursor-pointer text-slate-800"
                                for="client-status">Cliente
                                Ativo</label>
                        </div>
                    </div>
                </div>
                <div class="w-full px-4 py-3 space-x-2 text-right sm:px-6 mt-5">
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