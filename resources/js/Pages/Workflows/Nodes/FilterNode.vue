<script setup lang="ts">

import {CheckIcon, ChevronsUpDownIcon, FunnelIcon} from "lucide-vue-next";
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
import {Handle, Position} from "@vue-flow/core";
import {useWorkflowStore} from "@/stores/workflow";
import {AvailableOperatorsForColumnType} from "@/types/workflow";
import {Input} from "@/components/ui/input";

const openColumn = ref<boolean>(false);
const openOperator = ref<boolean>(false);
const columnValue = ref<string>('');
const operatorValue = ref<string>('');
const operatorType = ref<string>('');

const http = useHttp({
    query: ''
})

const {
    getInputNode
} = useWorkflowStore();

const columns = ref<{
    name: string
    type: string
}[]>([])

async function getDatasetColumns(datasetId: number) {
    const data = await http.get(`/datasets/${datasetId}/columns`, {
        onError: errors => {
            console.log(errors);
        }
    });

    columns.value = JSON.parse(data.columns)
}

watch(getInputNode(), () => {

    columnValue.value = '';
    operatorType.value = '';
    operatorValue.value = '';

    getDatasetColumns(Number(getInputNode().data.datasetId))
})

watch(columnValue, () => {
    operatorType.value = columns.value.find(col => col.name === columnValue.value)?.type ?? '';
});

onMounted(() => {

    const inputNode = getInputNode()

    if (!inputNode.data) {
        return
    }

    getDatasetColumns(Number(getInputNode().data.datasetId))
})

</script>

<template>
    <Item class="cursor-grab bg-white" id="filter_node" variant="outline">
        <ItemContent>
            <ItemTitle>
                <FunnelIcon :size="16"></FunnelIcon>
                Filter
            </ItemTitle>
        </ItemContent>
        <ItemContent>
            <Popover v-model:openColumn="openColumn">
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        role="combobox"
                        :aria-expanded="openColumn"
                    >
                        {{
                            columnValue
                                ? columns.find(column => column.name === columnValue).name
                                : 'Select column...'
                        }}
                        <ChevronsUpDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent>
                    <Command>
                        <CommandInput placeholder="Search column..." />
                        <CommandList>
                            <CommandEmpty>No columns to filter found.</CommandEmpty>
                            <CommandGroup>
                                <CommandItem
                                    v-for="column in columns"
                                    :key="column.name"
                                    :value="column.name"
                                    @select="() => {
                                        columnValue = columnValue === column.name ? '' : column.name
                                        openColumn = false
                                    }"
                                >
                                    <CheckIcon
                                        :class="cn(
                                          'mr-2 h-4 w-4',
                                          columnValue === column.name ? 'opacity-100' : 'opacity-0',
                                        )"
                                    />
                                    {{ column.name }}
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
            <Popover v-model:open="openOperator">
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        role="combobox"
                        :aria-expanded="openOperator"
                    >
                        {{
                            operatorValue
                                ? AvailableOperatorsForColumnType[operatorType].find(key => key === operatorValue)
                                : 'Select operator...'
                        }}
                        <ChevronsUpDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent>
                    <Command>
                        <CommandInput placeholder="Search column..." />
                        <CommandList>
                            <CommandEmpty>No operators found.</CommandEmpty>
                            <CommandGroup>
                                <CommandItem
                                    v-for="operator in AvailableOperatorsForColumnType[operatorType]"
                                    :key="operator"
                                    :value="operator"
                                    @select="() => {
                                        operatorValue = operatorValue === operator ? '' : operator
                                        openOperator = false
                                    }"
                                >
                                    <CheckIcon
                                        :class="cn(
                                          'mr-2 h-4 w-4',
                                          operatorValue === operator ? 'opacity-100' : 'opacity-0',
                                        )"
                                    />
                                    {{ operator }}
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
            <Input placeholder="value"/>
        </ItemContent>
        <Handle type="target" :position="Position.Top"/>
        <Handle type="source" :position="Position.Bottom"/>
    </Item>
</template>

<style scoped>

</style>
