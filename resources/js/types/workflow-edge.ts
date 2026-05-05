import type { EloquentModel } from "@/types/shared"
import type { WorkflowNode } from "@/types/workflow-node"
import type { Workflow } from "@/types/workflow"

export interface WorkflowEdge extends EloquentModel {
    workflow_id: number
    source_node_id: number
    target_node_id: number
    source_node_handle: string | null
    target_node_handle: string | null
    source_node?: WorkflowNode
    target_node?: WorkflowNode
    workflow?: Workflow
}
