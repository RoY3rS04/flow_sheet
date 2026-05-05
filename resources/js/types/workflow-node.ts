import type { EloquentModel, SerializedJson } from "@/types/shared"
import type { WorkflowEdge } from "@/types/workflow-edge"
import type { Workflow } from "@/types/workflow"

export interface WorkflowNode extends EloquentModel {
    workflow_id: number
    node_key: string
    operation_key: string
    label: string | null
    position_x: string
    position_y: string
    config: SerializedJson
    in_edges?: WorkflowEdge[]
    out_edges?: WorkflowEdge[]
    workflow?: Workflow
}
