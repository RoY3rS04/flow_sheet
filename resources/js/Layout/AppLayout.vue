<script setup lang="ts">
import NavItem from "@/components/NavItem.vue";
import {Home, Workflow, Table, LogOut} from "lucide-vue-next";
import {Link, usePage} from "@inertiajs/vue3";
import {Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList} from "@/components/ui/breadcrumb/index.js";
import {BreadcrumbSeparator} from "@/components/ui/breadcrumb";

const pageUrl = usePage();
const paths = pageUrl.url.split('/').filter(Boolean);

function stripRestOfPath(pageUrl: string, path: string) {
    let resultPath: string = '';
    let end = false;

    pageUrl.split('/').forEach((urlPath) => {

        if (end) {
            return resultPath;
        }

        if (urlPath === path) {
            end = true;
        }

        resultPath += urlPath === '' ? '' : `/${urlPath}`;
    })

    return resultPath;
}

</script>

<template>
    <div class="w-full h-full flex gap-x-3 p-2 items-center">
        <aside class="p-4 h-full w-[20%] flex flex-col justify-between bg-red-500">
            <header>
                <NavItem to="/" description="Home">
                    <Home class="icon"/>
                </NavItem>
            </header>
            <section class="space-y-5">
                <NavItem to="/datasets" description="Your Datasets">
                    <Table class="icon"/>
                </NavItem>
                <NavItem to="/workflows" description="Your Workflow">
                    <Workflow class="icon"/>
                </NavItem>
            </section>
            <section>
                <NavItem to="/" description="Log Out">
                    <LogOut class="icon"/>
                </NavItem>
            </section>
        </aside>
        <section class="p-4 space-y-4 w-full h-full bg-green-400">
            <div>
                <Breadcrumb>
                    <BreadcrumbList>
                        <template v-for="(path, idx) in paths" :key="path">
                            <BreadcrumbItem>
                                <Link :href="stripRestOfPath(pageUrl.url, path)">
                                    {{ path }}
                                </Link>
                            </BreadcrumbItem>
                            <BreadcrumbSeparator v-if="idx < paths.length - 1"/>
                        </template>
                    </BreadcrumbList>
                </Breadcrumb>
            </div>
            <main>
                <slot></slot>
            </main>
        </section>
    </div>
</template>
