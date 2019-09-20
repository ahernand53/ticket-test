<template>

    <v-card>
        <v-card-title justify="center">
            <h4>Editar Ticket</h4>
        </v-card-title>
        <v-card-text>
            <v-form
                ref="form"
                v-model="valid"
            >
                <v-container v-if="ticket && ticket.details">
                    <v-row>
                        <v-text-field
                            v-model="ticket.issue"
                            :counter="40"
                            label="Asunto"
                            :rules="[v => !!v || 'Debe colocar un asunto al ticket']"
                            required
                        ></v-text-field>
                    </v-row>

                    <v-row>
                        <v-textarea
                            v-model="ticket.details.task"
                            label="Tareas a ejecutar"
                            required
                            no-resize
                            :rules="[v => !!v || 'agregue tareas al ticket']"
                        ></v-textarea>
                    </v-row>

                    <v-row>
                        <v-col cols="4">
                            <v-select
                                v-model="ticket.priority"
                                prepend-icon="mdi-car-brake-alert"
                                :items="priorities"
                                :rules="[v => !!v || 'Seleccione una prioridad']"
                                label="Prioridad"
                                required
                            ></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select
                                v-model="ticket.user_assigned"
                                prepend-icon="mdi-account-arrow-right"
                                :items="users"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || 'Debe asignar un usuario']"
                                label="Usuario a asignar"
                                required>
                            </v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                :return-value.sync="ticket.assignation_date"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                                bottom
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="ticket.assignation_date"
                                        label="Fecha de asignacion"
                                        prepend-icon="mdi-calendar-range"
                                        readonly
                                        v-on="on"
                                        :rules="[v => !!v || 'Debe asignar una fecha al ticket']"
                                        required
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="ticket.assignation_date" no-title scrollable>
                                    <div class="flex-grow-1"></div>
                                    <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.menu.save(ticket.assignation_date)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                </v-container>

                <v-container
                    v-else
                    class="text-center">
                    <v-progress-circular
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </v-container>

            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-row>
                <v-col cols="6">
                    <router-link :to="{name: 'home'}" class="text-decoration-none">
                        <v-btn
                            color="error"
                            block
                        >
                            Cancelar
                        </v-btn>
                    </router-link>
                </v-col>
                <v-col cols="6">
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        block
                        @click="updateTicket"
                    >
                        Actualizar
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>

</template>

<script>
    import {mapMutations} from 'vuex'

    export default {
        name: "EditTicket",
        data() {
            return {
                loading: false,
                users: [],
                ticket: {},
                valid: true,
                menu: false,
                priorities: [
                    'ALTO',
                    'MEDIO',
                    'BAJO'
                ]
            }
        },
        methods: {
            ...mapMutations([
                'alertTicket'
            ]),
            getUsers() {
                let self = this
                axios.get('/api/users')
                    .then(data => {
                        self.users = data.data
                        self.loading = false
                    })
            },
            getTicket() {
                let self = this
                axios.get(`/api/tickets/${this.$route.params.id}`)
                    .then(response => {
                        self.ticket = response.data;
                    })
            },
            updateTicket() {
                let self = this
                this.loading = true
                axios.patch(`/api/tickets/${this.ticket.id}`, {
                    issue: this.ticket.issue,
                    priority: this.ticket.priority,
                    user_assigned: this.ticket.user_assigned,
                    task: this.ticket.details.task,
                    assignation_date: this.ticket.assignation_date
                })
                    .then(response => {
                        this.loading = false
                        self.alertTicket('Se ha actualizado satisfatoriamente');
                        self.$router.push({name: 'home'})  
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        mounted() {
            this.loading = true
            this.getUsers()
            this.getTicket()
        }
    }
</script>

<style scoped>

</style>
