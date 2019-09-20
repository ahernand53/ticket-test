<template>
    <v-expansion-panel>
        <v-expansion-panel-header disable-icon-rotate >
            <v-row no-gutters>
                <v-col
                cols="6"
                self="center">
                    {{ ticket.issue }}
                </v-col>
                <v-col
                cols="4">
                    {{ ticket.assignationDate }}
                </v-col>
                <v-col
                cols="2">
                    <v-fade-transition leave-absolute>
                        <v-chip
                        small
                        :color="priorityColor()"
                        text-color="#fff">
                            <v-icon
                            small
                            left>
                                mdi-label
                            </v-icon>
                            {{ ticket.priority }}
                        </v-chip>
                    </v-fade-transition>
                </v-col>
            </v-row>

            <template v-slot:actions>
                <v-icon color="#66BB6A" v-if="ticket.state">mdi-lock-open-variant</v-icon>
                <v-icon color="#EF5350" v-else>mdi-lock</v-icon>
            </template>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
            <v-container>
                <v-row justify="center">
                    <v-card>
                        <v-card-text>
                            <p class="display-1 text--accent-1 text-center">
                                Tareas
                            </p>
                            <p class="text--darken">
                                {{ ticket.details.task }}
                            </p>
                        </v-card-text>
                        <v-card-actions v-if="!ticket.state" class="d-block">
                            <v-alert
                                border="left"
                                colored-border
                                color="deep-purple"
                            >
                                <p class="text--accent-3 text--secondary">Observaciones</p>
                                <p>{{ ticket.details.concluding_remarks }}</p>
                            </v-alert>
                        </v-card-actions>
                    </v-card>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col
                        cols="5">
                        Fecha assignada <span class="badge">{{ ticket.assignationDate }}</span>
                    </v-col>
                    <v-col
                        cols="3">
                        Estado
                        <v-chip
                            v-if="ticket.state"
                            small
                            color="success"
                            text-color="#fff">
                            Abierto
                        </v-chip>
                        <v-chip
                            v-else
                            small
                            color="error"
                            text-color="#fff">
                            Cerrado
                        </v-chip>
                    </v-col>
                    <v-col
                        cols="4">
                        <v-chip
                            small
                            label>
                            {{ ticket.user.name }}
                        </v-chip>
                    </v-col>
                </v-row>
                <v-dialog v-if="ticket.state && isLogged()" v-model="dialog" persistent max-width="500">
                    <template v-slot:activator="{ on }">
                        <v-btn
                            id="close-ticket"
                            v-on="on"
                            absolute
                            dark
                            fab
                            botton
                            right
                            small
                            color="#EF5350"
                        >
                            <v-icon>mdi-lock</v-icon>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title class="headline">Desea cerrar el ticket?</v-card-title>
                        <v-card-text>
                            <v-form
                                v-model="validateToClose">
                                <v-textarea
                                    v-model="concluding_remarks"
                                    solo
                                    auto-grow
                                    placeholder="Observaciones..."
                                    required
                                    :rules="[v => !!v || 'Debe agregar Observaciones antes de cerrar']"
                                >
                                </v-textarea>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <div class="flex-grow-1"></div>
                            <v-btn color="green darken-1" text @click="dialog = false">Cancelar</v-btn>
                            <v-btn
                                color="green darken-1"
                                text
                                @click="this.closeTicket"
                                :disabled="!validateToClose"
                            >
                                Cerrar Ticket
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>

<script>
    import {mapState, mapMutations} from "vuex";

    let user = document.head.querySelector('meta[name="user"]')

    export default {
        name: "Ticket",
        props: [
            'ticket'
        ],
        data() {
            return {
                dialog: false,
                validateToClose: false,
                concluding_remarks: ''
            }
        },
        methods: {
            ...mapMutations([
                'alertTicket'
            ]),
            priorityColor() {
                if (this.ticket.priority === 'ALTO') {
                    return 'error'
                } else if (this.ticket.priority === 'MEDIO') {
                    return 'warning'
                } else {
                    return 'gray'
                }
            },
            isLogged() {
                return user.content && JSON.parse(user.content).name === this.ticket.user.name
            },
            closeTicket() {
                let self = this
                this.dialog = false
                axios.post(`/api/tickets/${this.ticket.id}/close`, {
                    concluding_remarks: this.concluding_remarks
                })
                    .then(data => {
                        self.ticket.details.concluding_remarks = data.data[0].details.concluding_remarks
                    })
                this.ticket.state = false
                this.alertTicket('Ticket cerrado exitosamente')
            }
        },
        computed: {
            ...mapState([
                'ticketClosed'
            ])
        }
    }
</script>

<style scoped lang="scss">

</style>
