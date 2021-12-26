<template>
    <div class="w-full p-10 bg-white rounded-xl shadow-lg dark:bg-gray-800">
        <div class="flex w-full justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Details {{ '#'+goods_receipt.id }}</h2>
            <button @click="$emit('close')" type="button" class="-mr-1 flex p-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                  <span class="sr-only">
                      Dismiss
                  </span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-6 w-6 text-gray-900" viewBox="0 0 1792 1792">
                      <path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z">
                      </path>
                  </svg>
              </button>
        </div>
        
        <div class="flex flex-col">
          <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
              <div class="overflow-hidden">
                <table class="min-w-full">
                  <thead class="bg-gray-100 border-b">
                    <tr>
                      <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Product</th>
                        <th scope="col" class="text-sm font-semibold text-gray-400 px-6 py-4 text-left uppercase">Quantity</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Unit price</th>
                        <th scope="col" class="text-sm font-semibold text-gray-400 px-6 py-4 text-left uppercase">Current Stock</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Stars</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer" v-for="detail, index in goods_receipt_details">
                        <td class="text-sm text-gray-900 font-light px-6 py-4">
                            <div class="shadow-lg rounded-2xl bg-white dark:bg-gray-800 p-4">
                                <div class="flex-row gap-4 flex justify-center items-center">
                                    <div class="flex-shrink-0">
                                        <a href="#" class="block relative">
                                            <img alt="profil" :src="detail.product.images[0]" class="mx-auto object-cover rounded-full h-16 w-16 "/>
                                        </a>
                                    </div>
                                    <div class=" flex flex-col">
                                        <span class="text-gray-600 dark:text-white text-sm font-medium">
                                            {{ detail.product.product_name }}
                                        </span>
                                        <span class="text-gray-400 text-xs">
                                            Category: {{ detail.product.category.category_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td class="text-sm text-gray-900 font-medium px-6 py-4">{{ detail.quantity }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4">{{ detail.unit_price }}</td>
                        <td class="text-sm text-gray-900 font-medium px-6 py-4">{{ detail.product.stock }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4">{{ detail.product.stars }}</td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
      </div>
    </div>
</template>
<script>

    export default {
        props: ['goods_receipt_details','goods_receipt'],
        components: {
            //
        },
        mounted() {
            var app = this;
            //
        },
        methods: {
            //
        }
    }
</script>
<style>
    .vm--modal {
  height: auto !important;
}
</style>