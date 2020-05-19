<template>
    <div class="card mb-2 w-100">
        <div class="card-body">
            <h5 class="card-title">{{ itemTitle }}</h5>
            <p class="card-text">{{ itemDescription }}<br>
                <small>{{ itemPrice }}</small>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookableListItem",

        props: {
            itemTitle: String,
            itemDescription: String,
            itemPrice: Number
        }
    }
</script>

<style scoped>

</style>
