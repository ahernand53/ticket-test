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
                            :counter="30"
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
                            :rules="[v => !!v || 'Debe agregar tareas al ticket']"
                        ></v-textarea>
                    </v-row>

                    <v-row>
                        <v-col cols="4">
                            <v-select
                                v-model="priority"
                                :items="priorities"
                                :rules="[v => !!v || 'Seleccione una prioridad']"
                                label="Prioridad"
                                required
                            ></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select
                                v-model="userAssigned"
                                :items="users"
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
                                :return-value.sync="date"
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                                bottom
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="date"
                                        label="Fecha de asignacion"
                                        prepend-icon="mdi-calendar-range"
                                        readonly
                                        v-on="on"
                                        :rules="[v => !!v || 'Debe asignar una fecha al ticket']"
                                        required
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="date" no-title scrollable>
                                    <div class="flex-grow-1"></div>
                                    <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
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
                    >
                        Crear Ticket
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>

</template>

<script>
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
                date: '',
                priorities: [
                    'Alta',
                    'Media',
                    'Baja'
                ],
                users: [
                    'User 1',
                    'User 2',
                    'User 3',
                    'User 4',
                    'User 5',
                    'User 6',
                ]
            }
        },
        computed: {
            user() {
                return JSON.parse(user.content)
            }
        }
    }
</script>

<style scoped>


</style>
