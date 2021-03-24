<template>
    <form @submit.prevent="submitData">
        <div class="px-8 py-6">
            <div class="grid gap-6 grid-col-1 md:grid-cols-2">
                <sw-input-group
                    :label="$t('settings.disk.name')"
                    :error="nameError"
                ></sw-input-group>
            </div>
        </div>
    </form>
</template>
