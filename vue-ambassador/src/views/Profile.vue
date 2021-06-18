<template>
    <div>
        <h3>Account Information</h3>
        <form @submit.prevent="infoSubmit">
            <div class="mb-3">
                <label>First Name</label>
                <input class="form-control"  type="text" v-model="infoData.first_name"/>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input class="form-control"  type="text" v-model="infoData.last_name"/>
            </div>    
            <div class="mb-3">
                <label>Email</label>
                <input class="form-control"  type="email" v-model="infoData.email"/>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>

        <h3 class="mt-4">Change Password</h3>
            <form @submit.prevent="passwordSubmit">
                <div class="mb-3">
                    <label>Password</label>
                    <input class="form-control"  type="password" v-model="passwordData.password"/>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input class="form-control"  label="Confirm Password" type="password" v-model="passwordData.password_confirm"/>
                </div>    
                <button class="btn btn-primary" type="submit">Save</button>
            </form>

    </div>
</template>

<script>
    import {computed, reactive, watch} from 'vue';
    import {useStore} from 'vuex';
    import axios from 'axios';

    export default {
        name: 'Profile',
        setup() {
            const store = useStore();
            const user = computed(() => store.state.user);

            const infoData = reactive({
                first_name : user.value.first_name,
                last_name: user.value.last_name,
                email: user.value.email,
            });

            const passwordData = reactive({
                password: '',
                password_confirm: '',
            });

            watch(user, () => {
                infoData.first_name = user.value.first_name,
                infoData.last_name = user.value.last_name,
                infoData.email = user.value.email
            });

            const infoSubmit = async () => {
                const {data} = await axios.put('users/info', infoData);
                await store.dispatch('setUser', data);
            }

            const passwordSubmit = async () => {
                await axios.put('users/password', passwordData);
            }

            return {
                infoData,
                passwordData,
                infoSubmit,
                passwordSubmit,
            }
        }
    }
</script>

