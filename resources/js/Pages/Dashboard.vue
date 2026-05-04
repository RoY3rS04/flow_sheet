<script setup>
import { Button } from "@/components/ui/button/index.js";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import AppLayout from "../Layout/AppLayout.vue";
import { ArrowRight, BarChart3, CheckCircle2, FileSpreadsheet, Play, Sparkles, Workflow } from "lucide-vue-next";
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <section class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-muted-foreground">
                        Dashboard
                    </p>
                    <h1 class="text-3xl font-semibold tracking-tight">
                        Build and run transformations with less friction
                    </h1>
                    <p class="max-w-2xl text-sm text-muted-foreground">
                        A quick view of your datasets, workflows, and recent runs while the MVP takes shape.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <Button variant="outline" class="h-11 rounded-xl px-5">
                        <FileSpreadsheet class="size-4" />
                        <span>Upload dataset</span>
                    </Button>
                    <Button class="h-11 rounded-xl px-5">
                        <Workflow class="size-4" />
                        <span>Create workflow</span>
                    </Button>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <Card class="rounded-[1.5rem] border-border/70">
                    <CardHeader class="space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <CardDescription>Total datasets</CardDescription>
                            <div class="flex size-10 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <FileSpreadsheet class="size-4" />
                            </div>
                        </div>
                        <CardTitle class="text-3xl tracking-tight">
                            12
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">
                            Ready to power workflow previews and exports.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-[1.5rem] border-border/70">
                    <CardHeader class="space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <CardDescription>Saved workflows</CardDescription>
                            <div class="flex size-10 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <Workflow class="size-4" />
                            </div>
                        </div>
                        <CardTitle class="text-3xl tracking-tight">
                            7
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">
                            Linear transformation flows waiting to be refined.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-[1.5rem] border-border/70">
                    <CardHeader class="space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <CardDescription>Completed runs</CardDescription>
                            <div class="flex size-10 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <CheckCircle2 class="size-4" />
                            </div>
                        </div>
                        <CardTitle class="text-3xl tracking-tight">
                            29
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">
                            Recent executions processed without needing retries.
                        </p>
                    </CardContent>
                </Card>

                <Card class="rounded-[1.5rem] border-border/70">
                    <CardHeader class="space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <CardDescription>Avg. output rows</CardDescription>
                            <div class="flex size-10 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <BarChart3 class="size-4" />
                            </div>
                        </div>
                        <CardTitle class="text-3xl tracking-tight">
                            4.8k
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">
                            A helpful baseline for sizing exports and previews.
                        </p>
                    </CardContent>
                </Card>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                <Card class="rounded-[1.5rem] border-border/70">
                    <CardHeader class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="space-y-1.5">
                            <CardTitle class="text-xl tracking-tight">
                                Recent workflow runs
                            </CardTitle>
                            <CardDescription>
                                A quick snapshot of the latest pipeline executions across your workspace.
                            </CardDescription>
                        </div>
                        <Button variant="outline" class="h-10 rounded-xl px-4">
                            <Play class="size-4" />
                            <span>Run workflow</span>
                        </Button>
                    </CardHeader>

                    <CardContent>
                        <div class="overflow-hidden rounded-2xl border border-border/70">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-muted/50 text-muted-foreground">
                                    <tr>
                                        <th class="px-4 py-3 font-medium">Workflow</th>
                                        <th class="px-4 py-3 font-medium">Dataset</th>
                                        <th class="px-4 py-3 font-medium">Status</th>
                                        <th class="px-4 py-3 font-medium">Output</th>
                                        <th class="px-4 py-3 font-medium text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border/70 bg-background">
                                    <tr class="hover:bg-muted/30">
                                        <td class="px-4 py-4">
                                            <div>
                                                <p class="font-medium">High-value orders</p>
                                                <p class="text-xs text-muted-foreground">where → sort → select_columns</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">orders-q2.csv</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                Completed
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">1,204 rows</td>
                                        <td class="px-4 py-4 text-right">
                                            <Button variant="ghost" class="rounded-lg px-3">View</Button>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-muted/30">
                                        <td class="px-4 py-4">
                                            <div>
                                                <p class="font-medium">Customer enrichment</p>
                                                <p class="text-xs text-muted-foreground">select_columns → sort → limit</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">customers-clean.csv</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700">
                                                Running
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">Pending</td>
                                        <td class="px-4 py-4 text-right">
                                            <Button variant="ghost" class="rounded-lg px-3">View</Button>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-muted/30">
                                        <td class="px-4 py-4">
                                            <div>
                                                <p class="font-medium">Inventory cleanup</p>
                                                <p class="text-xs text-muted-foreground">where → select_columns</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">inventory-sync.csv</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700">
                                                Failed
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">0 rows</td>
                                        <td class="px-4 py-4 text-right">
                                            <Button variant="ghost" class="rounded-lg px-3">View</Button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </CardContent>
                </Card>

                <div class="space-y-6">
                    <Card class="rounded-[1.5rem] border-border/70">
                        <CardHeader class="space-y-1.5">
                            <div class="flex size-11 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <Sparkles class="size-5" />
                            </div>
                            <CardTitle class="text-xl tracking-tight">
                                MVP flow
                            </CardTitle>
                            <CardDescription>
                                The dashboard can stay simple while the core pipeline builder evolves.
                            </CardDescription>
                        </CardHeader>

                        <CardContent class="space-y-3">
                            <div class="rounded-2xl border border-border/70 bg-muted/40 px-4 py-3">
                                <p class="font-medium">1. Upload a dataset</p>
                                <p class="text-sm text-muted-foreground">Store the CSV, extract metadata, and prepare the columns for configuration.</p>
                            </div>
                            <div class="rounded-2xl border border-border/70 bg-muted/40 px-4 py-3">
                                <p class="font-medium">2. Build a workflow</p>
                                <p class="text-sm text-muted-foreground">Arrange nodes visually, connect them, and persist the graph structure.</p>
                            </div>
                            <div class="rounded-2xl border border-border/70 bg-muted/40 px-4 py-3">
                                <p class="font-medium">3. Run and export</p>
                                <p class="text-sm text-muted-foreground">Queue execution, track status, preview results, and deliver the transformed file.</p>
                            </div>
                        </CardContent>
                    </Card>

                    <Card class="rounded-[1.5rem] border-border/70">
                        <CardHeader class="space-y-1.5">
                            <CardTitle class="text-xl tracking-tight">
                                Quick links
                            </CardTitle>
                            <CardDescription>
                                Useful next steps for the current FlowSheet MVP.
                            </CardDescription>
                        </CardHeader>

                        <CardContent class="space-y-3">
                            <Button variant="outline" class="h-11 w-full justify-between rounded-xl px-4">
                                <span>Review datasets</span>
                                <ArrowRight class="size-4" />
                            </Button>
                            <Button variant="outline" class="h-11 w-full justify-between rounded-xl px-4">
                                <span>Open workflow builder</span>
                                <ArrowRight class="size-4" />
                            </Button>
                            <Button variant="outline" class="h-11 w-full justify-between rounded-xl px-4">
                                <span>Inspect recent exports</span>
                                <ArrowRight class="size-4" />
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
