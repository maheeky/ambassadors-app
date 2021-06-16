<template>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>

    <nav class="navbar-nav px-3">
        <a href="#" class="p-2 text-white text-decoration-none">{{ user.first_name }} {{ user.last_name }}</a>
        <a class="nav-link" href="#">Sign out</a>
    </nav>
    </header>
</template>

<script>
    export default {
        name: 'Nav',
        props: ['user']
    }
</script>