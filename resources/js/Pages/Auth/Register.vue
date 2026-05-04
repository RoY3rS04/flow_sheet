<script setup>

import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card/index.js";
import {Input} from "@/components/ui/input/index.js";
import {Button} from "@/components/ui/button/index.js";
import {Form, Link} from "@inertiajs/vue3";
import {EyeClosedIcon, EyeIcon, Route as RouteIcon} from 'lucide-vue-next';
import {InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput} from "@/components/ui/input-group/index.js";
import {ref} from "vue";

const passwordVisible = ref(false);

</script>

<template>
    <div class="w-full h-full flex items-center justify-center">
        <Card class="w-full max-w-sm">
            <CardHeader>
                <div class="flex flex-col items-center justify-center gap-y-2">
                    <span class="text-xl font-bold">FlowSheet</span>
                    <RouteIcon class="size-10"></RouteIcon>
                </div>
                <div class="mt-4 space-y-1">
                    <CardTitle>
                        Registration Form
                    </CardTitle>
                    <CardDescription>
                        Fill the inputs below in order to create your FlowSheet account
                    </CardDescription>
                </div>
            </CardHeader>
            <CardContent>
                <Form action="/register" method="POST" v-slot="{errors}" id="registration-form" class="space-y-4">
                    <div>
                        <Label class="text-sm" for="username">Username</Label>
                        <Input required id="username" name="username" type="text" placeholder="Username"/>
                        <span class="text-xs text-red-400" v-if="errors.username">{{errors.username}}</span>
                    </div>
                    <div>
                        <Label class="text-sm" for="email">Email</Label>
                        <Input required id="email" name="email" type="email" placeholder="Your Email"/>
                        <span class="text-xs text-red-400" v-if="errors.email">{{errors.email}}</span>
                    </div>
                    <div>
                        <Label class="text-sm" for="password">Password</Label>
                        <InputGroup>
                            <InputGroupInput aria-required="true" name="password" id="password" :type="passwordVisible ? 'text' : 'password'" placeholder="Password"/>
                            <InputGroupAddon align="inline-end">
                                <InputGroupButton
                                    type="button"
                                    :aria-label="passwordVisible ? 'Hide Password': 'Show Password'"
                                    :title="passwordVisible ? 'Hide Password': 'Show Password'"
                                    size="icon-xs"
                                    @click="() => passwordVisible = !passwordVisible"
                                >
                                    <EyeClosedIcon v-if="!passwordVisible"/>
                                    <EyeIcon v-if="passwordVisible"/>
                                </InputGroupButton>
                            </InputGroupAddon>
                        </InputGroup>
                        <span class="text-xs text-red-400" v-if="errors.password">{{errors.password}}</span>
                    </div>
                </Form>
            </CardContent>
            <CardFooter class="flex flex-col gap-y-2">
                <Button form="registration-form" class="w-full cursor-pointer">Register</Button>
                <p class="text-sm">
                    Already have an account? Log in
                    <Link class="underline text-blue-500" href="/login">here</Link>
                </p>
            </CardFooter>
        </Card>
    </div>
</template>

<style scoped>

</style>
