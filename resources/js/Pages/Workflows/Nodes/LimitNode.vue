<script setup>

import {Rows4Icon} from "lucide-vue-next";
import {Item, ItemContent, ItemHeader, ItemTitle} from "@/components/ui/item/index.js";
import {Input} from "@/components/ui/input/index.js";
import {Handle, Position} from "@vue-flow/core";
</script>

<template>
    <Item class="cursor-grab bg-white" draggable="true" id="filter_node" variant="outline">
        <ItemHeader>
            <ItemTitle>
                <Rows4Icon :size="16"></Rows4Icon>
                Limit
            </ItemTitle>
        </ItemHeader>
        <ItemContent>
            <Input type="number" min="1" name="limit" placeholder="Limit the rows you want to get from the workflow"></Input>
        </ItemContent>
    </Item>
    <Handle id="limit_in" type="target" :position="Position.Top"></Handle>
    <Handle id="limit_out" type="source" :position="Position.Bottom"></Handle>
</template>

<style scoped>

</style>
