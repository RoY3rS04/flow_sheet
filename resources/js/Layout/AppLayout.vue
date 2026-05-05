<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";
import AppSidebar from "@/components/AppSidebar.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Breadcrumb, BreadcrumbItem, BreadcrumbList } from "@/components/ui/breadcrumb/index.js";
import { BreadcrumbSeparator } from "@/components/ui/breadcrumb";
import { Separator } from "@/components/ui/separator";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { InfoIcon } from "lucide-vue-next";

const page = usePage();

const { userId } = defineProps<{
    userId: number
}>();

interface ToastMessage {
    title: string
    description: string
}

const flashMessage = ref<ToastMessage | null>(null);
const wsMessage = ref<ToastMessage | null>(null);
let flashTimeout: ReturnType<typeof setTimeout> | null = null;
let wsTimeout: ReturnType<typeof setTimeout> | null = null;

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

function resetTimeout(
    currentTimeout: ReturnType<typeof setTimeout> | null,
    callback: () => void,
): ReturnType<typeof setTimeout> {
    if (currentTimeout) {
        clearTimeout(currentTimeout);
    }

    return setTimeout(callback, 3000);
}

watch(
    () => page.props.flash.message as ToastMessage | null | undefined,
    (message) => {
        if (!message) {
            return;
        }

        flashMessage.value = {
            title: message.title,
            description: message.description,
        };

        flashTimeout = resetTimeout(flashTimeout, () => {
            flashMessage.value = null;
        });
    },
    { immediate: true },
);

onMounted(() => {
    window.Echo
        .private(`users.${userId}.datasets`)
        .listen('DatasetSaved', (event) => {
            wsMessage.value = {
                title: "Dataset Saved",
                description: `Dataset Name: ${event.dataset_name} · Total rows: ${event.dataset_rows}`,
            };

            wsTimeout = resetTimeout(wsTimeout, () => {
                wsMessage.value = null;
            });
        });
});

onBeforeUnmount(() => {
    if (flashTimeout) {
        clearTimeout(flashTimeout);
    }

    if (wsTimeout) {
        clearTimeout(wsTimeout);
    }
});

</script>

<template>
    <div class="h-screen overflow-hidden bg-muted/30 md:flex">
        <AppSidebar />
        <section class="flex h-full flex-1 flex-col overflow-hidden">
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
    <div class="space-y-2">
        <div class="absolute min-w-50 bottom-5 right-5">
            <Alert v-if="flashMessage">
                <InfoIcon/>
                <AlertTitle>
                    {{ flashMessage.title }}
                </AlertTitle>
                <AlertDescription>
                    {{ flashMessage.description }}
                </AlertDescription>
            </Alert>
        </div>
        <div class="absolute min-w-50 bottom-5 right-5">
            <Alert v-if="wsMessage">
                <InfoIcon/>
                <AlertTitle>
                    {{ wsMessage.title }}
                </AlertTitle>
                <AlertDescription>
                    {{ wsMessage.description }}
                </AlertDescription>
            </Alert>
        </div>
    </div>
</template>
