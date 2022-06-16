import { defineStore } from 'pinia'

// useStore could be anything like useUser, useCart
// the first argument is a unique id of the store across your application
export const usePresenceStore = defineStore('presence', {
    state: () => ({
        /** @type {string[]} */
        startTime: 'belum tercatat',
        endTime: 'belum tercatat',
        result: '',
        userId: '',
        show: true,
        camera: 'auto',
        showScanConfirmation: false
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

    isPresence() {
        return (this.startTime=='belum tercatat')? false : true
    },
    completePresence() {
        return (this.startTime!='belum tercatat' && this.endTime!='belum tercatat')? true : false
    },
    activeScanner(){
        this.show = true
    },
    unpause () {
        this.camera = 'auto'
    },

    pause () {
        this.camera = 'off'
    },

    timeout (ms) {
        return new Promise(resolve => {
            window.setTimeout(resolve, ms)
        })
    }
    },
})
