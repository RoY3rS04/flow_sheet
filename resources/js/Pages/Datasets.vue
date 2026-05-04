<script setup>
import { Button } from "@/components/ui/button/index.js";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import AppLayout from "../Layout/AppLayout.vue";
import { FileSpreadsheet, Plus } from "lucide-vue-next";
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <section class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-muted-foreground">
                        Datasets
                    </p>
                    <h1 class="text-3xl font-semibold tracking-tight">
                        Upload and manage your CSV sources
                    </h1>
                    <p class="max-w-2xl text-sm text-muted-foreground">
                        Add a new file to start building transformations, or review the datasets that are already available in your workspace.
                    </p>
                </div>

                <Button class="h-11 rounded-xl px-5">
                    <Plus class="size-4" />
                    <span>New dataset</span>
                </Button>
            </section>

            <Card class="rounded-[1.5rem] border-border/70">
                <CardHeader class="space-y-1.5">
                    <CardTitle class="text-xl tracking-tight">
                        Your datasets
                    </CardTitle>
                    <CardDescription>
                        A quick view of uploaded files and their detected structure.
                    </CardDescription>
                </CardHeader>

                <CardContent>
                    <div class="overflow-hidden rounded-2xl border border-border/70">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-muted/50 text-muted-foreground">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Dataset</th>
                                    <th class="px-4 py-3 font-medium">Columns</th>
                                    <th class="px-4 py-3 font-medium">Rows</th>
                                    <th class="px-4 py-3 font-medium">Uploaded</th>
                                    <th class="px-4 py-3 font-medium text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/70 bg-background">
                                <tr class="hover:bg-muted/30">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-xl bg-sidebar-primary/10 text-sidebar-primary">
                                                <FileSpreadsheet class="size-4" />
                                            </div>
                                            <div>
                                                <p class="font-medium">orders-q2.csv</p>
                                                <p class="text-xs text-muted-foreground">sales pipeline import</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-muted-foreground">12 fields</td>
                                    <td class="px-4 py-4 text-muted-foreground">4,281</td>
                                    <td class="px-4 py-4 text-muted-foreground">May 4, 2026</td>
                                    <td class="px-4 py-4 text-right">
                                        <Button variant="ghost" class="rounded-lg px-3">View</Button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-muted/30">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-xl bg-sidebar-primary/10 text-sidebar-primary">
                                                <FileSpreadsheet class="size-4" />
                                            </div>
                                            <div>
                                                <p class="font-medium">customers-clean.csv</p>
                                                <p class="text-xs text-muted-foreground">crm enrichment batch</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-muted-foreground">8 fields</td>
                                    <td class="px-4 py-4 text-muted-foreground">1,932</td>
                                    <td class="px-4 py-4 text-muted-foreground">May 2, 2026</td>
                                    <td class="px-4 py-4 text-right">
                                        <Button variant="ghost" class="rounded-lg px-3">View</Button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-muted/30">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-xl bg-sidebar-primary/10 text-sidebar-primary">
                                                <FileSpreadsheet class="size-4" />
                                            </div>
                                            <div>
                                                <p class="font-medium">inventory-sync.csv</p>
                                                <p class="text-xs text-muted-foreground">warehouse status export</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-muted-foreground">16 fields</td>
                                    <td class="px-4 py-4 text-muted-foreground">9,504</td>
                                    <td class="px-4 py-4 text-muted-foreground">April 29, 2026</td>
                                    <td class="px-4 py-4 text-right">
                                        <Button variant="ghost" class="rounded-lg px-3">View</Button>
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
