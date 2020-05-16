<template>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ itemTitle }}</h5>
            <p class="card-text">{{ itemContent }}<br>
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
            itemContent: String,
            itemPrice: Number
        }
    }
</script>

<style scoped>

</style>
