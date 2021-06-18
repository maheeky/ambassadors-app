<template>
    <Products :products="filteredProducts" :filters="filters" @set-filters="filtersChanged"/>
</template>

<script lang="ts">
    import {onMounted, reactive, ref} from 'vue';
    import Products from '../views/Products.vue';
    import axios from 'axios';
    import {Product} from '../models/product';
    import {Filter} from '../models/filter';

    export default {
        name: 'ProductsFrontend',
        components: {Products},
        setup() {
            const allProducts = ref<Product[]>([]);
            const filteredProducts = ref<Product[]>([]);
            const filters = reactive<Filter>({
                s: '',
                sort: ''
            });

            onMounted(async () => {
                const {data} = await axios.get('products/frontend');
                
                allProducts.value = data;
                filteredProducts.value = data;
           });

            const filtersChanged = (f: Filter) => {
                filters.s = f.s;
                let products = allProducts.value.filter(p => p.title.toLowerCase().indexOf(filters.s.toLowerCase()) >= 0
                    || p.description.toLowerCase().indexOf(filters.s.toLowerCase()) > 0);
                filteredProducts.value = products;
            }

           return {
               filteredProducts,
               filters,
               filtersChanged
           }
        }
    }
</script>