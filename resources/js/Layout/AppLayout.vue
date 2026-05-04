<script setup lang="ts">
import { computed } from "vue";
import AppSidebar from "@/components/AppSidebar.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Breadcrumb, BreadcrumbItem, BreadcrumbList } from "@/components/ui/breadcrumb/index.js";
import { BreadcrumbSeparator } from "@/components/ui/breadcrumb";
import { Separator } from "@/components/ui/separator";

const page = usePage();

const breadcrumbPaths = computed(() => {
    const segments = page.url.split("?")[0].split("/").filter(Boolean);

    if (segments.length === 0) {
        return [
            {
                label: "home",
                href: "/",
            },
        ];
    }

    return segments.map((segment, index) => ({
        label: segment,
        href: `/${segments.slice(0, index + 1).join("/")}`,
    }));
});
</script>

<template>
    <div class="h-screen overflow-hidden bg-muted/30 md:flex">
        <AppSidebar />

        <section class="flex min-h-0 flex-1 flex-col overflow-hidden">
            <header class="sticky top-0 z-10 flex h-16 shrink-0 items-center gap-3 border-b bg-background/95 px-4 backdrop-blur">
                <AppSidebar mobile />
                <Separator orientation="vertical" class="hidden h-4 md:block" />

                <Breadcrumb>
                    <BreadcrumbList>
                        <template v-for="(path, idx) in breadcrumbPaths" :key="path.href">
                            <BreadcrumbItem>
                                <Link :href="path.href" class="capitalize">
                                    {{ path.label }}
                                </Link>
                            </BreadcrumbItem>
                            <BreadcrumbSeparator v-if="idx < breadcrumbPaths.length - 1" />
                        </template>
                    </BreadcrumbList>
                </Breadcrumb>
            </header>

            <main class="min-h-0 flex-1 overflow-y-auto p-4 md:p-6">
                <slot></slot>
            </main>
        </section>
    </div>
</template>
