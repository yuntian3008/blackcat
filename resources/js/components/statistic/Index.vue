<template>
	
    <div class="container bg-white shadow-xl rounded-xl p-4">
        <div class="flex w-full flex-col gap-y-3">
            <div class="flex w-full justify-start items-center gap-x-3 mb-2">
                 <date-range-picker
                        ref="picker"
                        :opens="'right'"
                        :locale-data="{ 
                            firstDay: 1,
                            format: 'dd/mm/yyyy' }"
                        :showDropdowns="true"
                        :linkedCalendars="false"
                        :ranges="rangesList"
                        :time-picker="true"
                        :time-picker-seconds="true"
                        :time-picker24-hour="true"
                        :time-picker-increment="1"
                        v-model="dateRange"
                        @update="update()"
                ></date-range-picker>
            </div>
            <div class="flex w-full justify-around items-center gap-x-3">
                <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center">
                        <span class="rounded-xl flex justify-center items-center p-2 bg-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>                        
                        </span>

                        <p class="text-lg text-black dark:text-white ml-2">
                            Sales
                        </p>
                    </div>
                    <div class="flex flex-col justify-start">
                        <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                            {{ sales.sales.toLocaleString() }}
                            <span class="text-sm">
                                $
                            </span>
                        </p>
                        <div :class="(sales.growth_rate_sales < 0 ? 'text-red-500' : 'text-green-500') +' flex items-center text-sm'">
                            <svg :class="sales.growth_rate_sales < 0 ? 'transform rotate-180' : ''" width="20" height="20" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1408 1216q0 26-19 45t-45 19h-896q-26 0-45-19t-19-45 19-45l448-448q19-19 45-19t45 19l448 448q19 19 19 45z">
                                </path>
                            </svg>
                            <span>
                                {{ Math.abs(sales.growth_rate_sales).toLocaleString() }}%
                            </span>
                            <span class="text-gray-400">
                                    &nbsp;vs the same period before
                            </span>
                        </div>
                    </div>
                </div>
                <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center">
                        <span class="rounded-xl flex justify-center items-center p-2 bg-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>                      
                        </span>
                        <p class="text-lg text-black dark:text-white ml-2">
                            Sold quantity
                        </p>
                    </div>
                    <div class="flex flex-col justify-start">
                        <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                            {{ sales.quantity.toLocaleString() }}
                            <span class="text-sm">
                                Products
                            </span>
                        </p>
                        <div :class="(sales.growth_rate_quantity < 0 ? 'text-red-500' : 'text-green-500') +' flex items-center text-sm'">
                            <svg :class="sales.growth_rate_quantity < 0 ? 'transform rotate-180' : ''" width="20" height="20" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1408 1216q0 26-19 45t-45 19h-896q-26 0-45-19t-19-45 19-45l448-448q19-19 45-19t45 19l448 448q19 19 19 45z">
                                </path>
                            </svg>
                            <span>
                                {{ Math.abs(sales.growth_rate_quantity).toLocaleString() }}%
                            </span>
                            <span class="text-gray-400">
                                    &nbsp;vs the same period before
                            </span>
                        </div>
                    </div>
                </div>
                <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center">
                        <span class="rounded-xl flex justify-center items-center p-2 bg-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <p class="text-lg text-black dark:text-white ml-2">
                            New customers
                        </p>
                    </div>
                    <div class="flex flex-col justify-start">
                        <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                            {{ customers.new_customers.toLocaleString() }}
                            <span class="text-sm">
                                Customers
                            </span>
                        </p>
                        <div :class="(customers.growth_rate_new < 0 ? 'text-red-500' : 'text-green-500') +' flex items-center text-sm'">
                            <svg :class="customers.growth_rate_new < 0 ? 'transform rotate-180' : ''" width="20" height="20" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1408 1216q0 26-19 45t-45 19h-896q-26 0-45-19t-19-45 19-45l448-448q19-19 45-19t45 19l448 448q19 19 19 45z">
                                </path>
                            </svg>
                            <span>
                                {{ Math.abs(customers.growth_rate_new).toLocaleString() }}%
                            </span>
                            <span class="text-gray-400">
                                    &nbsp;vs the same period before
                            </span>
                        </div>
                    </div>
                </div>
                <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center">
                        <span class="rounded-xl flex justify-center items-center p-2 bg-yellow-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </span>
                        <p class="text-lg text-black dark:text-white ml-2">
                            Purchased customers
                        </p>
                    </div>
                    <div class="flex flex-col justify-start">
                        <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                            {{ customers.orders_count.toLocaleString() }}
                            <span class="text-sm">
                                Customers
                            </span>
                        </p>
                        <div :class="(customers.growth_rate_order_count < 0 ? 'text-red-500' : 'text-green-500') +' flex items-center text-sm'">
                            <svg :class="customers.growth_rate_order_count < 0 ? 'transform rotate-180' : ''" width="20" height="20" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1408 1216q0 26-19 45t-45 19h-896q-26 0-45-19t-19-45 19-45l448-448q19-19 45-19t45 19l448 448q19 19 19 45z">
                                </path>
                            </svg>
                            <span>
                                {{ Math.abs(customers.growth_rate_order_count).toLocaleString() }}%
                            </span>
                            <span class="text-gray-400">
                                    &nbsp;vs the same period before
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import DateRangePicker from 'vue2-daterange-picker'

import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

export default {
  components: { DateRangePicker },
  data() {
    let today = new Date()
    today.setHours(0, 0, 0, 0)

    //this month
    var startMonth = new Date(today.getFullYear(), today.getMonth() , 1)
    startMonth.setHours(0,0,0,0)
    var endMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0)
    endMonth.setHours(23,59,59)
    return {
        dateRange: {
            startDate: startMonth,
            endDate: endMonth,
        },
        sales: {
            sales: 0,
            quantity: 0,
        },
        customers: {
            new_customers: 0,
            orders_count: 0,
        },
        chartdata: null,
    }
    
  },
  mounted () {
    var app = this;
    app.update();
  },
  methods: {
    update() { 
        var app = this;
        console.log(app.dateRange.startDate.toISOString()); 
        console.log(app.$bearerAPITOKEN)
        var loader = app.$loading.show();
        let sale_request = axios.get('/api/v1/statistics/sales',{
            headers: app.$bearerAPITOKEN,
            params: {
                start_date: app.dateRange.startDate.toISOString(),
                end_date: app.dateRange.endDate.toISOString(), 
            }
          });
        let customers_request = axios.get('/api/v1/statistics/customers',{
            headers: app.$bearerAPITOKEN,
            params: {
                start_date: app.dateRange.startDate.toISOString(),
                end_date: app.dateRange.endDate.toISOString(), 
            }
          });
        Promise.all([sale_request, customers_request])
          .then(function (results) {
            app.sales = results[0].data;
            app.customers = results[1].data;
            loader.hide();
          }).catch((resp) => {
            console.log(resp);
          });
    },
  },
  computed: {
    
    rangesList () {
        let today = new Date()
        today.setHours(0, 0, 0, 0)

        let yesterday = new Date()
        yesterday.setDate(today.getDate() - 1)
        yesterday.setHours(0, 0, 0, 0);

        //this week
        var curr = new Date; // get current date  
        var first = curr.getDate() - curr.getDay() + 1;    
        var startWeek = new Date(curr.setDate(first));
        startWeek.setHours(0, 0, 0, 0)
        var endWeek = new Date(curr.setDate(curr.getDate()+6));
        endWeek.setHours(23, 59, 59)

        //last week
        var curr = new Date; // get current date  
        var last = curr.getDate() - curr.getDay();  
        var endLastWeek = new Date(curr.setDate(last));
        endLastWeek.setHours(23, 59, 59)
        var startLastWeek = new Date(curr.setDate(curr.getDate()-6));
        startLastWeek.setHours(0, 0, 0, 0)
        
        //this month
        var startMonth = new Date(today.getFullYear(), today.getMonth() , 1)
        startMonth.setHours(0,0,0,0)
        var endMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0)
        endMonth.setHours(23,59,59)

        //last month
        var startLastMonth = new Date(today.getFullYear(), today.getMonth() -1 , 1)
        startLastMonth.setHours(0,0,0,0)
        var endLastMonth = new Date(today.getFullYear(), today.getMonth(), 0)
        endLastMonth.setHours(23,59,59)

        //this year
        var startYear = new Date(today.getFullYear(), 0, 1)
        startYear.setHours(0,0,0,0)
        var endYear = new Date(today.getFullYear() + 1, 0, 0)
        endYear.setHours(23,59,59)

        //last year
        var startLastYear = new Date(today.getFullYear() - 1, 0, 1)
        startLastYear.setHours(0,0,0,0)
        var endLastYear = new Date(today.getFullYear(), 0, 0)
        endLastYear.setHours(23,59,59)

        


        return {
            'Today': [today, today],
            'Yesterday': [yesterday, yesterday],
            'This week': [startWeek,endWeek],
            'Last week': [startLastWeek,endLastWeek],
            'This month': [startMonth,endMonth],            
            'Last month': [startLastMonth, endLastMonth],
            'This year': [startYear,endYear],
            'Last year': [startLastYear,endLastYear],
        }
    }
  }
}
</script>