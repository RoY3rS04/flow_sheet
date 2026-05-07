export const workflowOperationKeys = [
    "filtering",
    "selecting",
    "limiting",
] as const

export type WorkflowOperationKey = typeof workflowOperationKeys[number]

export type WorkflowFilterOperator =
    | "equals"
    | "not_equals"
    | "contains"
    | "starts_with"
    | "ends_with"
    | "greater_than"
    | "greater_than_or_equal"
    | "less_than"
    | "less_than_or_equal"
    | "is_empty"
    | "is_not_empty"

export type WorkflowFilterValue = boolean | number | string | null

export interface WorkflowFilteringConfig {
    column: string
    operator: WorkflowFilterOperator
    value?: WorkflowFilterValue
}

export interface WorkflowSelectingConfig {
    columns: string[]
}

export interface WorkflowLimitingConfig {
    limit: number
    offset?: number | null
}

export interface WorkflowOperationConfigMap {
    filtering: WorkflowFilteringConfig
    selecting: WorkflowSelectingConfig
    limiting: WorkflowLimitingConfig
}

export type WorkflowOperationConfig = WorkflowOperationConfigMap[WorkflowOperationKey]
