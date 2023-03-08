<script setup>
import { ref, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import { XMarkIcon, TagIcon, PlusIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    tags: Object,
});

const form_open = ref(false);
const possible_colors = ref(['rose', 'pink', 'fuchsia', 'purple', 'violet', 'indigo', 'blue', 'sky', 'cyan', 'teal', 'emerald', 'green', 'lime', 'yellow', 'amber', 'orange', 'red', 'stone', 'neutral', 'zinc', 'gray', 'slate']);
const colors = ref([]);

const filterAvailableColors = () => {
    colors.value = possible_colors.value.filter(function (color) {
        return props.tags.filter((tag) => tag.color == color).length == 0;
    })
}
filterAvailableColors();

const form = useForm({
    id: null,
    name: null,
    color: null,
});

const form_texts = ref({
    create: {
        title: 'Cadastrar',
        description: 'Formulário para cadastro de uma nova tarefa',
        save_button: 'Cadastrar',
    },
    update: {
        title: 'Editar',
        description: 'Formulário para edição de tarefa existente',
        save_button: 'Salvar',
    }
})

const form_text = ref({
    mode: 'create',
    values: form_texts.value.create
});

const changeTag = (tag, event) => {
    if (!event) {
        form.id = tag.id;
        form.name = tag.name;
        form.color = tag.color;
        colors.value.push(tag.color);
        form_text.value.mode = 'update';
        form_text.value.values = form_texts.value.update;
        form_open.value = true;
    }
}

const closeModal = () => {
    form.reset();
    form.clearErrors();
    filterAvailableColors();
    form_text.value.mode = 'create';
    form_text.value.values = form_texts.value.create;
    form_open.value = false;
}

const submit = () => {
    if (form_text.value.mode == 'create') {
        form.post(route('tags.store'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else if (form_text.value.mode == 'update') {
        form.put(route('tags.update', form.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
}

const removeTag = (tag_id, event) => {
    form.delete(route('tags.destroy', tag_id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })
}
</script>
<template>
    <section class="w-11/12 m-auto px-5 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white py-10 select-none">
        <Modal :show="form_open">
            <div class="shadow-2xl p-2">
                <div class="mt-5 mx-5">
                    <div class="flex flex-row align-middle items-center space-x-2">
                        <span class="p-2 rounded-full" :class="{
                            'bg-blue-100 text-blue-400': form_text.mode == 'create',
                            'bg-yellow-100 text-yellow-400': form_text.mode == 'update',
                        }">
                            <PlusIcon v-if="form_text.mode == 'create'" class="w-5 h-5" />
                            <PencilSquareIcon v-if="form_text.mode == 'update'" class="w-5 h-5" />
                        </span>
                        <h2 class="text-2xl bold">{{ form_text.values.title }}</h2>
                    </div>
                    <p class="text-xm text-gray-500 mt-3">{{ form_text.values.description }}</p>
                </div>
                <form id="create_task" @submit.prevent="submit" class="w-full">

                    <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white sm:p-3 flex-col-config divide-y-2">
                        <div class="w-full m-0 p-0">
                            <div class="w-full mb-5">
                                <input type="text" name="tag_name" id="tag-name" autocomplete="off"
                                    placeholder="Nome da tag" class="w-full border-2 border-slate-200 sm:text-md"
                                    v-model="form.name" />
                                <div v-if="form.errors.name" class="text-xs text-red-600 ml-3">{{ form.errors.name }}</div>
                            </div>

                            <!-- Cor -->
                            <div class="w-full flex-row-config mb-5 overflow-hidden space-x-2">
                                <div class="w-1/12 h-9 rounded-xl" :class="{
                                    'bg-rose-700': form.color == 'rose',
                                    'bg-pink-700': form.color == 'pink',
                                    'bg-fuchsia-700': form.color == 'fuchsia',
                                    'bg-purple-700': form.color == 'purple',
                                    'bg-violet-700': form.color == 'violet',
                                    'bg-indigo-700': form.color == 'indigo',
                                    'bg-blue-700': form.color == 'blue',
                                    'bg-sky-700': form.color == 'sky',
                                    'bg-cyan-700': form.color == 'cyan',
                                    'bg-teal-700': form.color == 'teal',
                                    'bg-emerald-700': form.color == 'emerald',
                                    'bg-green-700': form.color == 'green',
                                    'bg-lime-700': form.color == 'lime',
                                    'bg-yellow-700': form.color == 'yellow',
                                    'bg-amber-700': form.color == 'amber',
                                    'bg-orange-700': form.color == 'orange',
                                    'bg-red-700': form.color == 'red',
                                    'bg-stone-700': form.color == 'stone',
                                    'bg-neutral-700': form.color == 'neutral',
                                    'bg-zinc-700': form.color == 'zinc',
                                    'bg-gray-700': form.color == 'gray',
                                    'bg-slate-700': form.color == 'slate',
                                    'bg-black': form.color == null,
                                }"></div>
                                <div class="border-2 min-w-fit w-11/12">
                                    <select id="tag-color" name="tag_color" autocomplete="off"
                                        class="w-full outline-0 border-none sm:text-xs" :class="{
                                            'text-rose-700': form.color == 'rose',
                                            'text-pink-700': form.color == 'pink',
                                            'text-fuchsia-700': form.color == 'fuchsia',
                                            'text-purple-700': form.color == 'purple',
                                            'text-violet-700': form.color == 'violet',
                                            'text-indigo-700': form.color == 'indigo',
                                            'text-blue-700': form.color == 'blue',
                                            'text-sky-700': form.color == 'sky',
                                            'text-cyan-700': form.color == 'cyan',
                                            'text-teal-700': form.color == 'teal',
                                            'text-emerald-700': form.color == 'emerald',
                                            'text-green-700': form.color == 'green',
                                            'text-lime-700': form.color == 'lime',
                                            'text-yellow-700': form.color == 'yellow',
                                            'text-amber-700': form.color == 'amber',
                                            'text-orange-700': form.color == 'orange',
                                            'text-red-700': form.color == 'red',
                                            'text-stone-700': form.color == 'stone',
                                            'text-neutral-700': form.color == 'neutral',
                                            'text-zinc-700': form.color == 'zinc',
                                            'text-gray-700': form.color == 'gray',
                                            'text-slate-700': form.color == 'slate',
                                            'text-black': form.color == null,
                                        }" v-model="form.color">
                                        <option :value="null" class="text-black">Escolha uma cor</option>
                                        <option v-for="color in colors" :class="{
                                            'text-rose-700': color == 'rose',
                                            'text-pink-700': color == 'pink',
                                            'text-fuchsia-700': color == 'fuchsia',
                                            'text-purple-700': color == 'purple',
                                            'text-violet-700': color == 'violet',
                                            'text-indigo-700': color == 'indigo',
                                            'text-blue-700': color == 'blue',
                                            'text-sky-700': color == 'sky',
                                            'text-cyan-700': color == 'cyan',
                                            'text-teal-700': color == 'teal',
                                            'text-emerald-700': color == 'emerald',
                                            'text-green-700': color == 'green',
                                            'text-lime-700': color == 'lime',
                                            'text-yellow-700': color == 'yellow',
                                            'text-amber-700': color == 'amber',
                                            'text-orange-700': color == 'orange',
                                            'text-red-700': color == 'red',
                                            'text-stone-700': color == 'stone',
                                            'text-neutral-700': color == 'neutral',
                                            'text-zinc-700': color == 'zinc',
                                            'text-gray-700': color == 'gray',
                                            'text-slate-700': color == 'slate',
                                        }" :value="color" :selected="form.color == color"> {{ color }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.color" class="text-xs text-red-600 ml-3">{{ form.errors.color }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-4 py-3 space-x-2 text-right sm:px-6">
                            <DeleteButton class="bg-red-600" @click="removeTag(form.id)">
                                Excluir
                            </DeleteButton>
                            <SecondaryButton :type="'button'" class="ml-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing" @click="closeModal">
                                Cancelar
                            </SecondaryButton>

                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                {{ form_text.values.save_button }}
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>
        <div class="grid-min-config">
            <div v-for="tag in tags" :key="tag.id"
                class="group rounded-xl shadow-md hover:shadow-xl active:shadow-lg cursor-pointer flex-row-config overflow-hidden h-10"
                @click="changeTag(tag)">
                <div :title="'Cor: ' + tag.color" class="w-1/3 h-full flex-col-config" :class="{
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
                }"></div>
                <div class="w-2/3 flex-col-config p-2">
                    <span class="text-sm">{{ tag.name }}</span>
                </div>
            </div>
        </div>

        <button type="buttom"
            class="flex-col-config absolute top-28 right-12 bg-red-600 hover:bg-red-700 active:bg-red-500 text-white rounded-full p-5"
            @click="form_open = true">
            <PlusIcon class="w-5 h-5" />
        </button>
    </section>
</template>