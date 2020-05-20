<template>
    <div class="card mb-2 w-100">
        <div class="card-body">
            <router-link :to="{ name: 'bookable', params: { id: id} }">
                <h5 class="card-title">{{ title }}</h5>
            </router-link>
            <p class="card-text">{{ description }}<br>
                <small>{{ price }}</small>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookableListItem",

        props: {
            id: Number,
            title: String,
            description: String,
            price: Number
        }
    }
</script>

<style scoped>

</style>
