<script setup>

import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card/index.js";
import {Input} from "@/components/ui/input/index.js";
import {Button} from "@/components/ui/button/index.js";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="w-full h-full flex items-center justify-center">
        <Card class="w-full max-w-sm">
            <CardHeader>
                <CardTitle>
                    Registration Form
                </CardTitle>
                <CardDescription>
                    Fill the inputs below in order to create your FlowSheet account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form class="space-y-4">
                    <div>
                        <Label id="username">Username</Label>
                        <Input id="username" type="text" placeholder="Username"/>
                    </div>
                    <div>
                        <Label id="email">Email</Label>
                        <Input id="email" type="email" placeholder="Your Email"/>
                    </div>
                    <div>
                        <Label for="password">Password</Label>
                        <Input id="password" type="password" placeholder="Your Password"/>
                    </div>
                </form>
            </CardContent>
            <CardFooter class="flex flex-col gap-y-2">
                <Button class="w-full cursor-pointer">Register</Button>
                <p class="text-sm">
                    Already have an account? Sign up
                    <Link class="underline text-blue-500" href="/login">here</Link>
                </p>
            </CardFooter>
        </Card>
    </div>
</template>

<style scoped>

</style>
