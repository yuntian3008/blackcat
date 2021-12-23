<template>
    <div class="relative mt-4 lg:mt-0 lg:mx-4">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>

        <input type="text" class="w-full py-1 pl-10 pr-4 text-gray-700 rounded-lg placeholder-gray-600 bg-white border-b border-gray-600 dark:placeholder-gray-300 dark:focus:border-gray-300 lg:w-56 lg:border-transparent dark:bg-gray-800 dark:text-gray-300 focus:outline-none  " placeholder="Search" v-model="search" @input="find()" @blur="cancel()">

        <ul v-show="products.length > 0" class="divide-y divide-gray-300 absolute rounded-lg top-0 mt-10 z-50 bg-white shadow-xl overflow-y-auto" style="width: 40vw; max-height: 50vh;">
            <li class="p-4 hover:bg-gray-50 cursor-pointer animate__animated animate__slideInUp" v-for="item in products" :key="item.id">
                <a :href="item.href" class="flex space-x-4">
                    <div>
                        <img :src="item.product_image" alt="image"
                            class="w-20">
                    </div>
                    <div>
                        <h2 class="text-sm font-bold">{{ item.product_name }}</h2>
                        <strong class="text-gray-700 mr-3">Price:</strong>$ {{ item.product_price }}
                    </div>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-50 cursor-pointer animate__animated animate__slideInUp">
                <a href="/advanced-search" class="flex space-x-4 font-bold underline justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
</svg>Advanced search
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                search: '',
            }
        },
        mounted() {
        },
        methods: {
        	cancel: function() {
        		var app = this;
        		setTimeout(function() {

	        		app.search = '';
	        		app.products = [];
        		}, 200);
        		
        	},
            find: function () {
            	var app = this;
            	axios.get('/search?search='+app.search,{
                    _token: app.$csrfToken,
                })
                    .then(function (resp) {
                        app.products = resp.data;
                        //console.log(resp);
                    })
                    .catch(function () {
                        alert("Could not load your product")
                    });
            }
        },
    }
</script>
