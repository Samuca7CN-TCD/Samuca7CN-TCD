<script setup>
import { onMounted, ref } from 'vue';
import { MinusSmallIcon, PlusIcon, ExclamationTriangleIcon, CheckIcon, XMarkIcon, TagIcon, PencilSquareIcon, TrashIcon, DocumentDuplicateIcon } from '@heroicons/vue/24/outline';
import Modal from '@/Components/Modal.vue';
import TaskForm from '@/Components/Task/Form.vue';

const months = ref(['Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);
const days = ref(['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'])

const task_input_values = ref(null);
const modal_open = ref(false);
const modal_title = ref('Cadastrar Tarefa');
const modal_description = ref('Formulário para cadastro de uma nova tarefa');

// setInterval(function () { console.log(task_input_values.value) }, 5000);

const props = defineProps({
    task_list: Object,
    task_form_selects: Object,
});

const newDate = (date) => {
    return new Date(date.replace(' ', 'T'));
}

const formatDate = (date) => {
    date = date.split(/\-|\ |\:/);
    return date[2] + " de " + months.value[date[1] - 1] + " de " + date[0] + " às " + date[3] + ":" + date[4];
}

</script>
<template>
    <section class="w-11/12 m-auto rounded-xl shadow-2xl min-h-[525px] mt-10 bg-white py-10">
        <div v-if="!task_list.length" class="flex-col-config text-gray-700">
            Não há tarefas cadastradas até o momento!
        </div>
        <div v-for="(task_group, index) in task_list" :key="index" class="w-full divide-y-2 mb-10">
            <!-- Informações do Dia -->
            <div class="w-full sm:w-10/12 m-auto">
                <div class="flex flex-row text-gray-500 text-sm">
                    {{ newDate(index).getDate().toString().padStart(2, '0') }} {{
                        months[newDate(index).getMonth()] }}
                    <MinusSmallIcon class="h-5 w-5" />
                    {{ days[newDate(index).getDay()] }}
                </div>
            </div>

            <!-- Item da Lista de Tarefas -->
            <div v-for="task in task_group" :key="task.id" class="w-full flex flex-row sm:w-10/12 m-auto p-1 group">
                <div class="w-1/12 flex flex-col justify-start items-center mt-2">
                    <div
                        class="w-6 h-6 flex-col-config group rounded-xl bg-indigo-100 hover:bg-indigo-200 border-2 border-indigo-300 hover:border-indigo-400 cursor-pointer">
                        <CheckIcon class="w-3 h-3 hidden group-hover:block text-indigo-400" />
                    </div>
                </div>
                <div class="w-11/12 space-y-1">
                    <p class="text-md">{{ task.title }}</p>
                    <p v-if="task.description" class="text-sm">{{ task.description }}</p>
                    <span class="space-x-5 text-xs">
                        <!--<span>{{ formatDate(task.deadline) }}</span>-->
                        <span>1 Comment</span>
                        <span class="relative right-0 h-1 w-fit"><input type="datetime-local"
                                class="rounded-full border-none outline-none" /></span>
                    </span>
                    <span v-if="(JSON.parse(task.tags)).length" class="w-full flex flex-row space-x-2 py-2 overflow-auto">
                        <div v-for="tag in JSON.parse(task.tags)"
                            class="border-2 bg-indigo-700 text-white px-1 py-1 rounded-xl text-xs flex-row-config space-x-1">
                            <TagIcon class="w-3 h-3" />
                            <span>{{ tag.name }}</span>
                            <XMarkIcon class="w-3 h-3 cursor-pointer select-none" @click="removeTag(tag.id)" />
                        </div>
                    </span>
                </div>
                <div
                    class="h-7 invisible group-hover:visible relative top-0 right-0 bg-gradient-to-l from-gray-100 to-white rounded-full py-1 px-5">
                    <div class="flex-row-config space-x-3 text-black-200">
                        <span title="Editar">
                            <PencilSquareIcon
                                class="w-5 h-5 text-gray-500 hover:text-gray-700 active:text-gray-900 cursor-pointer" />
                        </span>
                        <span title="Duplicar">
                            <DocumentDuplicateIcon
                                class="w-5 h-5 text-gray-500 hover:text-gray-700 active:text-gray-900 cursor-pointer" />
                        </span>
                        <span title="Excluir">
                            <TrashIcon
                                class="w-5 h-5 text-gray-500 hover:text-gray-700 active:text-gray-900 cursor-pointer" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <button type="buttom"
        class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
        @click="modal_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>
    <Modal :show="modal_open">
        <div class="mt-5 mx-5">
            <div class="flex flex-row align-middle items-center space-x-2">
                <span class="bg-blue-100 p-2 rounded-full text-blue-400">
                    <PlusIcon class="w-5 h-5" />
                </span>
                <h2 class="text-2xl bold">{{ modal_title }}</h2>
            </div>
            <p class="text-xm text-gray-500 mt-3"> {{ modal_description }} </p>
        </div>
        <TaskForm :task_form_selects="task_form_selects" :logged_user="$page.props.user"
            @response="(form_inputs) => task_input_values = form_inputs" @modal_open="(close) => modal_open = close" />
    </Modal>
</template>