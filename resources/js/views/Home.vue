<template>

    <v-container>
        <v-row justify="center">

        </v-row>
        <v-row justify="center">
            <v-expansion-panels>
                <ticket v-for="ticket in tickets" :ticket="ticket" :key="tickets.id" ></ticket>
            </v-expansion-panels>
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

    export default {
        name: "Home",
        components: {
            Ticket
        },
        data() {
            return {
                tickets: []
            }
        },
        methods: {
            getTickets() {
                let self = this
                axios.get('/api/tickets')
                    .then(data => {
                        self.tickets = data.data.data
                    })
            },
            ...mapMutations([
                'closeAlert'
            ])
        },
        mounted() {
            this.getTickets()
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
