<template>
  <div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>Welcome</h2>
        <p class="lead">{{ user.first_name }} {{ user.last_name }} has invited you to buy these products!</p>
      </div>

      <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Products</span>
          </h4>
          <ul class="list-group mb-3">
            <template v-for="product in products">
              <li class="list-group-item d-flex justify-content-between lh-sm"> 
                <div>
                  <h6 class="my-0">{{ product.title }}</h6>
                  <small class="text-muted">{{ product.description }}</small>
                </div>

                  <span class="text-muted">${{ product.price }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-sm">                
                <h6 class="my-0">Quantity</h6>
                <input type="number" min="0" class="text-muted form-control quantity" v-model="quantities[product.id]"/>
                </li>
              </li>
            </template>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>${{ total }}</strong>
            </li>
          </ul>
        </div>

        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Personal Information</h4>
          <form class="needs-validation" @submit.prevent="submit">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="First Name" v-model="first_name" required>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Last Name" v-model="last_name" required>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="you@example.com" v-model="email">
              </div>

              <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="1234 Main St" v-model="address" required>
              </div>

              <div class="col-md-5">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-select" id="country" placeholder="Country" v-model="country" required/>
              </div>

              <div class="col-md-4">
                <label for="state" class="form-label">City</label>
                <input type="text" class="form-select" id="state" placeholder="City" v-model="city" required>
              </div>

              <div class="col-md-3">
                <label for="zip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="zip" placeholder="Zip" v-model="zip" required>
              </div>
            </div>


            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">Checkout</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import {Context} from '@nuxt/types';

  export default Vue.extend({
    async asyncData(ctx: Context) { //Using the asyncData method to populate the User from the get request prior to rendering - this ensures all data is in the DOM for spidering.
      const {data} = await ctx.$axios.get(`links/${ctx.params.code}`);

      const user = data.user;
      const products = data.products;
      let quantities = [];

      products.forEach(p => {
        quantities[p.id] = 0;
      });

      return {
        user,
        products,
        quantities
      }
    },
    data() {
      return {
        user: null,
        products: [],
        quantities: [],
        first_name: '',
        last_name: '',
        email: '',
        address: '',
        country: '',
        city: '',
        zip: '',
      }
    },
    methods: {
      async submit() {
        const {data} = await this.$axios.post('orders', {
          first_name: this.first_name,
          last_name: this.last_name,
          email: this.email,
          address: this.address,
          country: this.country,
          city: this.city,
          zip: this.zip,
          code: this.$route.params.code,
          products: this.products.map(p => ({
            product_id: p.id,
            quantity: this.quantities[p.id]
          })),
        })

        await this.$stripe?.redirectToCheckout({
          sessionId: data.id
        });
      }
    },
    computed: {
      total() {
        return this.products.reduce((sum, product)=> {
          return sum + product.price * this.quantities[product.id];
        }, 0);
      }
    }
  })
</script>

<style scoped>
  .quantity {
    width: 50%;
    margin-left: auto;
  }
</style>