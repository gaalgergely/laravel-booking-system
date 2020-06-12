<template>
    <div class="d-flex">
        <i class="fas fa-star" v-for="star in fullStars" :key="'full' + star"></i>
        <i class="fas fa-star-half-alt" v-if="halfStars"></i>
        <i class="far fa-star" v-for="star in emptyStars" :key="'empty' + star"></i>
    </div>
</template>

<script>
    export default {
        name: "StarRating",

        props: {
            rating: Number
        },

        computed: {
            halfStars() {
                return Math.round(this.rating) < this.rating;
            },
            fullStars() {
                return Math.round(this.rating);
            },
            emptyStars() {
                return 5-Math.ceil(this.rating);
            }
        }
    }
</script>

<style scoped>

</style>
