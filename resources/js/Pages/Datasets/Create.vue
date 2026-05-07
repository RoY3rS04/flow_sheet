<script setup lang="ts">
import AppLayout from "@/Layout/AppLayout.vue";
import {Card, CardAction, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Form} from "@inertiajs/vue3";
import {FileSpreadsheetIcon, LucideSend} from "lucide-vue-next";
import {Input} from "@/components/ui/input";
import {onMounted, ref} from "vue";

const inputFilled = ref(false);
const input = ref<HTMLInputElement>(null);
const selectedFile = ref<File|null>(null)

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

    input.value.files = e.dataTransfer.files;
    selectedFile.value = e.dataTransfer.files[0];
    input.value.dispatchEvent(new Event('change', {
        bubbles: true
    }))
}

function handleInputChange(e) {

    selectedFile.value = e.target.files[0];

    inputFilled.value = input.value.files.length > 0;

}

function onSubmit() {
    input.value.files = null;
    selectedFile.value = null
    inputFilled.value = false;
}

onMounted(() => {
    input.value = document.getElementById('file') as HTMLInputElement
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
                    <span v-if="!inputFilled" class="font-semibold text-xl">Drag and drop your file here</span>
                    <Card class="w-[50%]" v-if="inputFilled">
                        <CardHeader>
                            <CardTitle>{{ selectedFile.name }}</CardTitle>
                            <CardDescription>
                                {{ (selectedFile.size / (1024*1024)).toFixed(2) }} mb
                            </CardDescription>
                            <CardAction>
                                <FileSpreadsheetIcon></FileSpreadsheetIcon>
                            </CardAction>
                        </CardHeader>
                    </Card>
                </div>
                <Form @submit="onSubmit" id="submit-file" action="/datasets" method="post">
                    <Input @change="handleInputChange" hidden type="file" id="file" name="file"></Input>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
