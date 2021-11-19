<template>
  <div class="rating">
    <ul class="list">
      <li @click="rate(star)" v-for="star in maxStars" :class="{ 'active': star <= stars }" :key="star.stars" class="star">
      <!-- <i :class="star <= stars ? 'fas fa-star' : 'far fa-star'"></i>  -->
        
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" :fill=" star <= stars ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
      </svg>
      </li>
    </ul>
    <div v-if="hasCounter" class="info counter">
      <span class="score-rating">{{ stars }}</span>
      <span class="divider">/</span>
      <span class="score-max">{{ maxStars }}</span>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Rating',
  props: ['grade', 'maxStars', 'hasCounter'],
  data() {
    return {
      stars: this.grade
    }
  },
  methods: {
    rate(star) {
      if (typeof star === 'number' && star <= this.maxStars && star >= 0) {
        this.stars = this.stars === star ? star - 1 : star
      }
      this.$emit('rate',this.stars);
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .rating {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #b7b7b7;
    background: transparent;
    .list {
        padding: 0;
        margin: 0 20px 0 0;
        &:hover {
            .star {
                color: #ffe100;
            }
        }
        .star {
            display: inline-block;
            font-size: 42px;
            transition: all .2s ease-in-out; 
            cursor: pointer;
            &:hover {
                ~ .star:not(.active) {
                    color: inherit;
                }
            }
            &:first-child {
                margin-left: 0;
            }
            &.active {
                color: #ffe100;
            }
        }
    }
    .info {
        margin-top: 15px;
        font-size: 40px;
        text-align: center;
        display: table;
        .divider {
            margin: 0 5px;
            font-size: 30px;
        }
        .score-max {
            font-size: 30px;
            vertical-align: sub;
        }
    }
}
</style>