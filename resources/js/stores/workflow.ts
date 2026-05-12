import {Edge, Node, useVueFlow} from '@vue-flow/core'
import {NodeType} from "@/types/Workflow/nodeTypes";

type WorkflowNodeData = Record<string, unknown>

export function useWorkflowStore() {
    const {
        addNodes,
        removeNodes,
        findNode,
        findEdge,
        removeEdges,
        updateNodeData,
        addEdges,
        nodes,
        edges,
    } = useVueFlow();

    function addNode(node: Node<WorkflowNodeData>) {
        const type = node.type as NodeType;

        if (type !== NodeType.Filter && workflowHasNodeType(type)) {
            return;
        }

        addNodes(node);
    }

    function getNode(nodeId: string): Node<WorkflowNodeData> | null {
        return findNode(nodeId) ?? null;
    }

    function removeEdge(edgeId: string) {
        const edge = findEdge(edgeId);

        if (!edge) {
            return;
        }

        removeEdges(edge);
    }

    function changeNodeState(nodeId: string, data: Partial<WorkflowNodeData>) {
        const node = findNode(nodeId);

        if (!node) {
            return;
        }

        updateNodeData(node.id, data);
    }

    function addEdge(edge: Edge) {

        if (edges.value.find(edgeIter => edgeIter.id === edge.id)) {
            return
        }

        addEdges(edge);
    }

    function getInputNode(): Node<WorkflowNodeData> | null {
        return nodes.value.find(node => node.type === NodeType.Input) ?? null;
    }

    function getOutputNode(): Node<WorkflowNodeData> | null {
        return nodes.value.find(node => node.type === NodeType.Output) ?? null;
    }

    function workflowHasNodeType(type: NodeType): boolean {
        return nodes.value.some((node) => (node.type as NodeType) === type);
    }

    return {
        nodes,
        edges,
        addNode,
        addEdge,
        getNode,
        removeEdge,
        changeNodeState,
        getInputNode,
        getOutputNode
    }
}
