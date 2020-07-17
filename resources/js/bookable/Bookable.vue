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
            <availability
                :bookable-id="this.$route.params.id"
                @availability="checkPrice($event)"
                class="mb-4"
            ></availability>
            <transition name="fade">
                <div v-if="price">
                    <price-breakdown :price="price" class="mb-4"></price-breakdown>
                    <button class="btn btn-outline-secondary btn-block">Book now</button>
                </div>
            </transition>
        </div>
    </div>
    <div v-else>Loading ...</div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";
    import PriceBreakdown from "./PriceBreakdown";
    import { mapState } from 'vuex';

    export default {
        name: "Bookable",

        components: {
            Availability,
            ReviewList,
            PriceBreakdown
        },

        data() {
            return {
                bookable: null,
                loading: true,
                price: null
            };
        },

        created() {
            this.loading = true;
            axios.get('/api/bookables/' + this.$route.params.id)
                .then(response => {
                    this.bookable = response.data.data;
                    this.loading = false;
                });
        },

        computed: {
            ...mapState({
                lastSearch: 'lastSearch'
            })
        },

        methods: {
            async checkPrice(hasAvailability) {

                if (!hasAvailability) {
                    this.price = null;
                    return;
                }

                try {
                    this.price = (await axios.get('/api/bookables/' + this.bookable.id + '/price?from=' + this.lastSearch.from + '&to=' + this.lastSearch.to)).data.data;

                } catch (error) {

                    this.price = null;
                }
            }
        }
    }
</script>

<style scoped>

</style>
