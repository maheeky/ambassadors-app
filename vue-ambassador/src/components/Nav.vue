<template>
<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Frontend</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Backend</a></li>
        </ul>

        <div class="text-end" v-if="user">
          <a href="#" type="button" class="btn btn-outline-light me-2" @click="logout">Logout</a>
          <router-link to="/profile" class="btn btn-warning">{{ user.first_name }} {{ user.last_name }}</router-link>
        </div>

        <div class="text-end" v-if="!user">
          <router-link to="/login" class="btn btn-outline-light me-2">Login</router-link>
          <router-link to="/register" class="btn btn-warning">Sign-up</router-link>
        </div>

      </div>
    </div>
  </header>
</template>

<script>
    import {useStore} from 'vuex';
    import {computed} from 'vue';
    import axios from 'axios';

    export default {
        name: 'Nav',
        setup() {
            const store = useStore();
            const user = computed(() => store.state.user ); //Return the state's user from the computed callback. 

            const logout = async () => { 
                await axios.post('logout');
            }
            return {
                user,
                logout
            }
        }
    }
</script>

<style scoped>

</style>