<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Check Availability
            <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
            <span v-if="hasAvailability" class="text-success">(AVAILABLE)</span>
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
                <div class="invalid-feedback" v-for="(error, index) in errorFor('from')" :key="'from' + index">{{ error }}</div>
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
                <div class="invalid-feedback" v-for="(error, index) in errorFor('to')" :key="'to' + index">{{ error }}</div>
            </div>
        </div>
        <button
            type="button"
            class="btn btn-secondary btn-block"
            @click="check"
            :disabled="loading"
        >Check!</button>
    </div>
</template>

<script>
    export default {
        name: "Availability",

        props: {
            bookableId: Number
        },

        data: function () {
            return {
                from: null,
                to: null,
                loading: false,
                status: null,
                errors: null
            };
        },

        methods: {
            check: function () {
                this.loading = true;
                this.errors = null;

                axios.get(
                    '/api/bookables/' + this.bookableId + '/availability?from=' + this.from + '&to=' + this.to
                ).then(response => {
                    this.status = response.status;
                }).catch(error => {
                    if(422 === error.response.status) {
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                }).then(() => this.loading = false);
            },
            errorFor: function (field) {
                return this.errors && this.errors[field] ? this.errors[field] : null;
            }
        },
        computed: {
            hasErrors: function () {
                return 422 === this.status && this.errors !== null;
            },
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
