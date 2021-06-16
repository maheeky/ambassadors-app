<template>
  <form class="form-signin" @submit.prevent="submit"> <!-- Prevent submission of form, and call method. -->
    <h1 class="h3 mb-3 font-weight-normal">Please register</h1>

    <label for="first_name" class="sr-only">First Name</label>
    <input type="text" id="first_name" class="form-control" placeholder="First Name" required v-model="firstName">

    <label for="last_name" class="sr-only">Last Name</label>
    <input type="text" id="last_name" class="form-control" placeholder="Last Name" required v-model="lastName">

    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required v-model="email">

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required v-model="password">

    <label for="passwordConfirm" class="sr-only">Password Confirm</label>
    <input type="password" id="passwordConfirm" class="form-control" placeholder="Password Confirm" required
           v-model="passwordConfirm">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
    name: "Register",
    data() {
      return {
          first_name: '',
          last_name: '',
          email: '',
          password: '',
          password_confirm: '',
      }
    },
    methods: {
       async submit() {
        await axios.post('register', {
          first_name: this.firstName,
          last_name: this.lastName,
          email: this.email,
          password: this.password,
          password_confirm: this.passwordConfirm,
        });

        await this.$router.push('/login');
      }
    }
}
</script>

<style scoped>
   html,
    body {
    height: 100%;
    }

    body {
    display: flex;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
    }

    .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
    }

    .form-signin .checkbox {
    font-weight: 400;
    }

    .form-signin .form-floating:focus-within {
    z-index: 2;
    }

    .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    }
</style>
