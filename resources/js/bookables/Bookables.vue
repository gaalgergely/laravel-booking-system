<template>
    <div>
        <h1>Bookables</h1>

        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="bookables.length">
                <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                    <div
                        class="col d-flex align-items-stretch"
                        v-for="(bookable, column) in bookablesInRow(row)"
                        :key="'row' + row + column"
                    >
                        <bookable-list-item
                            :item-title="bookable.title"
                            :item-description="bookable.description"
                            :item-price="bookable.price"
                        ></bookable-list-item>
                    </div>

                    <div class="col" v-for="placeholder in placeholdersInRow(row)" :key="'placeholder' + row + placeholder"></div>
                </div>
            </div>
            <div v-else>No data.</div>
        </div>

    </div>
</template>

<script>
    import BookableListItem from "./BookableListItem";

    export default {
        name: "Bookables",
        components: {BookableListItem},

        data() {
          return {
              bookables: [],
              loading: false,
              columns: 3
          }
        },

        computed: {
          rows() {
              return Math.ceil(this.bookables.length / this.columns);
          }
        },

        /*beforeCreate() {
            console.log('before create');
        },*/

        methods: {
            bookablesInRow(row) {
                return this.bookables.slice((row-1) * this.columns, row * this.columns);
            },

            placeholdersInRow(row) {
                return this.columns - this.bookablesInRow(row).length
            }
        },

        created() {
            /**
             * good place to fetch data
             */

            this.loading = true;

            axios.get('/api/bookables')
                .then(response => {
                    this.bookables = response.data;
                    this.loading = false;
                });
        },

        /*beforeMount() {
            console.log('before mount');
        },*/

        mounted() {
            console.log('mounted');
        },

        /*beforeDestroy() {
            console.log('before destroy');
        },

        destroyed() {
            console.log('destroyed');
        }*/
    }
</script>

<style scoped>

</style>
