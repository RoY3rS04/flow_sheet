<script setup lang="ts">

import {CheckIcon, ChevronsUpDownIcon, Grid2X2CheckIcon} from "lucide-vue-next";
import {Item, ItemContent, ItemTitle} from "@/components/ui/item/index.js";
import {Popover, PopoverContent, PopoverTrigger} from "@/components/ui/popover/index.js";
import {Button} from "@/components/ui/button/index.js";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList
} from "@/components/ui/command/index.js";
import {cn} from "@/lib/utils.js";
import {onMounted, ref, watch} from "vue";
import {useHttp} from "@inertiajs/vue3";
import {Handle, NodeProps, Position} from "@vue-flow/core";
import {useWorkflowStore} from "@/stores/workflow";
import {ItemHeader} from "@/components/ui/item";

const open = ref<boolean>(false);
const label = ref<string>('');

type Column = {
    name: string,
    type: string
}
const columns = ref<Column[]>([])

const selectedColumns = ref<Column[]>([])

const { nodeProps } = defineProps<{
    nodeProps: NodeProps<any, object, string>
}>()

const http = useHttp({
    query: ''
})

const { changeNodeState, getInputNode } = useWorkflowStore()

async function getDatasetColumns(datasetId: number): Promise<Column[]> {
    const data = await http.get(`/datasets/${datasetId}/columns`, {
        onError: errors => {
            console.log(errors);
        }
    });

    return JSON.parse(data.columns) as Column[]
}

watch(getInputNode(), async () => {

    const inputNode = getInputNode();

    columns.value = await getDatasetColumns(Number(inputNode.data.datasetId))
})

onMounted(async () => {
    columns.value = await getDatasetColumns(Number(getInputNode().data.datasetId))
})

</script>

<template>
    <Item class="cursor-grab bg-white" id="filter_node" variant="outline">
        <ItemHeader>
            <ItemTitle>
                <Grid2X2CheckIcon :size="16"></Grid2X2CheckIcon>
                Select
            </ItemTitle>
        </ItemHeader>
        <ItemContent>
            <Popover v-model:open="open">
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        role="combobox"
                        :aria-expanded="open"
                    >
                        {{
                            selectedColumns.length > 0
                                ? selectedColumns.map(col => col.name).join(',')
                                : 'Select columns...'
                        }}
                        <ChevronsUpDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent>
                    <Command>
                        <CommandInput placeholder="Search column..." />
                        <CommandList>
                            <CommandEmpty>No column found.</CommandEmpty>
                            <CommandGroup>
                                <CommandItem
                                    v-for="column in columns"
                                    :key="column.id"
                                    :value="column.name"
                                    @select="() => {

                                        if (!selectedColumns.includes(column)) {
                                            selectedColumns.push(column)
                                            return
                                        }

                                        selectedColumns = selectedColumns.filter(iterCol => iterCol !== column)
                                    }"
                                >
                                    <CheckIcon
                                        :class="cn(
                                          'mr-2 h-4 w-4',
                                          selectedColumns.includes(column) ? 'opacity-100' : 'opacity-0',
                                        )"
                                    />
                                    {{ column.name }}
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </ItemContent>
        <Handle type="target" :position="Position.Top"/>
        <Handle type="source" :position="Position.Bottom"/>
    </Item>
</template>

<style scoped>

</style>
