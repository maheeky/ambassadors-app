<template>
    <div>
        <h3>Account Information</h3>
        <form @submit.prevent="infoSubmit">
            <div class="mb-3">
                <v-text-field label="First Name" v-model="first_name"/>
            </div>
            <div class="mb-3">
                <v-text-field label="Last Name" v-model="last_name"/>
            </div>    
            <div class="mb-3">
                <v-text-field label="Email" type="email" v-model="email"/>
            </div>
            <v-btn color="primary" type="submit">Save</v-btn>
        </form>

        <h3 class="mt-4">Change Password</h3>
            <form @submit.prevent="passwordSubmit">
                <div class="mb-3">
                    <v-text-field label="Password" type="password" v-model="password"/>
                </div>
                <div class="mb-3">
                    <v-text-field label="Confirm Password" type="password" v-model="password_confirm"/>
                </div>    
                <v-btn color="primary" type="submit">Save</v-btn>
            </form>

    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Profile",
        data() {
            return {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirm: ''
            }
        },
        async mounted() {
            const {data} = await axios.get('user');

            this.first_name = data.first_name;
            this.last_name = data.last_name;
            this.email = data.email;
        },
        methods: {
            async infoSubmit() {
                await axios.put('users/info', {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email
                });
            },
            async passwordSubmit() {
                await axios.put('users/password', {
                    password: this.password,
                    password_confirm: this.password_confirm
                });
            }
        }
    }
</script>

