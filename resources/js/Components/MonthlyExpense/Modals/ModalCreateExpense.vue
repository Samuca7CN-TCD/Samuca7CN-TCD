<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, router } from '@inertiajs/vue3';

const emit = defineEmits(['modal_open']);

const props = defineProps({
    expense_record: Object,
});

const form = useForm({
    name: null,
    amount: 0,
});


const closeModal = () => {
    form.reset();
    form.clearErrors();
    emit('modal_open', false);
}

const submit = () => {
    if (props.expense_record) {
        let er = props.expense_record;
        let last_record = JSON.parse(er.last_record);
        last_record.push({
            "id": last_record[last_record.length - 1].id + 1,
            "name": form.name,
            "amount": form.amount,
            "deleted_at": null,
            "created_at": (new Date()).toLocaleString('pt-BR', { timezone: 'UTC' }),
            "updated_at": (new Date()).toLocaleString('pt-BR', { timezone: 'UTC' })
        })
        er.last_record = JSON.stringify(last_record);
        router.put(route('monthly_expenses.update_record', props.expense_record.id), er, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('monthly_expenses.store'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        })
    }
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
                        <input type="text" name="expense_name" id="expense-name" autocomplete="off"
                            placeholder="Nome do Gasto" class="w-full border-none focus:outline-0 sm:text-md"
                            v-model="form.name" />
                        <div v-if="form.errors.name" class="text-xs text-red-600 ml-3">{{ form.errors.name }}</div>
                    </div>

                    <!--Custo-->
                    <div class="full">
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"> <span
                                    class="text-gray-500 sm:text-sm">R$</span></div>
                            <input type="number" step="0.01" min="0.00" name="expense_amount" id="expense_amount"
                                class="w-full border-none focus:outline-0 sm:text-m pl-10" placeholder="Custo"
                                v-model="form.amount">
                            <div v-if="form.errors.amount" class="text-xs text-red-600 ml-3">{{
                                form.errors.amount }}
                            </div>
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