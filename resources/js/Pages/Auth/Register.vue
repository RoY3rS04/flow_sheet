<script setup>

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card/index.js";
import { Input } from "@/components/ui/input/index.js";
import { Button } from "@/components/ui/button/index.js";
import { Form, Link } from "@inertiajs/vue3";
import { ArrowRight, EyeClosedIcon, EyeIcon, Route as RouteIcon } from "lucide-vue-next";
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput } from "@/components/ui/input-group/index.js";
import { ref } from "vue";

const passwordVisible = ref(false);

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

                        <div class="space-y-2">
                            <CardTitle class="text-2xl font-semibold tracking-tight sm:text-3xl">
                                Create your account
                            </CardTitle>
                            <CardDescription class="max-w-sm text-sm leading-5">
                                Keep the setup simple now and start building inside FlowSheet right away.
                            </CardDescription>
                        </div>
                    </CardHeader>

                    <CardContent class="px-6 pt-4 sm:px-8">
                        <Form action="/register" method="POST" v-slot="{errors}" id="registration-form" class="space-y-4">
                            <div class="space-y-2">
                                <Label class="text-sm font-medium" for="username">Username</Label>
                                <Input
                                    required
                                    id="username"
                                    name="username"
                                    type="text"
                                    placeholder="Choose a username"
                                    class="h-11 rounded-xl"
                                />
                                <span class="text-xs text-red-400" v-if="errors.username">{{ errors.username }}</span>
                            </div>

                            <div class="space-y-2">
                                <Label class="text-sm font-medium" for="email">Email</Label>
                                <Input
                                    required
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="you@company.com"
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
                                        aria-required="true"
                                        name="password"
                                        id="password"
                                        :type="passwordVisible ? 'text' : 'password'"
                                        placeholder="Create a password"
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

                    <CardFooter class="flex flex-col gap-3 px-6 pt-0 sm:px-8">
                        <Button form="registration-form" class="h-11 w-full cursor-pointer rounded-xl">
                            <span>Register</span>
                            <ArrowRight class="size-4" />
                        </Button>

                        <p class="text-center text-sm text-muted-foreground">
                            Already have an account?
                            <Link class="font-medium text-primary underline-offset-4 hover:underline" href="/login">Log in here</Link>
                        </p>
                    </CardFooter>
                </Card>
            </section>
        </div>
    </div>
</template>

<style scoped>

</style>
