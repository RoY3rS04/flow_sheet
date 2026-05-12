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
import {ref, watch} from "vue";
import {useHttp} from "@inertiajs/vue3";
import {Handle, Position} from "@vue-flow/core";
import {useWorkflowStore} from "@/stores/workflow";
import {AvailableOperatorsForColumnType} from "@/types/workflow";
import {Input} from "@/components/ui/input";
import {ItemHeader} from "@/components/ui/item";

const openColumn = ref<boolean>(false);
const openOperator = ref<boolean>(false);
const columnValue = ref<string>('');
const operatorValue = ref<string>('');
const operatorType = ref<string>('');
const inputType = ref<string>('text');

const http = useHttp({
    query: ''
})

const {
    getInputNode
} = useWorkflowStore();

const columns = ref<Column[]>([])

type Column = {
    name: string,
    type: string
}

async function getDatasetColumns(datasetId: number): Promise<Column[]> {
    const data = await http.get(`/datasets/${datasetId}/columns`, {
        onError: errors => {
            console.log(errors);
        }
    });

    return JSON.parse(data.columns) as Column[]
}

watch(
    () => getInputNode()?.data?.datasetId ?? null,
    async (datasetId, _previousDatasetId, onCleanup) => {
        columnValue.value = '';
        operatorType.value = '';
        operatorValue.value = '';

        if (!datasetId) {
            columns.value = [];
            return
        }

        let cancelled = false;

        onCleanup(() => {
            cancelled = true;
        });

        const nextColumns = await getDatasetColumns(Number(datasetId));

        if (!cancelled) {
            columns.value = nextColumns;
            console.log(columns.value)
        }
    },
    {
        immediate: true,
    },
)

function getInputType(): string {

    const selectedColumn = columns.value.find(col => col.name === columnValue.value);

    if (!selectedColumn) {
        return 'text'
    }

    switch (selectedColumn.type) {
        case 'float':
        case 'integer':
            return 'number';
        case 'string': return 'text';
        case 'date': return 'date';
        case 'datetime': return  'datetime-local';
        case 'boolean': return 'checkbox';
        default:
            return 'text';
    }

}

watch(columnValue, () => {
    operatorType.value = columns.value.find(col => col.name === columnValue.value)?.type ?? '';
    inputType.value = getInputType()
});

</script>

<template>
    <Item class="cursor-grab bg-white" id="filter_node" variant="outline">
        <ItemHeader>
            <ItemTitle>
                <FunnelIcon :size="16"></FunnelIcon>
                Filter
            </ItemTitle>
        </ItemHeader>
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
                        <CommandInput placeholder="Search operator..." />
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
            <Input
                :type="inputType"
                :min="inputType === 'number' ? 0: null"
                placeholder="value"
                :disabled="operatorValue === 'notNull'"
            />
        </ItemContent>
        <Handle id="filter_in" type="target" :position="Position.Top"/>
        <Handle id="filter_out" type="source" :position="Position.Bottom"/>
    </Item>
</template>

<style scoped>

</style>
