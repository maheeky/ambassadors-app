<template>
<div>
    <div class="col-md-12 mb-4 input-group">
        <input class="form-control" placeholder="Search Products" @keyup="search($event.target.value)">
        <div class="input-group-append">
            <select class="form-select" @change="sort($event.target.value)">
                <option>Sort Order</option>
                <option value="asc">Price Ascending</option>
                <option value="desc">Price Descending</option>
            </select>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col" v-for="product in products" :key="product.id" @click="select(product.id)">
            <div :class="selected.some(s => s === product.id) ? 'card shadow-sm selected' : 'card shadow-sm'">
                <img :src="product.image" height="200"/>

                <div class="card-body">
                    <p class="card-text">{{ product.title }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">${{ product.price }}</small>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content center mt-4" v-if="filters.page < lastPage">
        <button class="btn btn-primary" @click="loadMore">Load More</button>
    </div>
</div>
</template>

<script lang="ts">
    import {SetupContext, ref} from "vue";

    export default {
        name: "Products",
        props: ['products', 'filters', 'lastPage'],
        emits: ['set-filters'],
        setup(props: any, context: SetupContext) {
            const selected = ref<number[]>([]);

            const search = (s: string) => {
                context.emit('set-filters', {
                    ...props.filters,
                    s,
                    page: 1
                }); 
            }

            const sort = (sort: string) => {
                context.emit('set-filters', {
                    ...props.filters, //Spreading the old values into the filters array to keep track of filters.
                    sort,
                    page: 1
                })
            }

            const loadMore = () => {
                context.emit('set-filters', {
                    ...props.filters, //Spreading the old values into the filters array to keep track of filters.
                    page: props.filters.page + 1
                });
            }

            const select = (id: number) => {
                if( selected.value.some(s => s === id) ) {
                    selected.value = selected.value.filter(s => s !== id); //Remove the ID from the selected array
                    return;
                }
                selected.value = [...selected.value, id];
            }

            return {
                search,
                selected,
                sort,
                loadMore,
                select
            }
        }
    }
</script>

<style scoped>
    .card {
        cursor: pointer;
    }   
    .card.selected {
        border: 4px solid darkcyan;
    }
</style>