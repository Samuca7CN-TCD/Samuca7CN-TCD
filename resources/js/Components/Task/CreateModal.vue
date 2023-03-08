<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue'
import { XMarkIcon, TagIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { computed } from '@vue/reactivity';

// Variávels default
const dateZeroFiller = (number) => { return number.toString().padStart(2, '0'); }
const today = ref(new Date());
const today_min = ref(today.value.getFullYear() + '-' + dateZeroFiller(today.value.getMonth() + 1) + '-' + dateZeroFiller(today.value.getDate()) + 'T' + dateZeroFiller(today.value.getHours()) + ':' + dateZeroFiller(today.value.getMinutes()));
today.value = today.value.getFullYear() + '-' + dateZeroFiller((today.value.getMonth() + 1)) + '-' + dateZeroFiller(today.value.getDate()) + 'T23:59';

const props = defineProps({
    show: Boolean,
    task_form_selects: Object,
    logged_user: Object,
});

const open = ref(props.show);

const form = useForm('create_task', {
    title: null,
    description: null,
    deadline: today.value,
    priority: 4,
    tags: 0,
    ceremony_id: null,
    user_id: props.logged_user.id,
    task_status_id: 1,
});

const loggedUser = (id) => {
    return id == props.logged_user.id ? true : false;
}

// Emissão de dados
const emit = defineEmits(['modal_open']);

// Variáveis do campo 'Etiqueta'
const tag_options = ref(props.task_form_selects.tags);
const selected_tags = ref([]);

const appendTag = (e) => {
    let tag = tag_options.value.filter((tag) => tag.id == e.target.value)[0];
    selected_tags.value.push({
        'id': e.target.value,
        'color': tag.color,
        'name': tag.name,
    });
    loadTagOptions();
    form.tags = 0;
}

const removeTag = (tag_id) => {
    selected_tags.value = selected_tags.value.filter((tag) => tag.id != tag_id);
    loadTagOptions();
}

const loadTagOptions = () => {
    tag_options.value = props.task_form_selects.tags.filter(function (tag) {
        return selected_tags.value.filter((s_tag) => s_tag.id == tag.id).length == 0;
    });
}

// Controle de formulário
const submit = () => {
    form.tags = JSON.stringify(selected_tags.value);
    form.deadline = form.deadline.replace('T', ' ') + ':59';

    form.post(route('tasks.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });

    form.deadline = form.deadline.replace(' ', 'T').substring(0, form.deadline.length - 3);
    form.tags = 0;
}

const closeModal = () => {
    form.clearErrors();
    form.reset();
    selected_tags.value = [];
    loadTagOptions();
    emit('modal_open', false);
}
</script>
<template>
    <Modal :show="show">
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
                    <!-- Título -->
                    <div class="w-full">
                        <input type="text" name="task_title" id="task-title" autocomplete="off" placeholder="Título"
                            class="w-full border-none focus:outline-0 sm:text-md" v-model="form.title" />
                        <div v-if="form.errors.title" class="text-xs text-red-600 ml-3">{{ form.errors.title }}</div>
                    </div>

                    <!-- Descrição-->
                    <div class="w-full">
                        <textarea name="task_description" id="task-description" autocomplete="off" placeholder="Descrição"
                            rows="2" class="w-full outline-none border-none sm:text-sm"
                            v-model="form.description"></textarea>
                        <div v-if="form.errors.description" class="text-xs text-red-600 ml-3">{{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Etiquetas Selecionadas -->
                    <div v-if="selected_tags.length" class="w-full flex flex-row space-x-2 py-2 overflow-auto">
                        <div v-for="selected_tag in selected_tags"
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
                            <XMarkIcon class="w-4 h-4 cursor-pointer select-none" @click="removeTag(selected_tag.id)" />
                        </div>
                        <div v-if="form.errors.tags" class="text-xs text-red-600 ml-3">{{ form.errors.tags }}</div>
                    </div>

                    <!-- Detalhes -->
                    <div
                        class="w-full flex flex-row space-x-2 py-2 overflow-auto scrollbar scrollbar-thumb-gray-700 scrollbar-track-gray-100 scrollbar-corner-gray-400 scrollbar-h-2 pb-3">
                        <!-- Data -->
                        <div class="border-2">
                            <input type="datetime-local" name="task_date_time" id="task-date-time" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs" v-model="form.deadline" :min="today_min" />
                            <div v-if="form.errors.deadline" class="text-xs text-red-600 ml-3">{{ form.errors.deadline }}
                            </div>
                        </div>

                        <!-- Prioridade -->
                        <div class="border-2 min-w-fit">
                            <select id="task-priority" name="task_priority" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs" :class="{
                                    'text-red-500': form.priority == 1,
                                    'text-orange-500': form.priority == 2,
                                    'text-blue-500': form.priority == 3,
                                    'text-gray-500': form.priority == 4
                                }" v-model="form.priority">
                                <option v-for="i in 4" :class="{
                                    'text-red-500': i == 1,
                                    'text-orange-500': i == 2,
                                    'text-blue-500': i == 3,
                                    'text-gray-500': i == 4
                                }" :value="i" :selected="form.priority == i">Prioridade {{ i }}
                                </option>
                            </select>
                            <div v-if="form.errors.priority" class="text-xs text-red-600 ml-3">{{ form.errors.priority }}
                            </div>
                        </div>

                        <!-- Etiquetas -->
                        <div class="border-2 min-w-fit" v-if="task_form_selects.tags.length">
                            <select id="task-tag" name="task_tag" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs" v-model="form.tags" @input="appendTag">
                                <option value="0">Etiquetas</option>
                                <option v-for="(tag, index) in tag_options" :value="tag.id">
                                    {{ tag.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Cerimônia -->
                        <div class="border-2 min-w-fit" v-if="task_form_selects.ceremonies.length">
                            <select id="task-ceremony" name="task_ceremony" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs" v-model="form.ceremony_id">
                                <option value="null" selected="selected">Nenhuma cerimônia</option>
                                <option v-for="(ceremony, index) in task_form_selects.ceremonies" :value="ceremony.id">{{
                                    ceremony.event_name }} de {{ ceremony.client_name }}</option>
                            </select>
                            <div v-if="form.errors.ceremony_id" class="text-xs text-red-600 ml-3">{{ form.errors.ceremony_id
                            }}
                            </div>
                        </div>

                        <!-- Usuário -->
                        <div class="border-2 min-w-fit" v-if="task_form_selects.users.length">
                            <select id="task-user" name="task_user" autocomplete="off"
                                class="w-full outline-0 border-none sm:text-xs" v-model="form.user_id">
                                <option v-for="user in task_form_selects.users" :value="user.id"
                                    :selected="loggedUser(user.id)">{{ user.name }} {{ user.surname
                                    }}</option>
                            </select>
                            <div v-if="form.errors.user_id" class="text-xs text-red-600 ml-3">{{ form.errors.user_id }}
                            </div>
                        </div>
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