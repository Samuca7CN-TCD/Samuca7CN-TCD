<!--
<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
-->

<template>
    <div class="w-screen h-screen flex flex-row justify-center justify-items-center">
        <div
            class="w-full h-screen px-10 md:p-0 lg:w-1/3 lg:h-screen bg-white flex flex-col justify-center items-center">
            <div>
                <slot name="logo" />
            </div>
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white transition-shadow shadow-md hover:shadow-2xl overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>
        <div
            class="w-0 h-0 lg:w-2/3 lg:h-screen flex flex-col justify-center justify-items-center bg-center bg-no-repeat bg-cover bg-[url('/storage/app/public/theme/login/logo.svg')]">
        </div>
    </div>
</template>
