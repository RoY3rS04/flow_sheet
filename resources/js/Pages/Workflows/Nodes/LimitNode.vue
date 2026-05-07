<script setup>

import {FunnelIcon} from "lucide-vue-next";
import {Item, ItemActions, ItemContent, ItemDescription, ItemTitle} from "@/components/ui/item/index.js";
import {Input} from "@/components/ui/input/index.js";
</script>

<template>
    <Item class="cursor-grab" draggable="true" id="filter_node" variant="outline">
        <ItemContent>
            <ItemTitle>
                <FunnelIcon :size="16"></FunnelIcon>
                <Input name="column_name"></Input>
            </ItemTitle>
            <ItemDescription>
                Choose a column, operator, and value to keep only matching rows.
            </ItemDescription>
        </ItemContent>
    </Item>
</template>

<style scoped>

</style>
