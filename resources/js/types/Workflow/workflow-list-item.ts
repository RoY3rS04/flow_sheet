export interface WorkflowListItem {
    id: number
    name: string
    description: string | null
    created_at: string
    last_run: string | null
}
