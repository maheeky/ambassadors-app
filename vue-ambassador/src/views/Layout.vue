<template>
    <div>

        <Nav/>
        
    <main>

        <Header/>

    <div class="album py-5 bg-light">
        <div class="container">
            <router-view/>
        </div>
    </div>

    </main>

    <footer class="text-muted py-5">
    <div class="container">
        <p class="float-end mb-1">
        <a href="#">Back to top</a>
        </p>
        <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/5.0/getting-started/introduction/">getting started guide</a>.</p>
    </div>
    </footer>


    </div>
</template>

<script>
    import Nav from '@/components/Nav.vue';
    import Header from '@/components/Header.vue';
    import axios from 'axios';
    import {onMounted} from 'vue';
    import {useStore} from "vuex";

    export default {
        name: 'Layout',
        components: { Nav, Header },
        setup() { //Composition API - vue 3 specific. 
        const store = useStore(); //Store is no longer used on the Vue Instance, as in vue 2. 

            onMounted(async() => {
                try {
                    const {data} = await axios.get('user');
    
                    await store.dispatch('setUser', data); //Adding the data as before, but on the store object.
                } catch(e) {
                    console.log(e);
                    await store.displatch('setUser', null);
                }

            });
        }
    }
</script>

<style scoped>

</style>