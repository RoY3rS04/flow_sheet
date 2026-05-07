<script setup>

import {SquareArrowOutUpRight} from "lucide-vue-next";
import {Item, ItemActions, ItemContent, ItemDescription, ItemTitle} from "@/components/ui/item/index.js";
import {Input} from "@/components/ui/input/index.js";
import {ref} from "vue";

const outputFilename = ref('')
</script>

<template>
    <Item class="cursor-grab" variant="outline">
        <ItemContent>
            <ItemTitle>
                <SquareArrowOutUpRight :size="16"></SquareArrowOutUpRight>
                Output
            </ItemTitle>
            <div>
                <Input v-model="outputFilename"></Input>
            </div>
        </ItemContent>
    </Item>
</template>

<style scoped>

</style>
