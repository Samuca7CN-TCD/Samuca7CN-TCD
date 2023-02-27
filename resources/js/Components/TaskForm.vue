<script setup>
import { ref } from 'vue';

let today = new Date();
const emit = defineEmits(['show_form', 'response']);
const task_input = ref({
    title: null,
    description: null,
    deadline: today = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate() + 'T23:59',
    priority: null,
    tags: {},
});

const props = defineProps({
    show_form: Boolean,
})

// setInterval(function () { console.log(task_input.value) }, 5000);
emit('show_form', props.show_form.value);
emit('response', task_input.value);
</script>
<template>
    <form action="#" method="POST" class="w-full">
        <div class="overflow-hidden border-2 m-5 sm:rounded-md bg-white px-4 py-5 sm:p-3 flex-col-config divide-y-2">
            <div class="w-full m-0 p-0">
                <!-- Título -->
                <div class="w-full">
                    <input type="text" name="task_title" id="task-title" autocomplete="off" placeholder="Título"
                        class=" block w-full border-none focus:outline-0 focus:shadow-none focus:border-none sm:text-md"
                        v-model="task_input.title" />
                </div>

                <!-- Descrição-->
                <div class="w-full">
                    <input type="text" name="task_description" id="task-description" autocomplete="off"
                        placeholder="Descrição" class="block w-full outline-none border-none sm:text-sm"
                        v-model="task_input.description" />
                </div>

                <!-- Detalhes -->
                <div class="w-full flex flex-row space-x-2 my-2 ">
                    <!-- Data -->
                    <div class="border-2">
                        <input type="datetime-local" name="task_date_time" id="task-date-time" autocomplete="off"
                            class="block w-full outline-0 border-none sm:text-xs" v-model="task_input.deadline" />
                    </div>

                    <!-- Prioridade -->
                    <!-- Etiquetas -->
                    <div class="border-2">
                        <select id="task-priority" name="task_priority" autocomplete="off"
                            class="block w-full outline-0 border-none sm:text-xs">
                            <option>Prioridade 1</option>
                            <option>Prioridade 2</option>
                            <option>Prioridade 3</option>
                            <option selected="selected">Prioridade 4</option>
                        </select>
                    </div>

                    <!-- Etiquetas -->
                    <div class="border-2">
                        <select id="country" name="country" autocomplete="country-name"
                            class="block w-full outline-0 border-none sm:text-xs">
                            <option>Nothing</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full bg-gray-50 px-4 py-3 space-x-2 text-right sm:px-6">
                <button
                    class="rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700"
                    @click="show_form = !show_form">Cancelar</button>

                <button type="submit"
                    class="rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Agendar</button>
            </div>
        </div>
    </form>
</template>