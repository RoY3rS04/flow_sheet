import type { Dataset } from "@/types/dataset"
import type { EloquentModel } from "@/types/shared"
import type { Workflow } from "@/types/workflow"

export interface WorkflowRun extends EloquentModel {
    workflow_id: number
    dataset_id: number
    status: string
    started_at: string | null
    finished_at: string | null
    output_path: string | null
    input_row_count: number | null
    output_row_count: number | null
    error_message: string | null
    dataset?: Dataset
    workflow?: Workflow
}
