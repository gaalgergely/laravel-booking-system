<template>
    <div class="d-flex">
        <i
            class="fas fa-star"
            v-for="star in fullStars"
            :key="'full' + star"
            @click="$emit('input', star)"
        ></i>
        <i class="fas fa-star-half-alt" v-if="halfStars"></i>
        <i
            class="far fa-star"
            v-for="star in emptyStars"
            :key="'empty' + star"
            @click="$emit('input', fullStars+star)"
        ></i>
    </div>
</template>

<script>
    export default {
        name: "StarRating",

        props: {
            value: Number
        },

        computed: {
            halfStars() {
                return Math.round(this.value) < this.value;
            },
            fullStars() {
                return Math.round(this.value);
            },
            emptyStars() {
                return 5-Math.ceil(this.value);
            }
        }
    }
</script>

<style scoped>

</style>
