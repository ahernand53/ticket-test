<template>

    <v-card>
        <v-card-title justify="center">
            <h4>Crear nuevo ticket</h4>
        </v-card-title>
        <v-card-text>
            <v-form
                ref="form"
                v-model="valid"
            >
                <v-container>
                    <v-row>
                        <v-text-field
                            v-model="issue"
                            :counter="40"
                            label="Asunto"
                            :rules="[v => !!v || 'Debe colocar un asunto al ticket']"
                            required
                        ></v-text-field>
                    </v-row>

                    <v-row>
                        <v-textarea
                            v-model="tasks"
                            label="Tareas a ejecutar"
                            required
                            no-resize
                            :rules="[v => !!v || 'agregue tareas al ticket']"
                        ></v-textarea>
                    </v-row>

                    <v-row>
                        <v-col cols="4">
                            <v-select
                                v-model="priority"
                                prepend-icon="mdi-car-brake-alert"
                                :items="priorities"
                                :rules="[v => !!v || 'Seleccione una prioridad']"
                                label="Prioridad"
                                required
                            ></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select
                                v-model="userAssigned"
                                prepend-icon="mdi-account-arrow-right"
                                :hint="`${userAssigned.name}, ${userAssigned.id}`"
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
                                :return-value.sync="assignationDate"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                                bottom
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="assignationDate"
                                        label="Fecha de asignacion"
                                        prepend-icon="mdi-calendar-range"
                                        readonly
                                        v-on="on"
                                        :rules="[v => !!v || 'Debe asignar una fecha al ticket']"
                                        required
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="assignationDate" no-title scrollable>
                                    <div class="flex-grow-1"></div>
                                    <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.menu.save(assignationDate)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
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
                        @click="addTicket"
                    >
                        Crear Ticket
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>

</template>

<script>
    import {mapMutations} from 'vuex'

    let user = document.head.querySelector('meta[name="user"]');

    export default {
        name: "CreateTicket",
        data() {
            return {
                userAssigned: '',
                valid: true,
                issue: '',
                priority: '',
                tasks: '',
                menu: false,
                assignationDate: '',
                priorities: [
                    'ALTO',
                    'MEDIO',
                    'BAJO'
                ],
                users: []
            }
        },
        computed: {
            user() {
                return JSON.parse(user.content)
            }
        },
        methods: {
            ...mapMutations([
                'alertTicket'
            ]),
            addTicket() {
                let self = this
                axios.post('/api/tickets/', {
                    issue: this.issue,
                    priority: this.priority,
                    user: this.userAssigned,
                    task: this.tasks,
                    assignationDate: this.assignationDate
                })
                    .catch(error => {
                        console.log(error)
                    })
                this.$router.push({name: 'home'})
                self.alertTicket('Se ha creado exitosamente el ticket')
            },
            getUsers() {
                let self = this
                axios.get('/api/users')
                    .then(data => {
                        self.users = data.data
                    })
            }
        },
        mounted() {
            this.getUsers()
        }
    }
</script>

<style scoped>


</style>
