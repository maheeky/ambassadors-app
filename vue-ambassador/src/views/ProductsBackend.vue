<template>

    <Products :products="products" :filters="filters" @set-filters="load($event)" :lastPage="lastPage"/>
    
</template>

<script lang="ts">
    import {onMounted, reactive, ref} from 'vue';
    import {useStore} from 'vuex';
    import Products from '../views/Products.vue';
    import axios from 'axios';
    import {Product} from '../models/product';
    import {Filter} from '../models/filter';

    export default {
        name: 'ProductsBackend',
        components: {Products},
        setup() {
            const products = ref<Product[]>([]);
            const filters = reactive<Filter>({
                s: '',
                sort: '',
                page: 1
            });
            const lastPage = ref(0);

            const load = async (f: Filter) => {
                filters.s = f.s;
                filters.sort = f.sort;
                filters.page = f.page;

                const arr = [];

                if( filters.s ) {
                    arr.push(`s=${filters.s}`);
                }

                if( filters.sort ) {
                    arr.push(`sort=${filters.sort}`);
                }

                if( filters.page ) {
                    arr.push(`page=${filters.page}`);
                }

                const {data} = await axios.get(`products/backend?${arr.join('&')}`);
                lastPage.value = data.meta.last_page; 
                
                //If the page is 1, we have just searched or sorted - so replace the data. Otherwise merge with spread operator. 
                products.value = filters.page === 1 ? data.data : [...products.value, ...data.data];
            }

            //Send filter as a parameter.
            onMounted( () => load(filters) );

           return {
               products,
               filters,
               load,
               lastPage
           }
        }
    }
</script>