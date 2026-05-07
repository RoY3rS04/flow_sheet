<script setup lang="ts">
import AppLayout from "@/Layout/AppLayout.vue";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Form} from "@inertiajs/vue3";
import {FileSpreadsheetIcon, LucideSend} from "lucide-vue-next";
import {Input} from "@/components/ui/input";
import {onMounted, ref} from "vue";

const inputFilled = ref(false);
let input: HTMLInputElement;

const {userId} = defineProps<{
    userId: number
}>();

function handleDrop(e) {

    const allowedFileExtensions = ['.csv', '.xlsx']

    if(
        !allowedFileExtensions.some(
            (extension: string) => e.dataTransfer.files[0].name.toLowerCase().endsWith(extension)
        )
    ) {
        return;
    }

    input.files = e.dataTransfer.files;
    input.dispatchEvent(new Event('change', {
        bubbles: true
    }))
}

function onSubmit() {
    input.files = null;
    inputFilled.value = false;
}

onMounted(() => {
    input = document.getElementById('file') as HTMLInputElement
})

</script>

<template>
    <AppLayout :userId="userId">
        <Card class="w-full h-full">
            <CardHeader class="flex items-center justify-between">
                <div>
                    <CardTitle class="text-xl">Upload dataset</CardTitle>
                    <CardDescription>
                        Drag and drop a file or browse from your device.
                    </CardDescription>
                </div>
                <div class="flex items-center gap-x-2">
                    <Button class="cursor-pointer" variant="outline" as-child>
                        <Label for="file">
                            <FileSpreadsheetIcon></FileSpreadsheetIcon>
                            <span>Select your file</span>
                        </Label>
                    </Button>
                    <Button form="submit-file" class="cursor-pointer" :disabled="!inputFilled">
                        <LucideSend></LucideSend>
                        <span>Submit file</span>
                    </Button>
                </div>
            </CardHeader>

            <CardContent class="h-full">
                <div id="target" @dragover.prevent @dragenter.prevent @drop.prevent="handleDrop" class="rounded-md h-full w-full flex items-center justify-center border-3 border-dashed">
                    <span class="font-semibold text-xl">Drag and drop your file here</span>
                </div>
                <Form @submit="onSubmit" id="submit-file" action="/datasets" method="post">
                    <Input @change.prevent="() => inputFilled = input.files.length > 0" hidden type="file" id="file" name="file"></Input>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
