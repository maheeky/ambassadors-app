<template>
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link" active-class="active">
                        Users
                    </router-link>
                    <router-link to="/products" class="nav-link" active-class="active">
                        Products
                    </router-link>
                    <router-link to="/orders" class="nav-link" active-class="active">
                        Orders
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>    
</template>

<script>
    export default {
        name: "Menu"
    }
</script>

<style scoped>
    .nav-link {
        margin-top: 1.25em;
        font-size: 1.25em;
        font-weight: 550em;
    }
    #sidebarMenu {
        margin-top: 2.5em;
    }
</style>