<script setup>

import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card/index.js";
import {Input} from "@/components/ui/input/index.js";
import {Button} from "@/components/ui/button/index.js";
import {Form, Link} from "@inertiajs/vue3";
import {RouteIcon, EyeIcon, EyeClosedIcon} from "lucide-vue-next";
import {InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput} from "@/components/ui/input-group/index.js";
import {ref} from "vue";

function handleSubmit(e) {
    e.preventDefault();
}

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
                        Welcome Back
                    </CardTitle>
                    <CardDescription>
                        Fill the inputs below in order to get into your FlowSheet account
                    </CardDescription>
                </div>
            </CardHeader>
            <CardContent>
                <Form action="/login" method="POST" id="login-form" v-slot="{errors}" class="space-y-4">
                    <div>
                        <Label class="text-sm" for="email">Email</Label>
                        <Input id="email" name="email" type="email" placeholder="Email" required/>
                        <span class="text-xs text-red-400" v-if="errors.email">{{errors.email}}</span>
                    </div>
                    <div>
                        <Label class="text-sm" for="password">Password</Label>
                        <InputGroup>
                            <InputGroupInput name="password" aria-required="true" id="password" :type="passwordVisible ? 'text' : 'password'" placeholder="Password"/>
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
                    <span class="block mt-3 text-xs text-red-400">{{errors.error}}</span>
                </Form>
            </CardContent>
            <CardFooter class="flex flex-col gap-y-2">
                <Button form="login-form" class="w-full cursor-pointer">Log In</Button>
                <p class="text-sm">
                    You don't have an account? Register
                    <Link class="underline text-blue-500" href="/register">here</Link>
                </p>
            </CardFooter>
        </Card>
    </div>
</template>

<style scoped>

</style>
