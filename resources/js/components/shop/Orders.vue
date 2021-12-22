<template>
    <div class="container">
        <div class="flex justify-center">
            <div class="bg-white w-full">
                <ul class="divide-y divide-gray-300">
                    <li v-if="orders.length == 0" class="p-10 hover:bg-gray-50 flex justify-center">
                        <p class="text-xl">You don't have any orders yet</p>
                    </li>
                    <li v-for="order in orders" :key="order.id" class="p-10 hover:bg-gray-50">
                        <a :href="order.details_link" class="flex flex-col">
                            <div class="w-full flex justify-between mb-2 ">
                                <div class="">
                                    <p class="text-yellow-500 text-lg font-semibold">Order #{{ order.id }} - {{ order.order_status.message }}</p>
                                </div>
                                <div class="">
                                </div>
                            </div>
                            
                            <div class="flex gap-x-10">
                                <div>
                                    <img :src="order.represent.product.product_image" alt="image"
                                        class="w-40">
                                </div>
                                <div class="flex flex-wrap content-between w-full">
                                    <div class="w-full flex justify-between">
                                        <div class="">
                                            <h2 class="text-xl text-gray-700">{{ order.represent.product.product_name }}</h2>
                                            <p class="text-xl text-gray-700 mr-3">x {{ order.represent.quantity }}</p>
                                        </div>
                                        <div class="flex flex-col text-gray-700">
                                            <div class="flex justify-end">
                                                <div class="">Price: <strong class="text-xl text-bold text-gray-700 mr-3">$ {{ order.represent.product.product_price }}</strong></div>
                                            </div>
                                            
                                            
                                        </div>

                                    </div>
                                    <div class="flex w-full">
                                        <div v-if="order.details_count > 1" class="text-md text-gray-600 font-light uppercase">+ {{ (order.details_count - 1) }} other item{{ (order.details_count - 1) > 1 ? "s" : ""}}</div>
                                    </div>
                                </div>
                                
                            </div>
                         </a>
                            <hr class="border-gray-200 dark:border-gray-700 my-2">
                            <div class="w-full flex justify-between">
                                <div v-if="order.order_status.status == 4" class="">
                                   
                                    
                                    <span v-if="order.is_reviewed" class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="mx-1 uppercase">reviewed</span>
                                    </span>
                                    <div v-else>
                                         <div class="flex justify-start font-semibold text-yellow-500">
                                            <p>Share your opinion about our products</p>
                                        </div>
                                        <div class="flex justify-start mt-2">
                                            <a :href="order.details_link + '#order-summary'" class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span class="mx-1 uppercase">write review</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex justify-end">
                                        <p class="text-gray-700 text-lg uppercase">Total amount: <span class="font-bold text-black text-2xl">$ {{ order.total_amount }}</span></p>
                                    </div>
                                    
                                </div>
                            </div>
                            
                       
                    </li>
                    <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                orders: [],
                page: 1,
            };
        },
        methods: {
            handleLoadMore($state) {
                var app = this;
                axios.get('/api/customer/orders?page='+app.page,{
                        headers: app.$bearerAPITOKEN
                    })
                    .then(function (resp) {
                        console.log(resp.data.data);
                        if (resp.data.data.length) {
                          app.page += 1;
                          app.orders.push(...resp.data.data);
                          $state.loaded();
                        } else {
                          $state.complete();
                        }
                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });
            },
        },
    }
</script>