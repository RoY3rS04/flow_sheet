import type { Dataset } from "@/types/dataset"
import type { EloquentModel } from "@/types/shared"
import type { Workflow } from "@/types/workflow"
import type { WorkflowRun } from "@/types/workflow-run"

export interface User extends EloquentModel {
    username: string
    email: string
    email_verified_at: string | null
    datasets?: Dataset[]
    workflows?: Workflow[]
    workflow_runs?: WorkflowRun[]
}
