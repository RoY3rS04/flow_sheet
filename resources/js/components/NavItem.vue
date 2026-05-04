<script setup>

import {Link} from "@inertiajs/vue3";

defineProps({
    to: String,
    description: String
})

</script>

<template>
    <Link :href="to" class="flex items-center gap-x-2">
        <slot></slot>
        {{ description }}
    </Link>
</template>

<style scoped>

</style>
