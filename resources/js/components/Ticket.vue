<template>
    <v-expansion-panel>
        <v-expansion-panel-header disable-icon-rotate >
            <v-row no-gutters>
                <v-col
                cols="6"
                self="center">
                    Asunto del ticket
                </v-col>
                <v-col
                cols="4">
                    18/09/2018
                </v-col>
                <v-col
                cols="2">
                    <v-fade-transition leave-absolute>
                        <v-chip
                        small
                        color="#EF5350"
                        text-color="#fff">
                            <v-icon
                            small
                            left>
                                mdi-label
                            </v-icon>
                            Alta
                        </v-chip>
                    </v-fade-transition>
                </v-col>
            </v-row>

            <template v-slot:actions>
                <v-icon color="#66BB6A" v-if="open">mdi-alert-circle</v-icon>
                <v-icon color="#EF5350" v-else>mdi-lock</v-icon>
            </template>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
            <v-container>
                <v-row justify="center">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam consequuntur, dignissimos dolore, ea fuga incidunt ipsam libero maxime modi nostrum nulla numquam possimus quae quas qui quibusdam quidem quod similique?
                </v-row>
                <v-row>
                    <v-col
                        cols="3">
                        Prioridad
                        <v-chip
                            small
                            color="#EF5350"
                            text-color="#fff">
                            <v-icon small left>mdi-label</v-icon>
                            Alta
                        </v-chip>
                    </v-col>
                    <v-col
                        cols="3">
                        Fecha <b>18/09/2018</b>
                    </v-col>
                    <v-col
                        cols="3">
                        Estado
                        <v-chip
                            small
                            color="#66BB6A"
                            text-color="#fff">
                            Abierto
                        </v-chip>
                    </v-col>
                    <v-col
                        cols="3">
                        <v-chip
                            small
                            label>
                            Asdrubal Hernandez
                        </v-chip>
                    </v-col>
                </v-row>
                <v-dialog v-on="on" v-model="dialog" persistent max-width="500">
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
                            <v-textarea solo auto-grow placeholder="Observaciones..."></v-textarea>
                        </v-card-text>
                        <v-card-actions>
                            <div class="flex-grow-1"></div>
                            <v-btn color="green darken-1" text @click="dialog = false">Cancelar</v-btn>
                            <v-btn color="green darken-1" text @click="dialog = false">Cerrar Ticket</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>

<script>
    export default {
        name: "Ticket",
        props: [
            'open'
        ],
        data() {
            return {
                dialog: false
            }
        }
    }
</script>

<style scoped lang="scss">

</style>
