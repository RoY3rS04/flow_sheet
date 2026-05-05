<script setup lang="ts">

import {Dataset} from "@/types/Dataset/dataset";
import AppLayout from "@/Layout/AppLayout.vue";
import {Card, CardAction, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";


const {dataset, userId} = defineProps<{
      dataset: Dataset,
      userId: number
  }>();

</script>

<template>
    <AppLayout :userId="userId">
        <Card>
            <CardHeader>
                <CardTitle>
                    {{ dataset.filename }}
                </CardTitle>
                <CardAction>
                    <Button>Delete Dataset</Button>
                </CardAction>
                <CardDescription>
                    <ul>
                        <li>Total rows: {{ dataset.row_count }}</li>
                        <li>Total columns: {{ dataset.columns_count }}</li>
                    </ul>
                </CardDescription>
            </CardHeader>
        </Card>
    </AppLayout>
</template>
