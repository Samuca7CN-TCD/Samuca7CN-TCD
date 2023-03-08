<script setup>
defineProps({
    tags: Object,
});
</script>
<template>
    <section class="w-11/12 m-auto px-5 rounded-xl shadow-2xl min-h-[525px] my-10 bg-white py-10 select-none">
        <div class="grid-min-config">
            <div v-for="tag in tags" class="rounded-xl shadow-lg">
                <div class="w-1/4 h-10" :class="{
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
                <div class="w-3/4">
                    <span>{{ tag.name }}</span>
                    <span>{{ tag.code }}</span>
                </div>
            </div>
        </div>
    </section>
</template>