<script setup lang="ts">
import { Button } from "@/components/ui/button/index.js";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import AppLayout from "../../Layout/AppLayout.vue";
import { Play, Plus, Workflow as WorkflowIcon } from "lucide-vue-next";
import type { Workflow } from "@/types/workflow";
import {Link} from "@inertiajs/vue3";

interface WorkflowTableItem extends Pick<Workflow, "id" | "name" | "description" | "created_at"> {
    last_run: string | null
}

const {userId} = defineProps<{
    userId: number
}>();

</script>

<template>
    <AppLayout :userId="userId">
        <div class="space-y-6">
            <section class="relative overflow-hidden rounded-[1.5rem] border border-border/70 bg-gradient-to-br from-sidebar-primary/8 via-background to-background p-4 shadow-sm md:p-5">
                <div class="absolute top-0 right-0 size-24 translate-x-6 -translate-y-6 rounded-full bg-sidebar-primary/10 blur-3xl"></div>

                <div class="relative flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="w-full space-y-1">
                        <div class="flex items-center justify-between w-full">
                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-border/70 bg-background/80 px-3 py-1 text-xs font-medium tracking-[0.18em] text-muted-foreground uppercase backdrop-blur">
                                <WorkflowIcon class="size-3.5 text-sidebar-primary"/>
                                Workflows
                            </div>
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <Button variant="outline" class="h-9 rounded-xl px-4">
                                    <Play class="size-4"/>
                                    <span>Run latest</span>
                                </Button>
                                <Button class="h-9 rounded-xl px-4 shadow-sm" asChild>
                                    <Link href="/workflows/create">
                                        <Plus class="size-4"/>
                                        <span>New workflow</span>
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mt-4 grid gap-2.5 md:grid-cols-3">
                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Saved workflows
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ workflowCount }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Run-ready flows
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ lastRunCount }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-border/70 bg-background/80 p-3 backdrop-blur">
                        <p class="text-xs font-medium tracking-[0.16em] text-muted-foreground uppercase">
                            Never run
                        </p>
                        <p class="mt-1 text-lg font-semibold tracking-tight">
                            {{ workflowCount - lastRunCount }}
                        </p>
                    </div>
                </div>
            </section>

            <Card class="rounded-[1.75rem] border-border/70 shadow-sm">
                <CardHeader class="flex flex-col gap-4 border-b border-border/70 pb-5 md:flex-row md:items-end md:justify-between">
                    <div class="space-y-1.5">
                        <p class="text-xs font-medium uppercase tracking-[0.2em] text-muted-foreground">
                            Workflows
                        </p>
                        <div class="space-y-1">
                            <CardTitle class="text-lg tracking-tight md:text-2xl">
                                Your workflows
                            </CardTitle>
                            <CardDescription>
                                A direct custom table for saved flow definitions, without feature-local table components.
                            </CardDescription>
                        </div>
                    </div>

                    <div class="inline-flex items-center rounded-full border border-border/70 bg-muted/30 px-3 py-1 text-xs font-medium text-muted-foreground">
                        {{ workflowCount }} flow definitions
                    </div>
                </CardHeader>

                <CardContent class="md:px-6">
                    <div class="overflow-hidden rounded-2xl border border-border/70">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-muted/35 text-muted-foreground">
                                <tr>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Workflow</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Description</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Created</th>
                                    <th class="px-4 py-3 text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Last run</th>
                                    <th class="px-4 py-3 text-right text-[0.7rem] font-semibold tracking-[0.18em] uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/70 bg-background">
                                <tr
                                    v-for="workflow in data"
                                    :key="workflow.id"
                                    :class="[
                                        'transition-colors hover:bg-muted/25',
                                        activeWorkflowId === workflow.id ? 'bg-muted/20' : '',
                                    ]"
                                >
                                    <td class="px-4 py-4">
                                        <div class="space-y-1">
                                            <p class="font-medium text-foreground">{{ workflow.name }}</p>
                                            <p class="text-xs text-muted-foreground">Workflow #{{ workflow.id }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="max-w-md text-sm leading-6 text-muted-foreground">
                                            {{ workflow.description ?? "No description yet." }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-4 text-muted-foreground">
                                        {{ formatDate(workflow.created_at) }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            v-if="workflow.last_run === null"
                                            class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-700"
                                        >
                                            Never run
                                        </span>
                                        <span v-else class="text-muted-foreground">
                                            {{ formatRunDate(workflow.last_run) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <Button variant="outline" size="sm" class="rounded-lg" @click="handleView(workflow)">
                                                View
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                class="rounded-lg text-destructive hover:text-destructive"
                                                @click="handleDelete(workflow)"
                                            >
                                                Delete
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="data?.length === 0">
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="space-y-2">
                                            <p class="text-sm font-semibold text-foreground">No workflows available</p>
                                            <p class="text-sm text-muted-foreground">
                                                Create a workflow to start chaining together dataset transformations and export steps.
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
