<script setup>
import { ref } from 'vue';
import { XMarkIcon, MinusSmallIcon, PlusIcon, CheckIcon, TagIcon, PencilSquareIcon, TrashIcon, DocumentDuplicateIcon } from '@heroicons/vue/24/outline';
import CreateModal from '@/Components/Task/CreateModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { router, useForm } from '@inertiajs/vue3'

// Variávels default
const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
const today = ref(new Date());
const today_min = ref(today.value.getFullYear() + '-' + dateZeroFiller(today.value.getMonth() + 1) + '-' + dateZeroFiller(today.value.getDate()) + 'T' + dateZeroFiller(today.value.getHours()) + ':' + dateZeroFiller(today.value.getMinutes()));
today.value = today.value.getFullYear() + '-' + dateZeroFiller((today.value.getMonth() + 1)) + '-' + dateZeroFiller(today.value.getDate()) + 'T23:59';

const months = ref(['Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']);
const days = ref(['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'])

const props = defineProps({
    task_list: Object,
    task_form_selects: Object,
});

const modal_create_open = ref(false);

// Variáveis para edição de dados
const modal_update_open = ref(false);
const form_update = useForm('UpdateTask', {
    id: 1,
    title: null,
    description: null,
    deadline: '0000-00-00 00:00:00',
    priority: 4,
    tags: 0,
    ceremony_id: null,
    user_id: 1,
    task_status_id: 1,
});

const tags_controller = ref({
    tags_options: {},
    selected_tags: {},
});

const showEditTask = (task) => {
    form_update.id = task.id;
    form_update.title = task.title;
    form_update.description = task.description;
    form_update.deadline = task.deadline.substring(0, task.deadline.length - 3);
    form_update.priority = task.priority;

    tags_controller.value.selected_tags = JSON.parse(task.tags);
    loadTagOptions();

    form_update.tags = 0;
    form_update.ceremony_id = task.ceremony_id;
    form_update.user_id = task.user_id;
    form_update.task_status_id = task.task_status_id;

    modal_update_open.value = true;
}

const loggedUser = (id) => {
    return id == 1 ? true : false;
}

// Variáveis do campo 'Etiqueta'
const appendTag = (e) => {
    let tag = tags_controller.value.tags_options.filter((tag) => tag.id == e.target.value)[0];
    tags_controller.value.selected_tags.push({
        'id': e.target.value,
        'color': tag.color,
        'name': tag.name,
    });
    loadTagOptions();
    form_update.tags = 0;
    submit();
}

const removeTag = (tag_id) => {
    tags_controller.value.selected_tags = tags_controller.value.selected_tags.filter((tag) => tag.id != tag_id);
    loadTagOptions();
    submit();
}

const loadTagOptions = () => {
    tags_controller.value.tags_options = props.task_form_selects.tags.filter(function (tag) {
        return tags_controller.value.selected_tags.filter((s_tag) => s_tag.id == tag.id).length == 0;
    });
}

// Controle de formulário de edição

const submit = () => {
    form_update.tags = JSON.stringify(tags_controller.value.selected_tags);
    form_update.deadline = form_update.deadline.replace('T', ' ') + ':59';

    form_update.put(route('tasks.update', form_update.id), {
        preserveScroll: true,
    });

    form_update.deadline = form_update.deadline.replace(' ', 'T').substring(0, form_update.deadline.length - 3);
    form_update.tags = 0;
}

const closeModal = (show) => {
    form_update.clearErrors();
    form_update.reset();
    tags_controller.value.selected_tags = [{}];
    loadTagOptions();
    modal_update_open.value = show;
}

// Variáveis complementares
const newDate = (date) => {
    return new Date(date.replace(' ', 'T'));
}

const formatDate = (date) => {
    date = date.split(/\-|\ |\:/);
    return date[2] + " de " + months.value[date[1] - 1] + " de " + date[0] + " às " + date[3] + ":" + date[4];
}

const checkLate = (date) => {
    date = newDate(date);
    return date < new Date() ? true : false;
}

// Variáveis para manipulação de tarefas

const doneTask = (task_id) => {
    router.patch('tasks/done/' + task_id, {}, {
        preserveScroll: true,
    });
}

const duplicateTask = (task_id) => {
    router.post(route('task.duplicate'), { id: task_id }, {
        preserveScroll: true,
    });
}

const removeTask = (task_id, task_title) => {
    if (confirm('Você tem certeza que deseja remover "' + task_title + '"?')) {
        router.delete('tasks/' + task_id, {}, {
            preserveScroll: true,
        });
    }
}

</script>
<template>
    <section class="w-11/12 m-auto px-5 sm:px-0 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white py-10 select-none">
        <div v-if="!Object.keys(task_list).length" class="flex-col-config text-gray-700">
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
                    <MinusSmallIcon class="h-5 w-5" />
                    {{ newDate(index).getFullYear() }}
                </div>
            </div>

            <!-- Item da Lista de Tarefas -->
            <div v-for="task in task_group" :key="task.id" class="w-full flex flex-row sm:w-10/12 m-auto py-2 group">
                <div class="w-4/12 md:w-1/12 flex flex-col justify-start items-center mt-2">
                    <div class="w-6 h-6 flex-col-config group rounded-xl cursor-pointer" :class="{
                        'bg-red-100 hover:bg-red-200 border-2 border-red-300 hover:border-red-400': task.priority == 1,
                        'bg-orange-100 hover:bg-orange-200 border-2 border-orange-300 hover:border-orange-400': task.priority == 2,
                        'bg-blue-100 hover:bg-blue-200 border-2 border-blue-300 hover:border-blue-400': task.priority == 3,
                        'bg-gray-100 hover:bg-gray-200 border-2 border-gray-300 hover:border-gray-400': task.priority == 4
                    }" title="Marcar como feito" @click="doneTask(task.id)">
                        <CheckIcon class="w-3 h-3 hidden group-hover:block" :class="{
                            'text-red-400': task.priority == 1,
                            'text-orange-400': task.priority == 2,
                            'text-blue-400': task.priority == 3,
                            'text-gray-400': task.priority == 4
                        }" />
                    </div>
                </div>
                <div class="w-11/12 space-y-1">
                    <p class="text-lg">{{ task.title }}</p>
                    <p v-if="task.description" class="text-sm text-gray-500">{{ task.description }}</p>
                    <span class="space-x-5 text-xs w-full">
                        <span>{{ formatDate(task.deadline) }}</span>
                        <span v-if="task.event_name != null"
                            class="cursor-pointer text-xs text-gray-500 hover:text-gray-700 active:text-gray-900"
                            title="Verificar cerimônia">
                            {{ task.event_name }} de {{ task.client_name }}
                        </span>
                        <span class="text-xs text-indigo-600">@{{
                            task.user_username
                        }}</span>
                        <span v-if="checkLate(task.deadline)" class="text-red-500">Atrasada</span>
                    </span>
                    <span v-if="(JSON.parse(task.tags)).length" class="w-full flex flex-row space-x-2 overflow-auto">
                        <div v-for="tag in JSON.parse(task.tags)"
                            class="border-2 text-white px-2 py-0 rounded-xl text-xs flex-row-config space-x-1" :class="{
                                'bg-rose-700': tag.color == 'rose',
                                'bg-pink-700': tag.color == 'pink',
                                'bg-fuchsia-700': tag.color == 'fuchsia',
                                'bg-purple-700': tag.color == 'purple',
                                'bg-violet-700': tag.color == 'violet',
                                'bg-indigo-700': tag.color == 'indigo',
                                'bg-blue-700': tag.color == 'blue',
                                'bg-sky-700': tag.color == 'sky',
                                'bg-cyan-700': tag.color == 'cyan',
                                'bg-teal-700': tag.color == 'teal',
                                'bg-emerald-700': tag.color == 'emerald',
                                'bg-green-700': tag.color == 'green',
                                'bg-lime-700': tag.color == 'lime',
                                'bg-yellow-700': tag.color == 'yellow',
                                'bg-amber-700': tag.color == 'amber',
                                'bg-orange-700': tag.color == 'orange',
                                'bg-red-700': tag.color == 'red',
                                'bg-stone-700': tag.color == 'stone',
                                'bg-neutral-700': tag.color == 'neutral',
                                'bg-zinc-700': tag.color == 'zinc',
                                'bg-gray-700': tag.color == 'gray',
                                'bg-slate-700': tag.color == 'slate',
                                'bg-black': tag.color == 'black',
                            }">
                            <TagIcon class="w-3 h-3" />
                            <span>{{ tag.name }}</span>
                        </div>
                    </span>
                </div>
                <div
                    class="h-7 invisible group-hover:visible relative top-0 right-0 bg-gradient-to-l from-gray-100 to-white rounded-full py-1 px-5">
                    <div class="flex-row-config space-x-3 text-black-200">
                        <span title="Editar" @click="showEditTask(task)">
                            <PencilSquareIcon
                                class="w-5 h-5 text-gray-500 hover:text-gray-700 active:text-gray-900 cursor-pointer" />
                        </span>
                        <span title="Duplicar" @click="duplicateTask(task.id)">
                            <DocumentDuplicateIcon
                                class="w-5 h-5 text-gray-500 hover:text-gray-700 active:text-gray-900 cursor-pointer" />
                        </span>
                        <span title="Excluir" @click="removeTask(task.id, task.title)">
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
        @click="modal_create_open = true">
        <PlusIcon class="w-5 h-5" />
    </button>
    <CreateModal :show="modal_create_open" :task_form_selects="task_form_selects" :logged_user="$page.props.user"
        @modal_open="(show) => modal_create_open = show" />

    <Modal :show="modal_update_open" :maxWidth="'4xl'">
        <form @submit.prevent="submit" class="w-full select-none">
            <div class="flex-row-config w-full">
                <div class="flex flex-col w-3/5 h-96 p-5">

                    <div class="flex flex-row align-middle items-center space-x-2">
                        <span class="bg-yellow-100 p-2 rounded-full text-yellow-400">
                            <PencilSquareIcon class="w-5 h-5" />
                        </span>
                        <input type="text" v-model="form_update.title" class="w-full border-none text-2xl m-1"
                            @input="submit()" />
                    </div>

                    <textarea v-model="form_update.description" placeholder="Insira uma descrição para a tarefa"
                        class="w-full border-gray-300 text-sm text-gray-500" rows="10" @input="submit()"></textarea>

                    <!-- Etiquetas Selecionadas -->
                    <div v-if="tags_controller.selected_tags.length"
                        class="w-full flex flex-row space-x-2 py-2 overflow-auto">
                        <div v-for="selected_tag in tags_controller.selected_tags"
                            class="border-2 text-white px-2 py-1 rounded-xl text-xs flex-row-config space-x-1" :class="{
                                'bg-rose-700': selected_tag.color == 'rose',
                                'bg-pink-700': selected_tag.color == 'pink',
                                'bg-fuchsia-700': selected_tag.color == 'fuchsia',
                                'bg-purple-700': selected_tag.color == 'purple',
                                'bg-violet-700': selected_tag.color == 'violet',
                                'bg-indigo-700': selected_tag.color == 'indigo',
                                'bg-blue-700': selected_tag.color == 'blue',
                                'bg-sky-700': selected_tag.color == 'sky',
                                'bg-cyan-700': selected_tag.color == 'cyan',
                                'bg-teal-700': selected_tag.color == 'teal',
                                'bg-emerald-700': selected_tag.color == 'emerald',
                                'bg-green-700': selected_tag.color == 'green',
                                'bg-lime-700': selected_tag.color == 'lime',
                                'bg-yellow-700': selected_tag.color == 'yellow',
                                'bg-amber-700': selected_tag.color == 'amber',
                                'bg-orange-700': selected_tag.color == 'orange',
                                'bg-red-700': selected_tag.color == 'red',
                                'bg-stone-700': selected_tag.color == 'stone',
                                'bg-neutral-700': selected_tag.color == 'neutral',
                                'bg-zinc-700': selected_tag.color == 'zinc',
                                'bg-gray-700': selected_tag.color == 'gray',
                                'bg-slate-700': selected_tag.color == 'slate',
                                'bg-black': selected_tag.color == 'black',
                            }">
                            <TagIcon class="w-4 h-4" />
                            <span>{{ selected_tag.name }}</span>
                            <XMarkIcon class="w-4 h-4 cursor-pointer" @click="removeTag(selected_tag.id)" />
                        </div>
                        <div v-if="form_update.errors.tags" class="text-xs text-red-600 ml-3">{{ form_update.errors.tags }}
                        </div>
                    </div>

                </div>
                <div class="flex flex-col w-2/5 h-96 bg-gray-700 p-5">
                    <ul class="space-y-3">
                        <li>
                            <!-- Data -->
                            <div class="my-2">
                                <label for="task-date-time" class="sr-only text-white">Prazo</label>
                                <input type="datetime-local" name="task_date_time" id="task-date-time" autocomplete="off"
                                    class="w-full outline-0 border-none sm:text-xs text-white bg-gray-700"
                                    v-model="form_update.deadline" :min="today_min" @input="submit('deadline')" />
                                <div v-if="form_update.errors.deadline" class="text-xs text-red-600 ml-3">{{
                                    form_update.errors.deadline
                                }}</div>
                            </div>
                        </li>
                        <!-- Prioridade -->
                        <div class="min-w-fit">
                            <select id="task-priority" name="task_priority" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs bg-gray-700" :class="{
                                    'text-red-500': form_update.priority == 1,
                                    'text-orange-500': form_update.priority == 2,
                                    'text-blue-500': form_update.priority == 3,
                                    'text-gray-500': form_update.priority == 4
                                }" v-model="form_update.priority" @change="submit()">
                                <option v-for="i in 4" :class="{
                                    'text-red-500': i == 1,
                                    'text-orange-500': i == 2,
                                    'text-blue-500': i == 3,
                                    'text-gray-500': i == 4
                                }" :value="i" :selected="form_update.priority == i">Prioridade {{ i }}
                                </option>
                            </select>
                            <div v-if="form_update.errors.priority" class="text-xs text-red-600 ml-3">{{
                                form_update.errors.priority }}
                            </div>
                        </div>

                        <!-- Etiquetas -->
                        <div class="min-w-fit" v-if="task_form_selects.tags.length">
                            <select id="task-tag" name="task_tag" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs text-white bg-gray-700"
                                v-model="form_update.tags" @input="appendTag">
                                <option value="0" selected="selected">Etiquetas</option>
                                <option v-for="tag in tags_controller.tags_options" :value="tag.id" class="text-white">
                                    {{ tag.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Cerimônia -->
                        <div class="min-w-fit" v-if="task_form_selects.ceremonies.length">
                            <select id="task-ceremony" name="task_ceremony" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs text-white bg-gray-700"
                                v-model="form_update.ceremony_id" @change="submit()">
                                <option value="null" selected="selected">Nenhuma cerimônia</option>
                                <option v-for="(ceremony, index) in task_form_selects.ceremonies" :value="ceremony.id"
                                    :selected="form_update.ceremony_id == ceremony.id">{{
                                        ceremony.event_name }} de {{ ceremony.client_name }}</option>
                            </select>
                            <div v-if="form_update.errors.ceremony_id" class="text-xs text-red-600 ml-3">{{
                                form.errors.ceremony_id
                            }}
                            </div>
                        </div>

                        <!-- Usuário -->
                        <div class="min-w-fit" v-if="task_form_selects.users.length">
                            <select id="task-user" name="task_user" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs text-white bg-gray-700"
                                v-model="form_update.user_id" @change="submit()">
                                <option v-for="user in task_form_selects.users" :value="user.id"
                                    :selected="form_update.user_id == user.id">{{ user.name }} {{ user.surname
                                    }}</option>
                            </select>
                            <div v-if="form_update.errors.user_id" class="text-xs text-red-600 ml-3">{{ form.errors.user_id
                            }}
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="w-full px-4 py-3 space-x-2 text-right sm:px-6 bg-gray-100">
                <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form_update.processing }"
                    :disabled="form_update.processing" @click="closeModal(false)">
                    Fechar
                </SecondaryButton>
            </div>
        </form>
    </Modal>
</template>