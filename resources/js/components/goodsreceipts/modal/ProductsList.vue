<template>
    <div>
        <div class="container rounded-lg shadow-lg h-100 p-4 border mt-5 bg-white">
            <div class="flex w-full justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Products List</h2>
<!--             <button @click="$emit('close')" type="button" class="-mr-1 flex p-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                  <span class="sr-only">
                      Dismiss
                  </span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-6 w-6 text-gray-900" viewBox="0 0 1792 1792">
                      <path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z">
                      </path>
                  </svg>
              </button> -->
        </div>

            <div class="w-full grid grid-cols-4 gap-4">
            <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                <div>
                    <span class="form-label inline-block mb-2 text-gray-700">Name</span>
                    <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" placeholder="Search by name" v-model="search.name">
                </div>
                <div>
                    <span class="form-label inline-block mb-2 text-gray-700">Price</span>
                    <div class="grid grid-cols-2 gap-x-2">
                        <vue-numeric currency="$" separator="." v-model="search.price_from" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="from" ></vue-numeric>
                        <vue-numeric currency="$" separator="." v-model="search.price_to" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="to"></vue-numeric>    
                    </div>
                </div>
                <div>
                    <span class="form-label inline-block mb-2 text-gray-700">Category</span>
                    <select v-model="search.category_id" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                        <option :value="null" selected>Category (all)</option>
                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
                    </select>
                </div>
                <div>
                    <span class="form-label inline-block mb-2 text-gray-700">Visible</span>
                    <select v-model="search.visible" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                        <option :value="null" selected>Visible (all)</option>
                        <option :value="1">Showing</option>
                        <option :value="0">Hiding</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col">
              <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                    <table class="min-w-full">
                      <thead class="bg-gray-100 border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">ID</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Image</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Name</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Price</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Category</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Stock</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Created at</th>
                            <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Updated at</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer" v-for="product, index in resultQuery" :key="product.id" @click="choose(product.id)">
                            <td>
                                <img :src="product.product_image" class="mx-auto object-cover rounded-md h-20 w-20 " :alt="product.product_name">
                            </td>
                            <td  class="text-sm text-gray-900 font-bold px-6 py-4">{{product.id}}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4">{{ product.product_price }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4">{{ product.category.category_name }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4">{{ product.stock }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4">{{ product.created_at }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4">{{ product.updated_at }}</td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </div>
                </div>
              </div>
              <div class="w-full flex justify-center">
                    <caption class="font-light text-md py-4"v-if="resultQuery.length == 0">No thing.</caption>
              </div>
            </div>
        </div>
    </div>
</template>

<script>

import VueNumeric from 'vue-numeric'

    export default {
        components: {
            VueNumeric,
        },
        data: function () {
            return {
                search: {
                    name: null,
                    price_from: 0,
                    price_to: 0,
                    category_id: null,
                    visible: null,
                },
                products: [],
                categories: [],
                category_id: '',
                
            }
        },
        mounted() {
            var app = this;
            var loader = this.$loading.show();
                axios.get('/api/v1/products',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.products = resp.data;
                    loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    loader.hide();
                    app.handingError(resp,'Could not load products','back');
                });
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data.original;
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load category','back');
                });
        },
        methods: {
            choose(id) {
                var app = this;
                app.$emit('close',id);
            }
        },
        computed: {
            resultQuery(){
                var app = this;
                var data = app.products;
                if(app.search.name)
                    data = data.filter((item)=>{
                            return app.search.name.toLowerCase().split(' ').every(v => item.product_name.toLowerCase().includes(v))
                        });
                if(!(app.search.price_from == 0 && app.search.price_to == 0))
                    data = data.filter((product) => (app.search.price_from <= product.product_price && app.search.price_to >= product.product_price));

                if(app.search.category_id)
                    data = data.filter((product) => (app.search.category_id == product.category_id));

                if(app.search.visible != null)
                    data = data.filter((product) => (app.search.visible == product.product_visible ));

                return data;
            }
        }
    }
</script>

<style>
    .vm--modal {
  height: auto !important;
}
</style>