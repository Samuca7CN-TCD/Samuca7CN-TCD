<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const profile_photo_name = ref('');

const form = useForm({
    profile_photo: null,
    name: '',
    surname: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const previewFiles = (event) => {
    if (event.target.files.length) {
        form.profile_photo = event.target.files[0];
        profile_photo_name.value = form.profile_photo.name;
    }
}

const removePhoto = () => {
    form.profile_photo = profile_photo_name.value = null;
}

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div class="w-full flex-col-config xl:flex-row">
                <div class="w-full xl:w-1/3 flex-col-config mx-5">
                    <div>
                        <label for="profile_photo" class="flex-col-config">
                            <div
                                class="flex-col-config w-32 h-32 rounded-full cursor-pointer bg-gray-100 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <svg aria-hidden="true" class="w-10 h-10 m-3 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                            </div>
                        </label>
                        <input id="profile_photo" @change="previewFiles" type="file" accept="image/*" class="hidden" />
                        <InputError class="mt-2" :message="form.errors.profile_photo" />
                        <p class="text-center text-xs">{{ profile_photo_name }}
                            <span title="Remover Foto" class="cursor-pointer inline-block align-middle"
                                v-if="profile_photo_name" @click="removePhoto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-3 h-3 hover:text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="w-full xl:w-2/3">
                    <div>
                        <InputLabel for="name" value="Nome" class="after:content-['*'] after:ml-0.5 after:text-red-500" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="surname" value="Sobrenome" />
                        <TextInput id="surname" v-model="form.surname" type="text" class="mt-1 block w-full"
                            autocomplete="surname" />
                        <InputError class="mt-2" :message="form.errors.surname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="username" value="Nome de Usuário" />
                        <TextInput id="username" v-model="form.username" type="text" class="mt-1 block w-full"
                            autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>
                </div>
        </div>

            <div class="mt-4">
                <InputLabel for="email" value="E-mail" class="after:content-['*'] after:ml-0.5 after:text-red-500" />
                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" class="after:content-['*'] after:ml-0.5 after:text-red-500" />
                <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                    autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Senha"
                    class="after:content-['*'] after:ml-0.5 after:text-red-500" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="mt-1 block w-full" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms" class="after:content-['*'] after:ml-0.5 after:text-red-500">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Termos de Serviço</a> e <a
                                target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Política de Privacidade</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                                    Você já é registrado?
                                                    </Link> -->

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
