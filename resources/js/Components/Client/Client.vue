<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UserIcon, PhoneIcon, InboxIcon, PaperClipIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    client: Object,
});

const client_form = useForm({
    id: props.client.id,
    name: props.client.name,
    contact: props.client.contact,
    email: props.client.email,
    active: props.client.active,
});

const submit = () => {
    client_form.put(route('clients.update', client_form.id), {
        preserveScroll: true,
    })
}

</script>
<template>
    <section class="w-11/12 m-auto px-5 md:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white overflow-hidden">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Informações do(s) cliente(s)</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Nome e dados de contato</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status do cliente</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <div class="w-fit rounded-full text-white py-1 px-5"
                                :class="{ 'bg-green-700': client.active, 'bg-red-700': !client.active, }"
                                title="O cliente só é ativo se houver pelo menos uma cerimônia ativa">
                                {{ client_form.active ? 'Ativo' : 'Inativo' }}
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nome</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ client_form.name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Número de celular</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ client_form.contact }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Endereço de e-mail</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ client_form.email }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <main>
            <slot />
        </main>
    </section>
</template>