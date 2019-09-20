import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)


export default new Vuex.Store({

    state: {
        ticketClosed: false,
        message: ''
    },
    mutations: {
        alertTicket(state, message) {
            state.message = message
            state.ticketClosed = true
        },
        closeAlert(state) {
            state.ticketClosed = false
        }
    }

})
