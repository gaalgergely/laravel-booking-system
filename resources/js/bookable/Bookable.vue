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
                    <button class="btn btn-outline-secondary btn-block" @click="addToBasket" :disabled="inBasketAlready">Book now</button>
                </div>
            </transition>

            <button class="btn btn-outline-secondary btn-block mt-4" v-if="inBasketAlready" @click="removeFromBasket">Remove from basket</button>

            <div v-if="inBasketAlready" class="mt-4 text-muted warning">
                Seems like you have added this object to the basket already.
                If you want to change dates, remove from the basket first.
            </div>
        </div>
    </div>
    <div v-else>Loading ...</div>
</template>

<script>
    import Availability from "./Availability";
    import ReviewList from "./ReviewList";
    import PriceBreakdown from "./PriceBreakdown";
    import { mapState } from "vuex";

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
                lastSearch: 'lastSearch',
            }),
            inBasketAlready() {
                if (null === this.bookable) {
                    return false;
                }
                return this.$store.getters.inBasketAlready(this.bookable.id)
            }
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
            },
            addToBasket() {
                this.$store.dispatch('addToBasket', {
                    bookable: this.bookable,
                    price: this.price,
                    date: this.lastSearch
                });
            },
            removeFromBasket() {
                this.$store.dispatch('removeFromBasket', this.bookable.id);
            }
        }
    }
</script>

<style scoped>
    .warning {
        font-size: 0.7rem;
    }
</style>
