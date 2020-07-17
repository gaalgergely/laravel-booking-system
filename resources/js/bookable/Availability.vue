<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Check Availability
            <transition name="fade">
                <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
                <span v-if="hasAvailability" class="text-success">(AVAILABLE)</span>
            </transition>
        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input
                    type="text"
                    name="from"
                    id="from"
                    class="form-control form-control-sm"
                    placeholder="Start date"
                    v-model="from"
                    @keyup.enter="check"
                    :class="[{'is-invalid': errorFor('from')}]"
                />
                <validation-errors :errors="errorFor('from')"></validation-errors>
            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input
                    type="text"
                    name="to"
                    id="to"
                    class="form-control form-control-sm"
                    placeholder="End date"
                    v-model="to"
                    @keyup.enter="check"
                    :class="[{'is-invalid': errorFor('to')}]"
                />
                <validation-errors :errors="errorFor('to')"></validation-errors>
            </div>
        </div>
        <!-- can be a shared component -->
        <button
            type="button"
            class="btn btn-secondary btn-block"
            @click="check"
            :disabled="loading"
        >
            <span v-if="!loading">Check!</span>
            <span v-else><i class="fas fa-circle-notch fa-spin"></i></span>
        </button>
        <!-- can be a shared component -->
    </div>
</template>

<script>
    import validationErrors from "../shared/mixins/validationErrors";
    import { is422 } from "./../shared/utils/response";

    export default {
        name: "Availability",

        mixins: [validationErrors],

        props: {
            bookableId: [String, Number]
        },

        data: function () {
            return {
                from: this.$store.state.lastSearch.from,
                to: this.$store.state.lastSearch.to,
                loading: false,
                status: null
            };
        },

        methods: {
            async check () {
                this.loading = true;
                this.errors = null;

                this.$store.dispatch('setLastSearch', {from: this.from, to: this.to});

                try {
                    this.status = (await axios.get('/api/bookables/' + this.bookableId + '/availability?from=' + this.from + '&to=' + this.to)).status;

                    this.$emit('availability', this.hasAvailability)

                } catch(error) {

                    if(is422(error)) {
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                    this.$emit('availability', this.hasAvailability)
                }

                this.loading = false;
            }
        },
        computed: {
            hasAvailability: function () {
                return 200 === this.status;
            },
            noAvailability: function () {
                return 404 === this.status;
            }
        }
    }
</script>

<style scoped>
    label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }
</style>
