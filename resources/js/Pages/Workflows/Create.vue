<script setup lang="ts">

import AppLayout from "@/Layout/AppLayout.vue";
import {Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import { SaveIcon, WorkflowIcon, FunnelIcon, Grid2X2Check, Rows4Icon, ShapesIcon, SquareArrowRightEnterIcon, SquareArrowRightExitIcon } from "lucide-vue-next";
import {Form, useHttp} from "@inertiajs/vue3";
import {Field, FieldGroup, FieldLabel, FieldSet} from "@/components/ui/field";
import {Input} from "@/components/ui/input";
import {Textarea} from "@/components/ui/textarea";
import {computed, onUnmounted, ref} from "vue";
import type {Node, Edge, NodeChange} from "@vue-flow/core";
import {VueFlow, useVueFlow} from "@vue-flow/core";
import {Background} from "@vue-flow/background";
import {MiniMap} from "@vue-flow/minimap";
import {ResizableHandle, ResizablePanel, ResizablePanelGroup} from "@/components/ui/resizable";
import {Item, ItemActions, ItemContent, ItemDescription, ItemTitle} from "@/components/ui/item";
import {ScrollArea} from "@/components/ui/scroll-area";
import InputNode from "@/Pages/Workflows/Nodes/InputNode.vue";
import FilterNode from "@/Pages/Workflows/Nodes/FilterNode.vue";
import SelectNode from "@/Pages/Workflows/Nodes/SelectNode.vue";
import LimitNode from "@/Pages/Workflows/Nodes/LimitNode.vue";
import OutputNode from "@/Pages/Workflows/Nodes/OutputNode.vue";
import {useWorkflowStore} from "@/stores/workflow";

const {userId} = defineProps<{
    userId: number
}>()

const {
    screenToFlowCoordinate,
} = useVueFlow()

const {
    nodes,
    edges,
    addNode,
    addEdge,
} = useWorkflowStore()

const workflowName = ref<string>('');
const workflowDescription = ref<string>('');

const http = useHttp({
    workflowInfo: {
        name: '',
        description: '',
    },
    nodes: [],
    edges: [],
})


function onDrop(e) {

    if(!e.dataTransfer) {
        return
    }

    const nodeType = e.dataTransfer.getData('nodeType')

    const node = {
        position: screenToFlowCoordinate({
            x: e.clientX,
            y: e.clientY
        }),
        type: nodeType,
        id: self.crypto.randomUUID(),
    }

    addNode(node)
}

function onDragStart(e: DragEvent) {

    const target = e.currentTarget as HTMLElement|null

    if (!target || !e.dataTransfer) {
        return
    }

    e.dataTransfer.setData('nodeType', target.dataset.nodeType ?? '')
    e.dataTransfer.effectAllowed = 'move'
}

onUnmounted(() => {
    nodes.value = [];
    edges.value = [];
})

function onSubmit(e) {
    http.workflowInfo = {
        name: workflowName.value,
        description: workflowDescription.value,
    }

    http.nodes = nodes.value.map((node) => ({
        id: node.id,
        type: node.type,
        position: node.position,
        data: node.data ?? {},
    }))

    http.edges = edges.value.map((edge) => ({
        id: edge.id,
        source: edge.source,
        target: edge.target,
        sourceHandle: edge.sourceHandle ?? null,
        targetHandle: edge.targetHandle ?? null,
    }))

    http.post('/workflows', {
        onError: (errors) => {
            console.log(errors)
        },
    })
}

const isSaveBtnDisabled = computed(() => {
    if(
        nodes.value.find(node => node.type === 'input-file') &&
        nodes.value.find(node => node.type === 'output-file') &&
        workflowName.value.trim().length > 0 && edges.value.length > 0
    ) {
        return false
    }

    return true;
})

function handleConnect(e) {

    if (e.source === e.target) {
        return;
    }

    if (!e.sourceHandle.includes('out') || !e.targetHandle.includes('in')) {
        return;
    }

    const edgeId = [
        e.source,
        e.target
    ].sort().join()

    const edge = {
        id: edgeId,
        source: e.source,
        target: e.target
    }

    addEdge(edge)
}

</script>

<template>
    <AppLayout :userId="userId">
        <Card class="flex flex-col h-full">
            <CardHeader>
                <CardTitle class="text-2xl">
                    <div class="flex items-center gap-x-3">
                        <WorkflowIcon></WorkflowIcon>
                        <h3>Create a new Workflow</h3>
                    </div>
                </CardTitle>
                <CardDescription>
                    <p class="max-w-2xl">Create a reusable workflow to transform your datasets. Add a name and optional description, then use the visual builder to connect steps like filtering, sorting, selecting columns, and limiting results.</p>
                </CardDescription>
                <CardAction>
                    <Button form="workflow_form" class="cursor-pointer" :disabled="isSaveBtnDisabled">
                        <SaveIcon></SaveIcon>
                        Save Workflow
                    </Button>
                </CardAction>
            </CardHeader>
            <CardContent class="mt-4 flex-1 overflow-y-scroll">
                <ResizablePanelGroup
                    direction="horizontal"
                >
                    <ResizablePanel :defaultSize="60">
                        <div @drop.prevent="onDrop" @dragover.prevent>
                            <VueFlow
                                class="col-start-1 col-span-3 border-1 rounded-md"
                                :nodes="nodes"
                                :edges="edges"
                                @connect="handleConnect"
                            >
                                <template #node-input-file="specialNodeProps">
                                    <InputNode :nodeProps="specialNodeProps" />
                                </template>
                                <template #node-filter="specialNodeProps">
                                    <FilterNode v-bind="specialNodeProps" />
                                </template>
                                <template #node-select="specialNodeProps">
                                    <SelectNode :nodeProps="specialNodeProps" />
                                </template>
                                <template #node-limit="specialNodeProps">
                                    <LimitNode v-bind="specialNodeProps" />
                                </template>
                                <template #node-output-file="specialNodeProps">
                                    <OutputNode v-bind="specialNodeProps" />
                                </template>
                                <Background variant="lines"/>
                                <MiniMap pannable zoomable/>
                            </VueFlow>
                        </div>
                    </ResizablePanel>
                    <ResizableHandle class="mx-5"/>
                    <ResizablePanel>
                        <ScrollArea class="h-full">
                            <Form id="workflow_form" @submit.prevent="onSubmit">
                                <FieldGroup class="col-start-4 col-span-full">
                                    <FieldSet>
                                        <Field>
                                            <FieldLabel for="workflow_name">Workflow Name</FieldLabel>
                                            <Input
                                                v-model="workflowName"
                                                id="workflow_name"
                                                name="name"
                                                placeholder="Choose a clear name that describes what this workflow does, such as “Top Customers Report” or “Clean Monthly Orders”."
                                                required
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="workflow_description">Workflow Description</FieldLabel>
                                            <Textarea
                                                v-model="workflowDescription"
                                                id="workflow_description"
                                                name="description"
                                                placeholder="Optionally describe the purpose of this workflow, the expected dataset structure, or when it should be used."
                                                :rows="4"
                                            />
                                        </Field>
                                    </FieldSet>
                                </FieldGroup>
                            </Form>
                            <div class="flex flex-col gap-y-4 mt-5">
                                <div class="flex items-center gap-x-2">
                                    <ShapesIcon></ShapesIcon>
                                    <h4 class="text-xl font-semibold">Available Nodes</h4>
                                </div>
                                <div class="space-y-3">
                                    <Item @dragstart="onDragStart" data-node-type="input-file" class="cursor-grab" draggable="true" id="input_node" variant="outline">
                                        <ItemContent>
                                            <ItemTitle>
                                                <SquareArrowRightEnterIcon :size="16"></SquareArrowRightEnterIcon>
                                                Input Node
                                            </ItemTitle>
                                            <ItemDescription>
                                                Select the dataset you want to work with.
                                            </ItemDescription>
                                            <ItemActions>

                                            </ItemActions>
                                        </ItemContent>
                                    </Item>
                                    <Item @dragstart="onDragStart" data-node-type="filter" class="cursor-grab" draggable="true" id="filter_node" variant="outline">
                                        <ItemContent>
                                            <ItemTitle>
                                                <FunnelIcon :size="16"></FunnelIcon>
                                                Filter Node
                                            </ItemTitle>
                                            <ItemDescription>
                                                Choose a column, operator, and value to keep only matching rows.
                                            </ItemDescription>
                                            <ItemActions>

                                            </ItemActions>
                                        </ItemContent>
                                    </Item>
                                    <Item @dragstart="onDragStart" data-node-type="select" class="cursor-grab" draggable="true" id="select_node" variant="outline">
                                        <ItemContent>
                                            <ItemTitle>
                                                <Grid2X2Check :size="16"></Grid2X2Check>
                                                Select Node
                                            </ItemTitle>
                                            <ItemDescription>
                                                Select one or more columns to include in the output.
                                            </ItemDescription>
                                            <ItemActions>

                                            </ItemActions>
                                        </ItemContent>
                                    </Item>
                                    <Item @dragstart="onDragStart" data-node-type="limit" class="cursor-grab" draggable="true" id="limit_node" variant="outline">
                                        <ItemContent>
                                            <ItemTitle>
                                                <Rows4Icon :size="16"></Rows4Icon>
                                                Limit Node
                                            </ItemTitle>
                                            <ItemDescription>
                                                Enter how many rows should remain in the result.
                                            </ItemDescription>
                                            <ItemActions>

                                            </ItemActions>
                                        </ItemContent>
                                    </Item>
                                    <Item @dragstart="onDragStart" data-node-type="output-file" class="cursor-grab" draggable="true" id="output_node" variant="outline">
                                        <ItemContent>
                                            <ItemTitle>
                                                <SquareArrowRightExitIcon :size="16"></SquareArrowRightExitIcon>
                                                Output Node
                                            </ItemTitle>
                                            <ItemDescription>
                                                Define the name of your output file.
                                            </ItemDescription>
                                            <ItemActions>

                                            </ItemActions>
                                        </ItemContent>
                                    </Item>
                                </div>
                            </div>
                        </ScrollArea>
                    </ResizablePanel>
                </ResizablePanelGroup>
            </CardContent>
        </Card>
    </AppLayout>
</template>
