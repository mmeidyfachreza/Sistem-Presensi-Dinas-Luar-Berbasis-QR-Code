import { defineStore } from 'pinia'

// useStore could be anything like useUser, useCart
// the first argument is a unique id of the store across your application
export const usePresenceStore = defineStore('presence', {
    state: () => ({
        /** @type {string[]} */
        rawItems: 1,
        startTime: 'belum tercatat',
        endTime: 'belum tercatat',
        result: '',
        userId: '',
        show: true,
    }),
    actions: {
    async fetchUsers() {
        try {
            const data = await axios.get('/api/presensi')
            this.startTime = data.data.startTime
        }
            catch (error) {
            alert(error)
            console.log(error)
        }
    },
    /**
     * Add item to the cart
     * @param {string} name
     */
    addUserId(userId) {
        this.userId = userId
    },

    /**
     * Remove item from the cart
     * @param {string} name
     */
    removeItem(name) {
        const i = this.rawItems.lastIndexOf(name)
        if (i > -1) this.rawItems.splice(i, 1)
    },

    async purchaseItems() {
        const user = useUserStore()
        if (!user.name) return

        console.log('Purchasing', this.items)
        const n = this.items.length
        this.rawItems = []

        return n
    },
    },
})
