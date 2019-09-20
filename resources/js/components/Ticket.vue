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
                    {{ ticket.assignation_date }}
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
                        Fecha assignada <span class="badge">{{ ticket.assignation_date }}</span>
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
                            {{ ticket.user_assigned.name }}
                        </v-chip>
                    </v-col>
                </v-row>
                <v-dialog v-model="alertClose" max-width="500">
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
                            <v-btn color="green darken-1" text @click="alertClose = false">Cancelar</v-btn>
                            <v-btn
                                color="error"
                                @click="this.closeTicket"
                                :disabled="!validateToClose"
                            >
                                Cerrar Ticket
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="alertDelete" max-width="500">
                    <v-card>
                        <v-card-title class="headline">Desea eliminar el ticket?</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col>
                                    <v-btn
                                        color="green darken-1"
                                        text
                                        block
                                        @click="alertDelete = false">
                                        Cancelar
                                    </v-btn>
                                </v-col>
                                <v-col>
                                    <v-btn
                                        color="error"
                                        block
                                        @click="deleteTicket()"
                                    >
                                        Eliminar Ticket
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                <v-speed-dial
                    open-on-hover
                    absolute
                    bottom
                    fab
                    right
                    v-if="isAssigned() || isYours()"
                >
                    <template v-slot:activator>
                        <v-btn
                            color="blue darken-2"
                            dark
                            small
                            fab
                        >
                            <v-icon>mdi-tools</v-icon>
                        </v-btn>
                    </template>

                    <v-btn
                        v-if="ticket.state && isAssigned() || ticket.state && isYours()"
                        dark
                        small
                        fab
                        color="error"
                        @click="alertClose = true"
                    >
                        <v-icon>mdi-lock</v-icon>
                    </v-btn>
                    <v-btn
                        v-if="ticket.state && isYours()"
                        dark
                        small
                        fab
                        class="text-decoration-none"
                        color="warning"
                        :to="`/editar/${ticket.id}`"
                    >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn
                        v-if="!ticket.state && isYours() || !ticket.state && isAssigned()"
                        dark
                        small
                        fab
                        color="red"
                        @click="alertDelete = true"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </v-speed-dial>
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
                alertClose: false,
                validateToClose: false,
                concluding_remarks: '',
                alertDelete: false
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
                return user.content;
            },
            isYours() {
                return user.content && JSON.parse(user.content).id === this.ticket.user.id;
            },
            isAssigned() {
                return  user.content && JSON.parse(user.content).id === this.ticket.user_assigned.id
            },
            closeTicket() {
                let self = this
                axios.post(`/api/tickets/${this.ticket.id}/close`, {
                    concluding_remarks: this.concluding_remarks
                })
                    .then(data => {
                        self.ticket.details.concluding_remarks = data.data[0].details.concluding_remarks
                        self.alertClose = false
                    })
                this.ticket.state = false
                this.alertTicket('Ticket cerrado exitosamente')
            },
            deleteTicket() {
                let self = this
                axios.delete(`/api/tickets/${self.ticket.id}`)
                    .then(response => {
                        self.alertDelete = false
                        self.alertTicket('El ticket ha sido eliminado exitosamente')
                        this.$router.go()
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        computed: {
            ...mapState([
                'ticketClosed'
            ])
        }
    }
</script>
