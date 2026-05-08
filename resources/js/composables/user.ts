export function useUser() {
    return {
        userId: localStorage.getItem('userId')
    }
}
