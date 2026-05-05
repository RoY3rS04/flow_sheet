import type { EloquentModel, SerializedJson } from "@/types/shared"
import type { User } from "@/types/user"
import type { WorkflowRun } from "@/types/workflow-run"

export interface Dataset extends EloquentModel {
    user_id: number
    filename: string
    file_url: string
    columns: SerializedJson | null
    columns_count: number
    row_count: number
    user?: User
    workflow_runs?: WorkflowRun[]
}
