<template>

    <Products :products="products" :filters="filters" @set-filters="load($event)"/>
    
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
                sort: ''
            });

            const load = async (f: Filter) => {
                filters.s = f.s;
                filters.sort = f.sort;
                const arr = [];

                if( filters.s ) {
                    arr.push(`s=${filters.s}`);
                }

                if( filters.sort ) {
                    arr.push(`sort=${filters.sort}`);
                }
                const {data} = await axios.get(`products/backend?${arr.join('&')}`);
                
                products.value = data.data;
            }

            //Send filter as a parameter.
            onMounted( () => load(filters) );

           return {
               products,
               filters,
               load
           }
        }
    }
</script>