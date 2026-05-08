import type { EloquentModel } from "@/types/shared"
import type { User } from "@/types/user"
import type { WorkflowEdge } from "@/types/workflow-edge"
import type { WorkflowNode } from "@/types/workflow-node"
import type { WorkflowRun } from "@/types/workflow-run"

export interface Workflow extends EloquentModel {
    user_id: number
    name: string
    description: string | null
    user?: User
    nodes?: WorkflowNode[]
    workflow_runs?: WorkflowRun[]
    edges?: WorkflowEdge[]
}

export const AvailableOperatorsForColumnType = {
    string: ['>', '<', '>=', '<=', '=', 'startsWith', 'endsWith', 'contains', 'notNull'],
    integer: ['>', '<', '>=', '<=', '=', 'notNull'],
    float: ['>', '<', '>=', '<=', '=', 'notNull'],
}
