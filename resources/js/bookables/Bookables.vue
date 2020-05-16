<template>
    <div>
        <h1>Bookables</h1>

        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="bookables.length">
                <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                    <div
                        class="col"
                        v-for="(bookable, column) in bookablesInRow(row)"
                        :key="'row' + row + column"
                    >
                        <bookable-list-item
                            :item-title="bookable.title"
                            :item-content="bookable.content"
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
            console.log('created');

            this.loading = true;

            setTimeout(() => {
                this.bookables = [
                    {
                        id: 1,
                        title: "Cheap villa",
                        content: "A very cheap villa",
                        price: 1000
                    },
                    {
                        id: 2,
                        title: "Cheap villa 2",
                        content: "A very cheap villa 2",
                        price: 1500
                    },
                    {
                        id: 3,
                        title: "Cheap villa",
                        content: "A very cheap villa",
                        price: 1000
                    },
                    {
                        id: 4,
                        title: "Cheap villa 2",
                        content: "A very cheap villa 2",
                        price: 1500
                    },
                    {
                        id: 5,
                        title: "Cheap villa",
                        content: "A very cheap villa",
                        price: 1000
                    },
                    {
                        id: 6,
                        title: "Cheap villa 2",
                        content: "A very cheap villa 2",
                        price: 1500
                    },
                    {
                        id: 7,
                        title: "Cheap villa",
                        content: "A very cheap villa",
                        price: 1000
                    },
                    {
                        id: 8,
                        title: "Cheap villa 2",
                        content: "A very cheap villa 2",
                        price: 1500
                    }
                ];

                this.loading = false;

            }, 1500);
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
