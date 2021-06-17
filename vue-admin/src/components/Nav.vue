<template>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>

    <nav class="navbar-nav px-3">
        <router-link to="/profile" href="#" class="p-2 text-white text-decoration-none">
            {{ user.first_name }} {{ user.last_name }}
        </router-link>
        <a class="nav-link" href="#" @click="logout">Sign out</a>
    </nav>
    </header>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Nav',
        methods: {
            async logout() {
                await axios.post('logout', {});

                await this.$router.push('/login');
            }
        },
        computed: {
            user() {
                return this.$store.state.user;  //Fetching the User data from the VueX store. 
            }
        }
    }
</script>