<script setup>
import { onMounted, ref } from 'vue';
import { MinusSmallIcon, PlusIcon, ExclamationTriangleIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import TaskForm from '@/Components/TaskForm.vue';

const months = ref(['Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);
const days = ref(['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'])
const today = ref(new Date());

const task_form_switch = ref(false);
const task_input_values = ref(null);

// setInterval(function () { console.log(task_input_values.value) }, 5000);

const props = defineProps({
    task_list: Object,
});

const checkTaskList = () => {
    if (props.task_list.length) return false;
    return true;
}

</script>
<template>
    <section class="w-11/12 m-auto rounded-xl shadow-2xl min-h-[525px] divide-y-2 mt-10 bg-white py-10">
        <!-- Informações do Dia -->
        <div class="w-full sm:w-10/12 m-auto">
            <div class="flex flex-row text-gray-500 text-sm">
                {{ today.getDate().toString().padStart(2, '0') }} {{ months[today.getMonth()] }}
                <MinusSmallIcon class="h-5 w-5" />
                Hoje
                <MinusSmallIcon class="h-5 w-5" />
                {{ days[today.getDay()] }}
            </div>
        </div>

        <!-- Não há tarefas -->
        <div v-if="checkTaskList" class="w-full flex-row-config sm:w-10/12 m-auto p-5">
            <p class="text-gray-600">Não há tarefas registradas no momento!</p>
        </div>

        <!-- Item da Lista de Tarefas -->
        <div class="w-full flex-row-config sm:w-10/12 m-auto p-1">
            <div class="w-1/12 flex-col-config">
                <div
                    class="w-6 h-6 rounded-xl bg-gray-300 flex-col-config group hover:border-gray-400 hover:border-2 cursor-pointer">
                    <CheckIcon class="w-3 h-3 hidden group-hover:block text-gray-400" />
                </div>
            </div>
            <div class="w-11/12 space-y-1">
                <p class="text-md">Título</p>
                <p class="text-sm">Descrição</p>
                <span class="space-x-5 text-xs flex flex-row items-start justify-left">
                    <span>19:00</span>
                    <span>1 Comment</span>
                    <span>Etiqueta</span>
                </span>
            </div>
        </div>

        <!-- Adcionar Tarefa -->
        <div v-if="!task_form_switch" class="w-full flex-row-config sm:w-10/12 m-auto p-1 hover:text-red-600 cursor-pointer"
            @click="task_form_switch = !task_form_switch">
            <div class="w-1/12 flex-col-config">
                <PlusIcon class="w-5 h-5" />
            </div>
            <div class="w-11/12">
                <p class="text-xs">Adicionar Tarefa</p>
            </div>
        </div>
        <div v-if="task_form_switch" class="w-full flex-col-config sm:w-10/12 m-auto">
            <TaskForm :show_form="task_form_switch" @response="(form_inputs) => task_input_values = form_inputs"
                @show_form="(show_f) => task_form_switch = show_f" />
        </div>
    </section>
</template>