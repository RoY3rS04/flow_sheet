import type { EloquentModel } from "@/types/shared"
import type { WorkflowEdge } from "@/types/workflow-edge"
import type { Workflow } from "@/types/workflow"
import type {
    WorkflowFilteringConfig,
    WorkflowLimitingConfig,
    WorkflowOperationKey,
    WorkflowSelectingConfig,
} from "@/types/workflow-operation"

interface WorkflowNodeBase extends EloquentModel {
    workflow_id: number
    node_key: string
    label: string | null
    position_x: string
    position_y: string
    in_edges?: WorkflowEdge[]
    out_edges?: WorkflowEdge[]
    workflow?: Workflow
}

export interface WorkflowFilteringNode extends WorkflowNodeBase {
    operation_key: Extract<WorkflowOperationKey, "filtering">
    config: WorkflowFilteringConfig
}

export interface WorkflowSelectingNode extends WorkflowNodeBase {
    operation_key: Extract<WorkflowOperationKey, "selecting">
    config: WorkflowSelectingConfig
}

export interface WorkflowLimitingNode extends WorkflowNodeBase {
    operation_key: Extract<WorkflowOperationKey, "limiting">
    config: WorkflowLimitingConfig
}

export type WorkflowNode =
    | WorkflowFilteringNode
    | WorkflowSelectingNode
    | WorkflowLimitingNode
