<template>
    <div>
        <div v-if="loading">Loading ...</div>
        <div v-else>
            <div v-if="alreadyReviewed">
                <h3>You've already left a review for this booking</h3>
            </div>
            <div v-else>
                <div class="from-group">
                    <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
                    <star-rating
                        class="fa-3x"
                        v-model="review.rating"
                    ></star-rating>
                </div>
                <div class="form-group">
                    <label for="content" class="text-muted">Describe your experience with</label>
                    <textarea id="content" name="content" cols="30" rows="10" class="form-control" v-model="review.content"></textarea>
                </div>

                <button class="btn btn-lg btn-primary btn-block">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Review",

        data() {
            return {
                review: {
                    content: null,
                    rating: 5
                },
                existingReview: null,
                loading:false
            };
        },
        computed: {
            alreadyReviewed() {
                return this.existingReview !== null;
            }
        },
        created() {
            this.loading = true;
            axios
                .get('/api/reviews/' + this.$route.params.id)
                .then(response => this.existingReview = response.data.data)
                .catch(err => {
                    //
                })
                .then(() => (this.loading = false));
        }
    }
</script>

<style scoped>

</style>
