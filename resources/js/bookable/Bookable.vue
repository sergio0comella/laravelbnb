<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <h2>{{ bookable.title }}</h2>
                        <hr />
                        <article>{{ bookable.description }}</article>
                    </div>
                    <div v-else>
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <review-list :bookable-id="this.$route.params.id"></review-list>
        </div>
        <div class="col-md-4 pb-4 pt-1">
            <availability
                :bookable-id="this.$route.params.id"
                class="mb-4"
                @availability="checkPrice($event)"
            ></availability>

            <transition name="fade">
                <price-breakdown
                    v-if="price"
                    :price="this.price"
                    class="mb-4"
                ></price-breakdown>
            </transition>

            <transition name="fade">
                <button
                    v-if="price"
                    :disabled="inBasketAlready"
                    class="btn btn-outline-secondary btn-block"
                    @click="addToBasket"
                >
                    Aggiungi al carrello
                </button>
            </transition>

            <transition>
                <button
                    v-if="inBasketAlready"
                    class="btn btn-outline-secondary btn-block"
                    @click="removeFromBasket"
                >
                    Rimuovi dal carrello
                </button>
            </transition>

            <div v-if="inBasketAlready" class="mt-4 text-muted text-warning">
                Sembra che la prenotazione sia gi&agrave; nel tuo carrello. Se
                vuoi cambiare le date, rimuovi prima la prenotazione dal
                carrello.
            </div>
        </div>
    </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import { mapState } from "vuex";
import PriceBreakdown from "./PriceBreakdown";

export default {
    components: {
        Availability,
        ReviewList,
        PriceBreakdown,
    },
    data() {
        return {
            bookable: null,
            loading: true,
            price: null,
        };
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
            inBasketAlready() {
                if (this.bookable === null) {
                    return false;
                }

                return this.$store.getters.inBasketAlready(this.bookable.id);
            },
        }),
    },
    created() {
        this.loading = true;
        axios
            .get("/api/bookables/" + this.$route.params.id)
            .then((response) => {
                this.bookable = response.data.data;
                this.loading = false;
            });
    },
    methods: {
        async checkPrice(hasAvailability) {
            if (!hasAvailability) {
                this.price = null;
                return;
            }

            try {
                this.price = (
                    await axios.get(
                        "/api/bookables/" +
                            this.bookable.id +
                            "/price?from=" +
                            this.lastSearch.from +
                            "&to=" +
                            this.lastSearch.to
                    )
                ).data.data;
            } catch (error) {
                this.price = null;
            }
        },
        addToBasket() {
            this.$store.dispatch("addToBasket", {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch,
            });
        },
        removeFromBasket() {
            this.$store.dispatch("removeFromBasket", this.bookable.id);
        },
    },
};
</script>
