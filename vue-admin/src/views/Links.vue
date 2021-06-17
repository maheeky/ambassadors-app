<template>
    <v-simple-table dark>
        <template v-slot:default>
        <thead class="table-head">
            <tr>
                <th class="text-left">#</th>
                <th class="text-left">Code</th>
                <th class="text-left">Count</th>
                <th class="text-left">Revenue</th>
            </tr>
        </thead>
        <tbody>
            <tr
            v-for="link in links"
            :key="link.id"
            >
                <td>{{ link.id }}</td>
                <td>{{ link.code }}</td>
                <td>{{ link.count }}</td>
                <td>{{ link.orders.length }}</td>     
                <td>{{ link.orders.reduce((s, o) => s + o.total, 0)  }}</td>       <!-- Initialise the int as 0, add each order total in array to the sum. -->
            </tr>
        </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Links',
        data() {
            return {
                links: [],
            }
        },
        async mounted() {
            const {data} = await axios.get(`users/${this.$route.params.id}/links`);

            this.links = data;
        }
    }
</script>