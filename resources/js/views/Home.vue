<template>

    <v-container>
        <v-row justify="center">

        </v-row>
        <v-row justify="center">
            <v-expansion-panels>
                <ticket :open="true"></ticket>
                <ticket :open="false"></ticket>
            </v-expansion-panels>
        </v-row>
    </v-container>

</template>

<script>

    import Ticket from "../components/Ticket";

    export default {
        name: "Home",
        components: {
            Ticket
        },
    }
</script>

<style scoped lang="scss">

</style>
