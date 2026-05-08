import {ref, watch} from 'vue'
import type { Edge, Node } from '@vue-flow/core'
import {NodeType} from "@/types/Workflow/nodeTypes";

type WorkflowNodeData = Record<string, unknown>

const nodes = ref<Node<WorkflowNodeData>[]>([]);
const edges = ref<Edge[]>([]);

function addNode(node: Node<WorkflowNodeData>) {

    if(
        (node.type as NodeType) === NodeType.Input
        && workflowHasNodeType(NodeType.Input)
    ) {
        return;
    }

    if(
        (node.type as NodeType) === NodeType.Output
        && workflowHasNodeType(NodeType.Output)
    ) {
        return;
    }

    nodes.value.push(node)
}

function changeNodeState(nodeId: string, data: Partial<WorkflowNodeData>) {

    const node = nodes.value.find((node) => node.id === nodeId);

    if (!node) {
        return
    }

    node.data = {
        ...(node.data ?? {}),
        ...data
    }
}

function addEdge(edge: Edge) {
    edges.value.push(edge)
}

function getInputNode(): Node<WorkflowNodeData> {
    return nodes.value.find(node => node.type === NodeType.Input)
}

function getOutputNode(): Node {
    return nodes.value.find(node => node.type === NodeType.Output)
}

function workflowHasNodeType(type: NodeType): boolean {
    return nodes.value.some((node) => (node.type as NodeType) === type)
}

export function useWorkflowStore() {
    return {
        nodes,
        edges,
        addNode,
        addEdge,
        changeNodeState,
        getInputNode,
        getOutputNode
    }
}
