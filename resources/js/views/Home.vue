<template>

    <v-container>
        <v-row>
            <v-snackbar
            v-model="user"
            :timeout="0"
            top
            color="warning"
        >
            <v-icon
            mdi
            left
            color="white"
            >
                mdi-account-clock
            </v-icon>
            Inicie session para acceder al control de los tickets
        </v-snackbar>
        </v-row>

        <v-row justify="center" v-if="!isLoading">
            <v-expansion-panels>
                <ticket v-for="ticket in tickets" :key="ticket.id" :ticket="ticket"></ticket>
            </v-expansion-panels>
        </v-row>

        <v-row justify="center" v-else>
            <v-progress-circular
                    
                    indeterminate
                    color="primary"
                ></v-progress-circular>
        </v-row>

        <v-snackbar
            v-model="this.ticketClosed"
            :timeout="0"
            top
        >
            {{ message }}
            <v-btn
                color="pink"
                text
                @click="this.closeAlert"
            >
                Cerrar
            </v-btn>
        </v-snackbar>
    </v-container>

</template>

<script>

    import Ticket from "../components/Ticket";
    import {mapState, mapMutations} from "vuex";

    let user = document.head.querySelector('meta[name="user"]')

    export default {
        name: "Home",
        components: {
            Ticket
        },
        data() {
            return {
                tickets: [],
                isLoading: false,
                user: false
            }
        },
        methods: {
            ...mapMutations([
                'closeAlert'
            ]),
            getTickets() {
                let self = this
                this.isLoading = true
                axios.get('/api/tickets')
                    .then(data => {
                        self.tickets = data.data.data
                        self.isLoading = false
                    })
            },
            isLogged() {
                this.user = user.content && JSON.parse(user.content).id ? false : true
            }
        },
        mounted() {
            this.getTickets()
            this.isLogged()
        },
        computed: {
            ...mapState([
                'ticketClosed',
                'message'
            ])
        }
    }
</script>

<style scoped lang="scss">

</style>
