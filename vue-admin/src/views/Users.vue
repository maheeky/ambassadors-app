<template>

  <v-simple-table dark>
    <template v-slot:default>
      <thead class="table-head">
        <tr>
            <th class="text-left">#</th>
            <th class="text-left">Name</th>
            <th class="text-left">Email</th>
            <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users"
          :key="user.id"
        >
            <td>{{user.id}}</td>
            <td>{{user.first_name }}{{ user.last_name }}</td>
            <td>{{user.email}}</td>
            <td>
                <v-btn :href="`/users/${user.id}/links`" color="primary" elevation="2">View</v-btn>
            </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Users',
        data() {
            return {
                users: []
            }
        },
        async mounted() {
            const {data} = await axios.get('ambassadors');

            this.users = data;
        }
    }
</script>

<style scoped>
    .table-head {
        margin-top: 2.5em;
    }
</style>