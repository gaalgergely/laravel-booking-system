<template>
    <div>
        <success v-if="success">
            Congratulations on your purchase!
        </success>
        <div class="row" v-else>
            <div class="col-md-8">
                <form v-if="itemsInTheBasket">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstName">First name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputFirstName"
                                v-model="customer.first_name"
                                :class="[{'is-invalid': errorFor('customer.first_name')}]"
                            >
                            <validation-errors :errors="errorFor('customer.first_name')"></validation-errors>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLastName">Last name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputLastName"
                                v-model="customer.last_name"
                                :class="[{'is-invalid': errorFor('customer.last_name')}]"
                            >
                            <validation-errors :errors="errorFor('customer.last_name')"></validation-errors>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail"
                            placeholder=""
                            v-model="customer.email"
                            :class="[{'is-invalid': errorFor('customer.email')}]"
                        >
                        <validation-errors :errors="errorFor('customer.email')"></validation-errors>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputStreet">Street</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputStreet"
                                placeholder=""
                                v-model="customer.street"
                                :class="[{'is-invalid': errorFor('customer.street')}]"
                            >
                            <validation-errors :errors="errorFor('customer.street')"></validation-errors>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputCity"
                                placeholder=""
                                v-model="customer.city"
                                :class="[{'is-invalid': errorFor('customer.city')}]"
                            >
                            <validation-errors :errors="errorFor('customer.city')"></validation-errors>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCountry">Country</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputCountry"
                                v-model="customer.country"
                                :class="[{'is-invalid': errorFor('customer.country')}]"
                            >
                            <validation-errors :errors="errorFor('customer.country')"></validation-errors>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">State</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputState"
                                v-model="customer.state"
                                :class="[{'is-invalid': errorFor('customer.state')}]"
                            >
                            <validation-errors :errors="errorFor('customer.state')"></validation-errors>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Zip</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputZip"
                                v-model="customer.zip"
                                :class="[{'is-invalid': errorFor('customer.zip')}]"
                            >
                            <validation-errors :errors="errorFor('customer.zip')"></validation-errors>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg btn-block"
                            @click.prevent="book"
                            :disabled="loading"
                        >Book now!</button>
                    </div>
                </form>

                <div v-else class="jumbotron text-center">
                    <h1>Your basket is empty.</h1>
                </div>

            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">Your Cart</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInTheBasket">Items {{ itemsInTheBasket }}</span>
                        <span v-else>Empty</span>
                    </h6>
                </div>
                <transition-group name="fade" tag="div">
                    <div v-for="item in basket" :key="item.bookable.id">
                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                            <span>
                                <router-link :to="{name: 'bookable', params: {id: item.bookable.id}}">{{ item.bookable.title }}</router-link>
                            </span>
                                <span class="font-weight-bold">
                                ${{ item.price.total }}
                            </span>
                        </div>
                        <div class="pt-2 pb-2 d-flex justify-content-between">
                            <span>
                                From {{ item.date.from }}
                            </span>
                                <span>
                                To {{ item.date.to }}
                            </span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button class="btn btn-sm btn-outline-secondary" @click="$store.dispatch('removeFromBasket', item.bookable.id)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapState } from "vuex";
    import validationErrors from "../shared/mixins/validationErrors";

    export default {
        name: "Basket",

        mixins: [validationErrors],

        data() {
            return {
                loading: false,

                bookingAttempted: false,

                customer: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    street: null,
                    city: null,
                    country: null,
                    state: null,
                    zip: null
                }
            }
        },

        computed: {
            ...mapGetters(["itemsInTheBasket"]),
            ...mapState({
                basket: state => state.basket.items
            }),
            success() {
                return !this.loading && 0===this.itemsInTheBasket && !this.bookingAttempted
            }
        },

        methods: {
            async book() {

                this.loading = true;
                this.errors = null;
                this.bookingAttempted = false;

                try {

                    await axios.post('/api/checkout', {

                        customer: this.customer,
                        bookings: this.basket.map(basketItem => ({

                            bookable_id: basketItem.bookable.id,
                            from: basketItem.date.from,
                            to: basketItem.date.to
                        }))

                    });

                    this.$store.dispatch('clearBasket');

                } catch (error) {

                    this.errors = error.response && error.response.data.errors
                }

                this.loading = false;
                this.bookingAttempted = true;
            }
        }
    }
</script>

<style scoped>
    h6.badge {
        font-size: 100%;
    }
    a {
        color: black;
    }
</style>
