<script setup lang="ts">
import AppLayout from "../../Layout/AppLayout.vue";

const {userId} = defineProps<{
    userId: number
}>();
</script>

<template>
    <AppLayout :userId="userId"/>
</template>
