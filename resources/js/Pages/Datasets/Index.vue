<script setup lang="ts">
import { Button } from "@/components/ui/button/index.js";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import AppLayout from "../../Layout/AppLayout.vue";
import {DatabaseZap, FileSpreadsheet, Plus, Trash2} from "lucide-vue-next";
import type { DatasetListItem } from "@/types/Dataset/dataset-list-item.ts";

import {Link, router} from "@inertiajs/vue3";
import {AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger} from "@/components/ui/alert-dialog";

const {
    datasets,
    datasetsMetadata,
    userId
} = defineProps<{
    datasets: DatasetListItem[],
    datasetsMetadata: {
        totalDatasets: number,
        totalRows: number,
        avgColumns: number
    }
    userId: number
}>()

function handleDelete(datasetId: string) {
    router.delete(`/datasets/${datasetId}`)
}

function formatDate(value: string): string {
    return new Date(value).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: 'numeric',
        minute: 'numeric'
    });
}
</script>

<template>
    <AppLayout :userId="userId">
        <div class="space-y-6">
            <section class="relative overflow-hidden rounded-[1.5rem] border border-border/70 bg-gradient-to-br from-sidebar-primary/8 via-background to-background p-4 shadow-sm md:p-5">
                <div class="absolute top-0 right-0 size-24 translate-x-6 -translate-y-6 rounded-full bg-sidebar-primary/10 blur-3xl"></div>

                <div class="relative flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-xl space-y-2.5">
                        <div class="inline-flex items-center gap-2 rounded-full border border-border/70 bg-background/80 px-3 py-1 text-xs font-medium tracking-[0.18em] text-muted-foreground uppercase backdrop-blur">
                            <DatabaseZap class="size-3.5 text-sidebar-primary" />
                            Datasets
                        </div>
                    </div>

                    <Button class="h-9 px-4 shadow-sm" as-child>
                        <Link href="/datasets/create">
                            <Plus class="size-4" />
                            <span>New dataset</span>
                        </Link>
                    </Button>
                </div>

                <div class="relative mt-4 grid gap-2.5 md:grid-cols-3">
                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Uploaded files
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ datasetsMetadata.totalDatasets }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Total rows
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ datasetsMetadata.totalRows }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Avg. columns
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ datasetsMetadata.avgColumns.toFixed(2) }}
                        </p>
                    </div>
                </div>
            </section>

            <Card class="rounded-[1.75rem] border-border/70 shadow-sm">
                <CardHeader class="flex flex-col gap-4 border-b border-border/70 pb-5 md:flex-row md:items-end md:justify-between">
                    <div class="space-y-1.5">
                        <p class="text-xs font-medium uppercase tracking-[0.2em] text-muted-foreground">
                            Datasets
                        </p>
                        <div class="space-y-1">
                            <CardTitle class="text-lg tracking-tight md:text-2xl">
                                Your datasets
                            </CardTitle>
                            <CardDescription>
                                A direct custom table for browsing uploaded source files without the extra component layer.
                            </CardDescription>
                        </div>
                    </div>

                    <div class="inline-flex items-center rounded-full border border-border/70 bg-muted/30 px-3 py-1 text-xs font-medium text-muted-foreground">
                        {{  }} ready for workflows
                    </div>
                </CardHeader>

                <CardContent class="md:px-6">
                    <div class="overflow-hidden rounded-2xl border border-border/70">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-muted/35 text-muted-foreground">
                                <tr>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Dataset</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Columns</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Rows</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Uploaded</th>
                                    <th class="px-4 py-3 text-right text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/70 bg-background">
                                <tr
                                    v-for="dataset in datasets.data"
                                    :key="dataset?.id"
                                >
                                    <td class="px-4 py-4">
                                        <div class="space-y-1">
                                            <p class="font-medium text-foreground">{{ dataset.filename }}</p>
                                            <p class="text-xs text-muted-foreground">Dataset #{{ dataset.id }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-full border border-emerald-500/15 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                            {{ dataset.columns_count }} columns
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-medium text-foreground">
                                        {{ dataset.row_count }}
                                    </td>
                                    <td class="px-4 py-4 text-muted-foreground">
                                        {{ formatDate(dataset.created_at) }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <Button variant="outline" size="sm" class="rounded-lg" asChild>
                                                <Link :href="`/datasets/${dataset.id}`">
                                                    View
                                                </Link>
                                            </Button>
                                            <AlertDialog>
                                                <AlertDialogTrigger asChild>
                                                    <Button variant="outline" size="sm" class="text-destructive cursor-pointer hover:text-destructive">
                                                        <Trash2 class="size-4"/>
                                                        <span>Delete</span>
                                                    </Button>
                                                </AlertDialogTrigger>
                                                <AlertDialogContent>
                                                    <AlertDialogHeader>
                                                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                                        <AlertDialogDescription>
                                                            This action cannot be undone. This will permanently delete your
                                                            dataset from our servers.
                                                        </AlertDialogDescription>
                                                    </AlertDialogHeader>
                                                    <AlertDialogFooter>
                                                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                                                        <AlertDialogAction asChild>
                                                            <Button @click="handleDelete(dataset.id)">
                                                                Delete
                                                            </Button>
                                                        </AlertDialogAction>
                                                    </AlertDialogFooter>
                                                </AlertDialogContent>
                                            </AlertDialog>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="datasets.data.length === 0">
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="space-y-2">
                                            <p class="text-sm font-semibold text-foreground">No datasets available</p>
                                            <p class="text-sm text-muted-foreground">
                                                Upload a CSV source to start building workflow-ready dataset previews.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
