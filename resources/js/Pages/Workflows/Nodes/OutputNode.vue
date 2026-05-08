<script setup>

import {SquareArrowRightExitIcon} from "lucide-vue-next";
import {Item, ItemActions, ItemContent, ItemDescription, ItemTitle} from "@/components/ui/item/index.js";
import {Input} from "@/components/ui/input/index.js";
import {ref, watch} from "vue";
import {Handle, Position} from "@vue-flow/core";
import {useWorkflowStore} from "@/stores/workflow.ts";

const outputFilename = ref('')

const {
    getOutputNode,
    changeNodeState
} = useWorkflowStore();

watch(outputFilename, () => {
    changeNodeState(getOutputNode().id, {
        filename: outputFilename
    })

    console.log(getOutputNode())
});

</script>

<template>
    <Item class="cursor-grab bg-white" variant="outline">
        <ItemContent>
            <ItemTitle>
                <SquareArrowRightExitIcon :size="16"></SquareArrowRightExitIcon>
                Output
            </ItemTitle>
            <div>
                <Input v-model="outputFilename"></Input>
            </div>
        </ItemContent>
        <Handle type="target" :position="Position.Top"/>
    </Item>
</template>

<style scoped>

</style>
