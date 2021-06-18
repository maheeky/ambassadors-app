<template>
    <div>

        <Nav/>
        
    <main>

        <Header/>

    <div class="album py-5 bg-light">
        <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

                    <div class="card-body">
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                    </div>
                    </div>
                </div>
            </div>
        </div>
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
                const {data} = await axios.get('user');

                await store.dispatch('setUser', data); //Adding the data as before, but on the store object.
            });
        }
    }
</script>

<style scoped>

</style>