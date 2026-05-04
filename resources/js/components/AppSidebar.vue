<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Button, buttonVariants } from "@/components/ui/button/index.js";
import { Separator } from "@/components/ui/separator/index.js";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet/index.js";
import { cn } from "@/lib/utils";
import { Home, LogOut, Menu, Route as RouteIcon, Table, Workflow } from "lucide-vue-next";

const props = defineProps({
    mobile: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();

const primaryItems = [
    {
        label: "Home",
        href: "/",
        icon: Home,
    },
];

const workspaceItems = [
    {
        label: "Your Datasets",
        href: "/datasets",
        icon: Table,
    },
    {
        label: "Your Workflows",
        href: "/workflows",
        icon: Workflow,
    },
];

const currentPath = computed(() => page.url.split("?")[0]);

function isActiveRoute(href) {
    return currentPath.value === href;
}

function navigationButtonClass(isActive) {
    return cn(
        "h-10 w-full justify-start gap-3 rounded-xl px-3 text-sm font-medium",
        isActive && "bg-sidebar-accent text-sidebar-accent-foreground shadow-none",
    );
}

const logoutButtonClass = computed(() =>
    cn(
        buttonVariants({ variant: "ghost" }),
        "h-10 w-full justify-start gap-3 rounded-xl px-3 text-sm font-medium text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
    ),
);
</script>

<template>
    <Sheet v-if="props.mobile">
        <SheetTrigger as-child>
            <Button variant="outline" size="icon" class="size-9 md:hidden">
                <Menu class="size-4" />
                <span class="sr-only">Open navigation</span>
            </Button>
        </SheetTrigger>
        <SheetContent
            side="left"
            class="w-72 border-sidebar-border bg-sidebar p-0 text-sidebar-foreground sm:max-w-72"
        >
            <div class="flex h-full flex-col">
                <div class="p-4">
                    <div class="flex items-center gap-3 rounded-2xl bg-sidebar-primary px-4 py-3 text-sidebar-primary-foreground">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-sidebar-primary-foreground/12">
                            <RouteIcon class="size-5" />
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold tracking-tight">FlowSheet</p>
                            <p class="text-xs text-sidebar-primary-foreground/70">Workspace</p>
                        </div>
                    </div>
                </div>

                <Separator />

                <nav class="flex flex-1 flex-col justify-between gap-6 p-4">
                    <div class="space-y-6">
                        <section class="space-y-2">
                            <p class="px-3 text-xs font-semibold uppercase tracking-[0.22em] text-sidebar-foreground/55">
                                Overview
                            </p>
                            <div class="space-y-1">
                                <Button
                                    v-for="item in primaryItems"
                                    :key="item.href"
                                    as-child
                                    :variant="isActiveRoute(item.href) ? 'secondary' : 'ghost'"
                                    :class="navigationButtonClass(isActiveRoute(item.href))"
                                >
                                    <Link :href="item.href">
                                        <component :is="item.icon" class="size-4" />
                                        <span>{{ item.label }}</span>
                                    </Link>
                                </Button>
                            </div>
                        </section>

                        <section class="space-y-2">
                            <p class="px-3 text-xs font-semibold uppercase tracking-[0.22em] text-sidebar-foreground/55">
                                Workspace
                            </p>
                            <div class="space-y-1">
                                <Button
                                    v-for="item in workspaceItems"
                                    :key="item.href"
                                    as-child
                                    :variant="isActiveRoute(item.href) ? 'secondary' : 'ghost'"
                                    :class="navigationButtonClass(isActiveRoute(item.href))"
                                >
                                    <Link :href="item.href">
                                        <component :is="item.icon" class="size-4" />
                                        <span>{{ item.label }}</span>
                                    </Link>
                                </Button>
                            </div>
                        </section>
                    </div>

                    <div class="space-y-3">
                        <Separator />
                        <Link href="/logout" method="post" as="button" :class="logoutButtonClass">
                            <LogOut class="size-4" />
                            <span>Log Out</span>
                        </Link>
                    </div>
                </nav>
            </div>
        </SheetContent>
    </Sheet>

    <aside
        v-else
        class="hidden h-screen w-72 shrink-0 border-r border-sidebar-border bg-sidebar text-sidebar-foreground md:flex md:flex-col"
    >
        <div class="p-4">
            <div class="flex items-center gap-3 rounded-2xl bg-sidebar-primary px-4 py-3 text-sidebar-primary-foreground">
                <div class="flex size-10 items-center justify-center rounded-xl bg-sidebar-primary-foreground/12">
                    <RouteIcon class="size-5" />
                </div>
                <div class="min-w-0">
                    <p class="font-semibold tracking-tight">FlowSheet</p>
                    <p class="text-xs text-sidebar-primary-foreground/70">Workspace</p>
                </div>
            </div>
        </div>

        <Separator />

        <nav class="flex flex-1 flex-col justify-between gap-6 p-4">
            <div class="space-y-6">
                <section class="space-y-2">
                    <p class="px-3 text-xs font-semibold uppercase tracking-[0.22em] text-sidebar-foreground/55">
                        Overview
                    </p>
                    <div class="space-y-1">
                        <Button
                            v-for="item in primaryItems"
                            :key="item.href"
                            as-child
                            :variant="isActiveRoute(item.href) ? 'secondary' : 'ghost'"
                            :class="navigationButtonClass(isActiveRoute(item.href))"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" class="size-4" />
                                <span>{{ item.label }}</span>
                            </Link>
                        </Button>
                    </div>
                </section>

                <section class="space-y-2">
                    <p class="px-3 text-xs font-semibold uppercase tracking-[0.22em] text-sidebar-foreground/55">
                        Workspace
                    </p>
                    <div class="space-y-1">
                        <Button
                            v-for="item in workspaceItems"
                            :key="item.href"
                            as-child
                            :variant="isActiveRoute(item.href) ? 'secondary' : 'ghost'"
                            :class="navigationButtonClass(isActiveRoute(item.href))"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" class="size-4" />
                                <span>{{ item.label }}</span>
                            </Link>
                        </Button>
                    </div>
                </section>
            </div>

            <div class="space-y-3">
                <Separator />
                <Link href="/logout" method="post" as="button" :class="logoutButtonClass">
                    <LogOut class="size-4" />
                    <span>Log Out</span>
                </Link>
            </div>
        </nav>
    </aside>
</template>
