<template>
    <div class="row" v-if="!loading">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>{{ bookable.title }}</h2>
                    <hr />
                    <article>{{ bookable.description }}</article>
                </div>
            </div>
            <review-list :bookable-id="this.$route.params.id"></review-list>
        </div>
        <div class="col-md-4 pb-4">
            <availability :bookable-id="this.$route.params.id"></availability>
        </div>
    </div>
    <div v-else>Loading ...</div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";

    export default {
        name: "Bookable",

        components: {
            Availability,
            ReviewList
        },

        data() {
            return {
                bookable: null,
                loading: true
            };
        },

        created() {
            this.loading = true;
            axios.get('/api/bookables/' + this.$route.params.id)
                .then(response => {
                    this.bookable = response.data.data;
                    this.loading = false;
                });
        }
    }
</script>

<style scoped>

</style>
