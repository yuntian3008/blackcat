<template>
  <div>
    <CoolLightBox 
      :items="items" 
      :index="index"
      @close="index = null">
    </CoolLightBox>

    <div class="images-wrapper">
      <img width="100"
        class="image border border-gray-200 rounded-lg cursor-pointer"
        v-for="(image, imageIndex) in items"
        :key="imageIndex"
        @click="index = imageIndex"
        :src="image"
      />
    </div>
  </div>
</template>

<script>
export default {
    props: ['items'],
    data: function () {
        return {
            index: null
        }
    },
};
</script>