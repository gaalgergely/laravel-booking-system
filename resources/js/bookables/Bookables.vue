<template>
    <div>
        <h1>Bookables</h1>

        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="bookables.length">
                <bookable-list-item
                    v-for="(bookable, index) in bookables"
                    :key="index"
                    :item-title="bookable.title"
                    :item-content="bookable.content"
                    :item-price="bookable.price"
                ></bookable-list-item>
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
              loading: false
          }
        },

        /*beforeCreate() {
            console.log('before create');
        },*/

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
