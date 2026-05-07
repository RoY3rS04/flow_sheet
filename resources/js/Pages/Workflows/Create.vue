<script setup lang="ts">

import AppLayout from "@/Layout/AppLayout.vue";
import {Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import { SaveIcon, WorkflowIcon, FunnelIcon, Grid2X2Check, Rows4Icon, ShapesIcon, SquareArrowRightEnterIcon, SquareArrowRightExitIcon } from "lucide-vue-next";
import {Form} from "@inertiajs/vue3";
import {Field, FieldGroup, FieldLabel, FieldSet} from "@/components/ui/field";
import {Input} from "@/components/ui/input";
import {Textarea} from "@/components/ui/textarea";
import {ref} from "vue";
import type {Node, Edge} from "@vue-flow/core";
import {VueFlow} from "@vue-flow/core";
import {Background} from "@vue-flow/background";
import {MiniMap} from "@vue-flow/minimap";
import {ResizableHandle, ResizablePanel, ResizablePanelGroup} from "@/components/ui/resizable";
import {Item, ItemActions, ItemContent, ItemDescription, ItemTitle} from "@/components/ui/item";
import {ScrollArea} from "@/components/ui/scroll-area";

const {userId} = defineProps<{
    userId: number
}>()

const nodes = ref<Node[]>([])

// these are our edges
const edges = ref<Edge[]>([])

function onDrop(e) {
    nodes.value.push({
        position: {
            x: e.x,
            y: e.y
        },
        type: 'input',
        id: '1'
    })
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
                    <Button class="cursor-pointer" disabled>
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
                            <VueFlow class="col-start-1 col-span-3 border-1 rounded-md" :nodes="nodes" :edges="edges">
                                <Background variant="lines"/>
                                <MiniMap pannable zoomable/>
                            </VueFlow>
                        </div>
                    </ResizablePanel>
                    <ResizableHandle class="mx-5"/>
                    <ResizablePanel>
                        <ScrollArea class="h-full">
                            <Form @submit.prevent>
                                <FieldGroup class="col-start-4 col-span-full">
                                    <FieldSet>
                                        <Field>
                                            <FieldLabel for="workflow_name">Workflow Name</FieldLabel>
                                            <Input
                                                id="workflow_name"
                                                name="name"
                                                placeholder="Choose a clear name that describes what this workflow does, such as “Top Customers Report” or “Clean Monthly Orders”."
                                                required
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="workflow_description">Workflow Description</FieldLabel>
                                            <Textarea
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
                                    <Item class="cursor-grab" draggable="true" id="input_node" variant="outline">
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
                                    <Item class="cursor-grab" draggable="true" id="filter_node" variant="outline">
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
                                    <Item class="cursor-grab" draggable="true" id="select_node" variant="outline">
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
                                    <Item class="cursor-grab" draggable="true" id="limit_node" variant="outline">
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
                                    <Item class="cursor-grab" draggable="true" id="output_node" variant="outline">
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
