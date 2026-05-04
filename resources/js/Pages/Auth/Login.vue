<script setup>

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import { Input } from "@/components/ui/input/index.js";
import { Button } from "@/components/ui/button/index.js";
import { Form, Link } from "@inertiajs/vue3";
import { ArrowRight, EyeClosedIcon, EyeIcon, RouteIcon } from "lucide-vue-next";
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput } from "@/components/ui/input-group/index.js";
import { ref } from "vue";

const passwordVisible = ref(false);

</script>

<template>
    <div class="min-h-screen bg-muted/30 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-6xl items-center justify-center rounded-[2rem] border bg-background shadow-sm">
            <section class="flex w-full items-center justify-center p-4 sm:p-8 lg:p-10">
                <Card class="w-full max-w-md rounded-[1.75rem] border-border/70 bg-card/95 shadow-none">
                    <CardHeader class="space-y-6 px-6 pb-0 sm:px-8">
                        <div class="flex items-center gap-3">
                            <div class="flex size-11 items-center justify-center rounded-2xl bg-sidebar-primary text-sidebar-primary-foreground">
                                <RouteIcon class="size-5" />
                            </div>
                            <div>
                                <p class="font-semibold tracking-tight">FlowSheet</p>
                                <p class="text-xs text-muted-foreground">Realtime workspace</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <CardTitle class="text-3xl font-semibold tracking-tight">
                                Log in
                            </CardTitle>
                            <CardDescription class="max-w-sm text-sm leading-6">
                                Enter your details to get back to your workspace.
                            </CardDescription>
                        </div>
                    </CardHeader>

                    <CardContent class="px-6 pt-6 sm:px-8">
                        <Form action="/login" method="POST" id="login-form" v-slot="{errors}" class="space-y-5">
                            <div class="space-y-2">
                                <Label class="text-sm font-medium" for="email">Email</Label>
                                <Input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="you@company.com"
                                    required
                                    class="h-11 rounded-xl"
                                />
                                <span class="text-xs text-red-400" v-if="errors.email">{{ errors.email }}</span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between gap-3">
                                    <Label class="text-sm font-medium" for="password">Password</Label>
                                    <span class="text-xs text-muted-foreground">Minimum 8 characters</span>
                                </div>
                                <InputGroup class="rounded-xl border">
                                    <InputGroupInput
                                        name="password"
                                        aria-required="true"
                                        id="password"
                                        :type="passwordVisible ? 'text' : 'password'"
                                        placeholder="Enter your password"
                                        class="h-11"
                                    />
                                    <InputGroupAddon align="inline-end">
                                        <InputGroupButton
                                            type="button"
                                            :aria-label="passwordVisible ? 'Hide Password' : 'Show Password'"
                                            :title="passwordVisible ? 'Hide Password' : 'Show Password'"
                                            size="icon-xs"
                                            class="mr-1 rounded-lg"
                                            @click="() => passwordVisible = !passwordVisible"
                                        >
                                            <EyeClosedIcon v-if="!passwordVisible" />
                                            <EyeIcon v-else />
                                        </InputGroupButton>
                                    </InputGroupAddon>
                                </InputGroup>
                                <span class="text-xs text-red-400" v-if="errors.password">{{ errors.password }}</span>
                            </div>

                            <span class="block rounded-xl bg-destructive/8 px-3 py-2 text-xs text-destructive" v-if="errors.error">
                                {{ errors.error }}
                            </span>
                        </Form>
                    </CardContent>

                    <CardFooter class="flex flex-col gap-4 px-6 pt-0 sm:px-8">
                        <Button form="login-form" class="h-11 w-full cursor-pointer rounded-xl">
                            <span>Log In</span>
                            <ArrowRight class="size-4" />
                        </Button>

                        <p class="text-center text-sm text-muted-foreground">
                            You don't have an account?
                            <Link class="font-medium text-primary underline-offset-4 hover:underline" href="/register">Register here</Link>
                        </p>
                    </CardFooter>
                </Card>
            </section>
        </div>
    </div>
</template>

<style scoped>

</style>
