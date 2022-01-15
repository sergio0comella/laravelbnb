<template>
    <div>
        <success v-if="success">Grazie per aver condiviso la tua esperienza</success>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-if="!success && !error">
            <div :class="[{ 'col-md-4': twoColumns }, { 'd-none': oneColumn }]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading...</div>
                        <div v-else>
                            <p>
                                Soggiornato presso
                                <router-link
                                    :to="{
                                        name: 'bookable',
                                        params: {
                                            id: booking.bookable.bookable_id,
                                        },
                                    }"
                                    >{{ booking.bookable.title }}
                                </router-link>
                            </p>
                            <p>Da {{ booking.from }} a {{ booking.to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                :class="[
                    { 'col-md-8': twoColumns },
                    { 'col-md-12': oneColumn },
                ]"
            >
                <div v-if="loading">Loading...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        <h3>Hai gi&agrave; lasciato una recensione qui.</h3>
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted">
                                Seleziona una valutazione (da 1 a 5)
                            </label>
                            <star-rating
                                v-model="review.rating"
                                class="fa-3x"
                            ></star-rating>
                        </div>
                        <div class="form-group">
                            <label class="text-muted" for="content">
                                Descrivi la tua esperienza
                            </label>
                            <textarea
                                id="content"
                                v-model="review.content"
                                :class="[{ 'is-invalid': errorFor('content') }]"
                                class="form-control"
                                cols="30"
                                name="content"
                                rows="10"
                            ></textarea>
                            <v-errors :errors="errorFor('content')"></v-errors>
                        </div>

                        <button
                            :disabled="sending"
                            class="btn btn-lg btn-primary btn-block"
                            @click.prevent="submit"
                        >
                            Invia
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { is404, is422 } from "../shared/utils/response";
import _ from "lodash";
import validationErrors from "../shared/mixins/validationErrors";

export default {
    name: "Review",

    mixins: [validationErrors],
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null,
            },
            existingReview: null,
            booking: null,
            loading: false,

            error: false,
            success: false,

            sending: false,
        };
    },
    async created() {
        this.review.id = this.$route.params.id;
        this.loading = true;

        //1. Check review exists by ID
        try {
            this.existingReview = (
                await axios.get("/api/reviews/" + this.review.id)
            ).data.data;
        } catch (err) {
            if (is404(err)) {
                try {
                    this.booking = (
                        await axios.get(
                            "/api/booking-by-review/" + this.review.id
                        )
                    ).data.data;
                } catch (err) {
                    this.error = !is404(err);
                }
            } else {
                this.error = true;
            }
        }

        this.loading = false;
        /*
        axios
            .get("/api/reviews/" + this.review.id)
            .then((response) => {
                this.existingReview = response.data.data;
            })
            .catch((err) => {
                if (is404(err)) {
                    //2. Fetch booking by review key
                    return axios
                        .get("/api/booking-by-review/" + this.review.id)
                        .then((response) => {
                            this.booking = response.data.data;
                        })
                        .catch((err) => {
                            this.error = !is404(err);
                        });
                }
                this.error = true;
            })
            .finally(() => (this.loading = false));
            */
    },
    computed: {
        alreadyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return (
                this.existingReview !== null &&
                this.existingReview !== undefined
            );
        },
        hasBooking() {
            return this.booking !== null;
        },
        oneColumn() {
            return !this.loading && this.alreadyReviewed;
        },
        twoColumns() {
            return this.loading || !this.alreadyReviewed;
        },
    },
    methods: {
        //3. Store the review
        submit() {
            this.sending = true;
            this.error = false;
            this.success = false;
            axios
                .post("/api/reviews", this.review)
                .then((response) => this.success = response.status === 201)
                .catch((err) => {
                    if (is422(err)) {
                        const errors = err.response.data.errors;
                        // _ --> loadash utility per javascript
                        if (errors["content"] && _.size(errors) === 1) {
                            this.errors = errors;
                            return;
                        }
                    }

                    this.error = true;
                })
                .finally(() => (this.sending = false));
        },
    },
};
</script>

<style scoped></style>
