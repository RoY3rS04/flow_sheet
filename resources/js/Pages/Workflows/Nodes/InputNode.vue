<script setup lang="ts">

import {CheckIcon, ChevronsUpDownIcon, SquareArrowRightEnterIcon} from "lucide-vue-next";
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

const open = ref<boolean>(false);
const value = ref<number>(0);
const label = ref<string>('');
const datasets = ref<{
    id: number,
    filename: string
}[]>([])

const { nodeProps } = defineProps<{
    nodeProps: NodeProps<any, object, string>
}>()

const http = useHttp({
    query: ''
})

const { changeNodeState, getInputNode } = useWorkflowStore()

watch(value, () => {
    changeNodeState(getInputNode().id, {
        datasetId: value.value
    })
})

async function getDatasets() {
    const data = await http.get('/datasets/simple', {
        onError: errors => {
            console.log(errors);
        }
    });

    datasets.value = data.datasets
}

onMounted(getDatasets)

</script>

<template>
    <Item class="cursor-grab bg-white" id="filter_node" variant="outline">
        <ItemContent>
            <ItemTitle>
                <SquareArrowRightEnterIcon :size="16"></SquareArrowRightEnterIcon>
                Input
            </ItemTitle>
        </ItemContent>
        <ItemContent>
            <Popover v-model:open="open">
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        role="combobox"
                        :aria-expanded="open"
                    >
                        {{
                            label
                                ? datasets.find(dataset => dataset.filename === label).filename
                                : 'Select dataset...'
                        }}
                        <ChevronsUpDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent>
                    <Command>
                        <CommandInput placeholder="Search dataset..." />
                        <CommandList>
                            <CommandEmpty>No dataset found.</CommandEmpty>
                            <CommandGroup>
                                <CommandItem
                                    v-for="dataset in datasets"
                                    :key="dataset.filename"
                                    :value="dataset.id"
                                    @select="() => {
                                        value = value === dataset.id ? 0 : dataset.id
                                        label = label === dataset.filename ? '' : dataset.filename
                                        open = false
                                    }"
                                >
                                    <CheckIcon
                                        :class="cn(
                                          'mr-2 h-4 w-4',
                                          value === dataset.id ? 'opacity-100' : 'opacity-0',
                                        )"
                                    />
                                    {{ dataset.filename }}
                                </CommandItem>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </ItemContent>
        <Handle type="source" :position="Position.Bottom"/>
    </Item>
</template>

<style scoped>

</style>
