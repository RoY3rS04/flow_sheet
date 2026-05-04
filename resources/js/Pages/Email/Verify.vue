<script setup>
import { computed } from "vue";
import { Form, Link, usePage } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button/index.js";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import { ArrowRight, MailCheck, RouteIcon } from "lucide-vue-next";

const page = usePage();

const flashMessage = computed(() => page.props.flash?.message);
</script>

<template>
    <div class="min-h-screen bg-muted/30 px-4 py-3 sm:px-6 sm:py-4 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-2rem)] w-full max-w-6xl items-center justify-center rounded-[2rem] border bg-background shadow-sm sm:min-h-[calc(100vh-2.5rem)]">
            <section class="flex w-full items-center justify-center p-3 sm:p-6 lg:p-8">
                <Card class="w-full max-w-md gap-4 rounded-[1.75rem] border-border/70 bg-card/95 py-5 shadow-none">
                    <CardHeader class="space-y-4 px-6 pb-0 sm:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex size-11 items-center justify-center rounded-2xl bg-sidebar-primary text-sidebar-primary-foreground">
                                <RouteIcon class="size-5" />
                            </div>
                            <div>
                                <p class="font-semibold tracking-tight">FlowSheet</p>
                                <p class="text-xs text-muted-foreground">Realtime workspace</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex size-12 items-center justify-center rounded-2xl bg-sidebar-primary/10 text-sidebar-primary">
                                <MailCheck class="size-5" />
                            </div>
                            <div class="space-y-2">
                                <CardTitle class="text-2xl font-semibold tracking-tight sm:text-3xl">
                                    Verify your email
                                </CardTitle>
                                <CardDescription class="max-w-sm text-sm leading-5">
                                    Before continuing, please check your inbox and click the verification link we sent you.
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>

                    <CardContent class="space-y-4 px-6 pt-4 sm:px-8">
                        <div class="rounded-2xl border border-border/70 bg-muted/50 px-4 py-3 text-sm leading-6 text-muted-foreground">
                            Once your email is verified, you can continue using FlowSheet normally.
                        </div>

                        <div v-if="flashMessage" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ flashMessage }}
                        </div>
                    </CardContent>

                    <CardFooter class="flex flex-col gap-3 px-6 pt-0 sm:px-8">
                        <Form action="/email/verification-notification" method="POST" v-slot="{ processing }" class="w-full">
                            <Button class="h-11 w-full rounded-xl" :disabled="processing">
                                <span>{{ processing ? "Sending..." : "Resend verification email" }}</span>
                                <ArrowRight class="size-4" />
                            </Button>
                        </Form>

                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="text-sm font-medium text-muted-foreground underline-offset-4 hover:text-foreground hover:underline"
                        >
                            Log out
                        </Link>
                    </CardFooter>
                </Card>
            </section>
        </div>
    </div>
</template>
