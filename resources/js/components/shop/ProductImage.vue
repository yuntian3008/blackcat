<template>
    <div>
        <carousel-3d width="200" height="200" slides=3>
            <slide v-for="(slide, i) in imgs[1]" :index="i" :key="i">
                <img :src="slide">
            </slide>
        </carousel-3d>
    </div>

</template>

<script>
// import ProductZoomer from 'vue-product-zoomer'
    export default {
        // components: {
        //     ProductZoomer,
        // },
        props: ['imgs'],
        data() {
            return {
                'slides': 3,
            }
        },
        mounted() {
            //
        },
        methods: {
        },
    }
</script>
