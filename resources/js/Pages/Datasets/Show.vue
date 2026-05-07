<script setup lang="ts">
import { computed } from "vue";
import {Link, router} from "@inertiajs/vue3";
import {
    ArrowLeft,
    ChevronLeft,
    ChevronRight,
    Download,
    FileSpreadsheet,
    Rows3,
    TableProperties,
    Trash2,
} from "lucide-vue-next";
import type { Dataset } from "@/types/Dataset/dataset";
import AppLayout from "@/Layout/AppLayout.vue";
import { Button } from "@/components/ui/button";
import { Card, CardAction, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import {AlertDialog, AlertDialogFooter, AlertDialogHeader, AlertDialogTrigger, AlertDialogContent, AlertDialogDescription, AlertDialogCancel, AlertDialogAction} from "@/components/ui/alert-dialog";

type DatasetCellValue = boolean | number | string | null;

const {dataset, rows, userId} = defineProps<{
    dataset: Dataset;
    rows?: DatasetRow[] | PaginatedDatasetRows;
    userId: number;
}>();

function handleDelete() {
    router.delete(`/datasets/${dataset.id}`)
}

interface DatasetRow {
    id?: number;
    row_number: number;
    values?: DatasetCellValue[] | Record<string, DatasetCellValue>;
    cells?: DatasetCellValue[] | Record<string, DatasetCellValue>;
    errors?: Record<string, string> | string[] | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedDatasetRows {
    data: DatasetRow[];
    current_page: number;
    from: number | null;
    last_page: number;
    links?: PaginationLink[];
    next_page_url: string | null;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

const rowItems = computed<DatasetRow[]>(() => {
    if (!rows) {
        return [];
    }

    if (Array.isArray(rows)) {
        return rows;
    }

    return rows.data;
});

const pagination = computed<PaginatedDatasetRows | null>(() => {
    if (!rows || Array.isArray(rows)) {
        return null;
    }

    return rows;
});

const columns = computed<string[]>(() => {
    const parsedColumns = parseColumns(dataset.columns);

    if (parsedColumns.length > 0) {
        return parsedColumns;
    }

    const firstRow = rowItems.value[0];
    const firstRowValues = firstRow ? extractRowValues(firstRow) : [];

    if (!Array.isArray(firstRowValues) && firstRowValues) {
        return Object.keys(firstRowValues);
    }

    return [];
});

const hasRows = computed(() => rowItems.value.length > 0);

const pageRange = computed(() => {
    if (!pagination.value) {
        return null;
    }

    if (pagination.value.from === null || pagination.value.to === null) {
        return null;
    }

    return `${pagination.value.from.toLocaleString("en-US")}-${pagination.value.to.toLocaleString("en-US")}`;
});

function parseColumns(value: Dataset["columns"] | unknown): string[] {
    if (Array.isArray(value)) {
        return value.map((column) => String(column));
    }

    if (typeof value !== "string" || value.length === 0) {
        return [];
    }

    try {
        const parsedValue = JSON.parse(value);

        return Array.isArray(parsedValue)
            ? parsedValue.map((column) => String(column))
            : [];
    } catch {
        return [];
    }
}

function extractRowValues(row: DatasetRow): DatasetCellValue[] | Record<string, DatasetCellValue> {
    return row.values ?? row.cells ?? [];
}

function getCellValue(row: DatasetRow, column: string, columnIndex: number): string {
    const rowValues = extractRowValues(row);

    if (Array.isArray(rowValues)) {
        return formatCellValue(rowValues[columnIndex]);
    }

    return formatCellValue(rowValues[column]);
}

function formatCellValue(value: DatasetCellValue | undefined): string {
    if (value === null || value === undefined || value === "") {
        return "-";
    }

    if (typeof value === "boolean") {
        return value ? "true" : "false";
    }

    return String(value);
}
</script>

<template>
    <AppLayout :userId="userId">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-3">
                <Button variant="ghost" size="sm" class="w-fit px-2 text-muted-foreground" as-child>
                    <Link href="/datasets">
                        <ArrowLeft class="size-4" />
                        <span>Datasets</span>
                    </Link>
                </Button>

                <div class="flex flex-wrap items-center justify-end gap-2">
                    <Button variant="outline" size="sm">
                        <Download class="size-4" />
                        <span>Export</span>
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
                                    <Button @click="handleDelete">
                                        Delete
                                    </Button>
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
            </div>

            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg border border-border/70 bg-muted/35">
                        <FileSpreadsheet class="size-5 text-sidebar-primary" />
                    </div>
                    <div class="min-w-0 space-y-1">
                        <h1 class="break-words text-2xl font-semibold tracking-tight">
                            {{ dataset.filename }}
                        </h1>
                        <p class="text-sm text-muted-foreground">
                            Dataset #{{ dataset.id }}
                        </p>
                    </div>
                </div>

                <div class="grid w-full gap-4 sm:grid-cols-3 lg:w-auto lg:min-w-[30rem]">
                    <Card class="gap-2 border-border/70 py-3 shadow-sm">
                        <CardHeader class="gap-1 px-3">
                            <CardDescription class="flex items-center gap-1.5 text-xs">
                                <Rows3 class="size-3.5" />
                                Rows
                            </CardDescription>
                            <CardTitle class="text-lg">
                                {{ dataset.row_count.toLocaleString("en-US") }}
                            </CardTitle>
                        </CardHeader>
                    </Card>

                    <Card class="gap-2 border-border/70 py-3 shadow-sm">
                        <CardHeader class="gap-1 px-3">
                            <CardDescription class="flex items-center gap-1.5 text-xs">
                                <TableProperties class="size-3.5" />
                                Columns
                            </CardDescription>
                            <CardTitle class="text-lg">
                                {{ dataset.columns_count.toLocaleString("en-US") }}
                            </CardTitle>
                        </CardHeader>
                    </Card>

                    <Card class="gap-2 border-border/70 py-3 shadow-sm">
                        <CardHeader class="gap-1 px-3">
                            <CardDescription class="text-xs">Preview window</CardDescription>
                            <CardTitle class="text-lg">
                                <template v-if="pageRange">
                                    {{ pageRange }}
                                </template>
                                <template v-else>
                                    Not loaded
                                </template>
                            </CardTitle>
                        </CardHeader>
                    </Card>
                </div>
            </div>

            <Card class="gap-4 border-border/70 py-4 shadow-sm">
                <CardHeader class="flex flex-col gap-3 border-b border-border/70 px-4 !pb-3 md:flex-row md:items-end md:justify-between">
                    <div class="space-y-1">
                        <CardTitle class="text-base tracking-tight md:text-xl">
                            Dataset rows
                        </CardTitle>
                        <CardDescription class="text-xs md:text-sm">
                            Spreadsheet-style preview of the parsed dataset rows.
                        </CardDescription>
                    </div>

                    <CardAction class="flex items-center gap-2">
                        <Button
                            v-if="pagination?.prev_page_url"
                            variant="outline"
                            size="sm"
                            as-child
                        >
                            <Link :href="pagination.prev_page_url" :only="['rows']" preserve-scroll>
                                <ChevronLeft class="size-4" />
                                <span>Previous</span>
                            </Link>
                        </Button>
                        <Button
                            v-else
                            variant="outline"
                            size="sm"
                            disabled
                        >
                            <ChevronLeft class="size-4" />
                            <span>Previous</span>
                        </Button>
                        <Button
                            v-if="pagination?.next_page_url"
                            variant="outline"
                            size="sm"
                            as-child
                        >
                            <Link :href="pagination.next_page_url" :only="['rows']" preserve-scroll>
                                <span>Next</span>
                                <ChevronRight class="size-4" />
                            </Link>
                        </Button>
                        <Button
                            v-else
                            variant="outline"
                            size="sm"
                            disabled
                        >
                            <span>Next</span>
                            <ChevronRight class="size-4" />
                        </Button>
                    </CardAction>
                </CardHeader>

                <CardContent class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] border-collapse text-left text-sm">
                            <thead class="bg-muted/45 text-muted-foreground">
                                <tr class="border-b border-border/70">
                                    <th class="sticky left-0 z-10 w-20 bg-muted px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em]">
                                        Row
                                    </th>
                                    <th
                                        v-for="column in columns"
                                        :key="column"
                                        class="min-w-44 px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em]"
                                    >
                                        <span class="line-clamp-1">{{ column }}</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-border/70">
                                <tr
                                    v-for="row in rowItems"
                                    :key="row.id ?? row.row_number"
                                    class="bg-background transition-colors hover:bg-muted/25"
                                >
                                    <td class="sticky left-0 z-10 bg-background px-4 py-3 font-mono text-xs font-medium text-muted-foreground">
                                        {{ row.row_number.toLocaleString("en-US") }}
                                    </td>
                                    <td
                                        v-for="(column, columnIndex) in columns"
                                        :key="`${row.id ?? row.row_number}-${column}`"
                                        class="max-w-72 px-4 py-3 align-top"
                                    >
                                        <span class="block truncate">
                                            {{ getCellValue(row, column, columnIndex) }}
                                        </span>
                                    </td>
                                </tr>

                                <tr v-if="!hasRows">
                                    <td :colspan="Math.max(columns.length + 1, 2)" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-sm space-y-2">
                                            <p class="text-sm font-semibold text-foreground">
                                                Rows are not available yet
                                            </p>
                                            <p class="text-sm text-muted-foreground">
                                                Once parsed rows are sent to this page, they will render here without loading the full dataset in the browser.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-border/70 px-4 py-3 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
                        <p v-if="pagination && pageRange">
                            Showing {{ pageRange }} of {{ pagination.total.toLocaleString("en-US") }} rows
                        </p>
                        <p v-else>
                            {{ rowItems.length.toLocaleString("en-US") }} rows loaded
                        </p>

                        <div v-if="pagination" class="flex items-center gap-2">
                            <span>
                                Page {{ pagination.current_page }} of {{ pagination.last_page }}
                            </span>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
