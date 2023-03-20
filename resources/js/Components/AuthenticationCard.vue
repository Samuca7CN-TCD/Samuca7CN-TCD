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
        <div class="w-full h-screen px-10 md:p-0 lg:w-1/3 lg:h-screen bg-white flex flex-col justify-center items-center">
            <div class="my-5">
                <slot name="logo" />
            </div>
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white transition-shadow shadow-md hover:shadow-2xl overflow-auto sm:rounded-lg">
                <slot />
            </div>
        </div>
        <div
            class="w-0 h-0 lg:w-2/3 lg:h-screen flex flex-col justify-center justify-items-center bg-black bg-center bg-no-repeat bg-contain bg-complete-logo-bgless">
        </div>
    </div>
</template>
