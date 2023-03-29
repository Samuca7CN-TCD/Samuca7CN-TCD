<script setup>
import { CalculatorIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/core';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    buffet_list: Object,
    options: Object,
    entry_plates: Object,
    buffet_plates: Object,
});

const qtd_pessoas = ref(props.options['qtd_pessoas']);
const entry_value = ref(props.options['entry']);
const buffet_value = ref(props.options['buffet']);

const getBuffetPlates = () => {
    router.get(route('buffet-calculator.index', [qtd_pessoas.value, entry_value.value, buffet_value.value]));
}

const toMonetary = (value) => {
    return value.toLocaleString('pt-br', {
        style: 'currency',
        currency: 'BRL'
    });
}

const sumTotal = (type) => {
    let sum = 0;
    let obj = null;
    if (type == 'entry') obj = props.entry_plates;
    if (type == 'buffet') obj = props.buffet_plates;
    obj.forEach(item => {
        sum += (item.cost * (qtd_pessoas.value / 10));
    });
    return sum;
}

const sumFullTotal = () => {
    return sumTotal('entry') + sumTotal('buffet');
}

const getPrice = (id) => {
    let price = 0;
    props.buffet_list.entries.forEach((item) => {
        console.log(item.id + " == " + id);
        if (item.id == id) {
            price = item.price * qtd_pessoas.value;
            return;
        }
    });
    if (!price == undefined) {
        props.buffet_list.buffets.forEach((item) => {
            if (item.id == id) {
                price = item.price * qtd_pessoas.value;
                return;
            }
        });
    }
    console.log("PREÇO DEFINITIVO: " + price);
    return price;
}

const getTotalPrice = (entry_id, buffet_id) => {
    return getPrice(entry_id) + getPrice(buffet_id);
}

const getExcedent = (entry_id, buffet_id) => {
    return getTotalPrice(entry_id, buffet_id) - sumFullTotal();
}
</script>
<template>
    <section class="w-11/12 m-auto px-0 rounded-xl shadow-2xl my-10 bg-white select-none overflow-hidden">
        <div class="w-full flex flex-row">
            <div class="w-1/3 bg-gray-700 p-5 text-gray-100">
                <div class="space-y-2">
                    <!-- Qtd pessoas -->
                    <div class="w-full">
                        <label for="qtd_pessoas" class="text-xs text-white">Quantidade de pessoas</label>
                        <input type="number" step="10" id="qtd_pessoas" v-model="qtd_pessoas"
                            placeholder="Quantidade de pessoas" class="w-full sm:text-sm bg-gray-700 text-gray-100" />
                    </div>
                    <!-- Entrada -->
                    <div class="w-full">
                        <select class="w-full border-none sm:text-xs bg-gray-700 text-gray-100" v-model="entry_value">
                            <option :value="0" :selected="entry_value == null" disabled="disabled">Escolha uma
                                Entrada</option>
                            <option v-for="entry in buffet_list['entries']" :key="entry.id" :value="entry.id"
                                :selected="entry_value == entry.id">
                                {{ entry.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Buffet -->
                    <div class="w-full">
                        <select class="w-full border-none sm:text-xs bg-gray-700 text-gray-100" v-model="buffet_value">
                            <option :value="0" :selected="buffet_value" disabled="disabled">Escolha um Buffet
                            </option>
                            <option v-for="buffet in buffet_list['buffets']" :key="buffet.id" :value="buffet.id"
                                :selected="buffet_value == buffet.id">
                                {{ buffet.name }}
                            </option>
                        </select>
                    </div>

                    <SecondaryButton class="w-full text-center" @click="getBuffetPlates()">
                        Calcular
                    </SecondaryButton>
                </div>
                <div>
                    <h3 class="mt-10 text-xl text-red-200">Resumo:</h3>
                    <p>Preço total: {{ toMonetary(getTotalPrice(entry_value, buffet_value)) }}</p>
                    <p>Custo total: {{ toMonetary(sumFullTotal()) }}</p>
                    <p class="text-xl font-weight-bolder">Excedente: {{ toMonetary(getExcedent(entry_value, buffet_value))
                    }}
                    </p>
                </div>
            </div>
            <div class="w-2/3 bg-gray-100 text-gray-700">
                <div v-if="entry_plates" class="w-full">
                    <h2 class="text-2xl p-5">Pratos da entrada:</h2>
                    <div class="w-full overflow-auto bg-white">
                        <table class="w-full m-auto table-auto overflow-auto">
                            <thead class="lg:border-b-2 lg:border-gray-500">
                                <!--<th>Status</th>-->
                                <th>Nome</th>
                                <th>Qtd. / Buffet ({{ qtd_pessoas }} pessoas)</th>
                                <th>Custo / Buffet ({{ qtd_pessoas }} pessoas)</th>
                                <!--<th>Duplicar</th>-->
                            </thead>
                            <tbody>
                                <tr v-for="(plate, index) in entry_plates" :key="plate.id"
                                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                                    :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + plate.name">
                                    <!--<td @click="toggleplateStatus(plate)"><div v-if="plate.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="plate_table_status" id="plate-table-status" :checked="plate.status" /></div> <span v-else class="text-orange-600">Pendente</span></td>-->
                                    <td class="py-3 px-5 truncate">
                                        {{ plate.name }}
                                    </td>
                                    <td class="py-3 px-5 truncate">{{ plate.qtd_per_ten_people * (qtd_pessoas / 10) }}
                                        prato(s)
                                    </td>
                                    <td class="py-3 px-5 truncate">{{ toMonetary(plate.cost * (qtd_pessoas / 10)) }}
                                    </td>
                                    <!--<td class="py-3 px-5 truncate flex-row-config"><XMarkIcon v-if="plate.status == 2" class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Deletar plate Pendente" @click="deleteplate(plate)" /><DocumentDuplicateIcon v-else class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Duplicar plate" @click="duplicateplate(plate)" /></td>-->
                                </tr>
                                <tr class="bg-red-100">
                                    <td class="py-3 px-5 truncate text-right" colspan="3">Custo totalda entrada: {{
                                        toMonetary(sumTotal('entry')) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="buffet_plates" class="w-full">
                    <h2 class="text-2xl p-5">Pratos do buffet:</h2>
                    <div class="w-full overflow-auto bg-white">
                        <table class="w-full m-auto table-auto overflow-auto">
                            <thead class="lg:border-b-2 lg:border-gray-500">
                                <!--<th>Status</th>-->
                                <th>Nome</th>
                                <th>Qtd. / Buffet ({{ qtd_pessoas }} pessoas)</th>
                                <th>Custo / Buffet ({{ qtd_pessoas }} pessoas)</th>
                                <!--<th>Duplicar</th>-->
                            </thead>
                            <tbody>
                                <tr v-for="(plate, index) in buffet_plates" :key="plate.id"
                                    class="lg:border-b-2 lg-border-gray-100 hover:bg-gray-200 active:bg-gray-300 cursor-pointer text-center"
                                    :class="{ 'bg-gray-100': (index % 2 != 0) }" :title="'Ver detalhes de ' + plate.name">
                                    <!--<td @click="toggleplateStatus(plate)"><div v-if="plate.status < 2"><input class="standard_toggle" type="checkbox" role="switch" name="plate_table_status" id="plate-table-status" :checked="plate.status" /></div> <span v-else class="text-orange-600">Pendente</span></td>-->
                                    <td class="py-3 px-5 truncate">
                                        {{ plate.name }}
                                    </td>
                                    <td class="py-3 px-5 truncate">{{ plate.qtd_per_ten_people * (qtd_pessoas / 10) }}
                                        prato(s)
                                    </td>
                                    <td class="py-3 px-5 truncate">{{ toMonetary(plate.cost * (qtd_pessoas / 10)) }}
                                    </td>
                                    <!--<td class="py-3 px-5 truncate flex-row-config"><XMarkIcon v-if="plate.status == 2" class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Deletar plate Pendente" @click="deleteplate(plate)" /><DocumentDuplicateIcon v-else class="w-6 h-6 text-stone-700 hover:text-stone-500 active:text-stone-300" title="Duplicar plate" @click="duplicateplate(plate)" /></td>-->
                                </tr>

                                <tr class="bg-red-100">
                                    <td class="py-3 px-5 truncate text-right" colspan="3">Custo total do Buffet: {{
                                        toMonetary(sumTotal('buffet')) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div></div>
    </section>
</template>