<template>
    <div>
        <success v-if="success">Prenotazione completata!</success>
        <div class="row" v-else>
            <div class="col-md-8" v-if="itemsInBasket">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="first_names">Nome</label>
                        <input
                            id="first_names"
                            v-model="customer.first_names"
                            class="form-control"
                            name="first_names"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.first_names') }]"
                        />
                        <v-errors :errors="errorFor('customer.first_names')"></v-errors>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Cognome</label>
                        <input
                            id="last_name"
                            v-model="customer.last_name"
                            class="form-control"
                            name="last_name"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.last_name') }]"
                        />
                        <v-errors :errors="errorFor('customer.last_name')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            v-model="customer.email"
                            class="form-control"
                            name="email"
                            type="email"
                            :class="[{ 'is-invalid': errorFor('customer.email') }]"
                        />
                        <v-errors :errors="errorFor('customer.email')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="street">Indirizzo</label>
                        <input
                            id="street"
                            v-model="customer.street"
                            class="form-control"
                            name="street"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.street') }]"
                        />
                        <v-errors :errors="errorFor('customer.street')"></v-errors>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="city">Citt&agrave;</label>
                        <input
                            id="city"
                            v-model="customer.city"
                            class="form-control"
                            name="city"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.city') }]"
                        />
                        <v-errors :errors="errorFor('customer.city')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="country">Nazione</label>
                        <input
                            id="country"
                            v-model="customer.country"
                            class="form-control"
                            name="country"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.country') }]"
                        />
                        <v-errors :errors="errorFor('customer.country')"></v-errors>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="state">Provincia</label>
                        <input
                            id="state"
                            v-model="customer.state"
                            class="form-control"
                            name="state"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.state') }]"
                        />
                        <v-errors :errors="errorFor('customer.state')"></v-errors>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="zipcode">CAP</label>
                        <input
                            id="zipcode"
                            v-model="customer.zip"
                            class="form-control"
                            name="zipcode"
                            type="text"
                            :class="[{ 'is-invalid': errorFor('customer.zip') }]"

                        />
                        <v-errors :errors="errorFor('customer.zip')"></v-errors>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button
                            class="btn btn-lg btn-block btn-primary"
                            type="submit"
                            @click.prevent="book"
                            :disabled="loading"
                        >
                            Prenota
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8" v-else>
                <div class="jumbotron jumbotron-fluid text-center">
                    <h1>Carrello Vuoto</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6
                        class="text-uppercase text-secondary font-weight-bolder"
                    >
                        Il tuo carrello
                    </h6>
                    <h6 class="text-uppercase badge badge-secondary">
                        <span v-if="itemsInBasket"
                            >Elementi {{ itemsInBasket }}</span
                        >
                        <span v-else>Vuoto</span>
                    </h6>
                </div>

                <transition-group name="fade">
                    <div v-for="item in basket" :key="item.bookable.id">
                        <div
                            class="pt-2 pb-2 border-top d-flex justify-content-between"
                        >
                            <span>
                                <router-link
                                    :to="{
                                        name: 'bookable',
                                        params: { id: item.bookable.id },
                                    }"
                                    >{{ item.bookable.title }}</router-link
                                >
                            </span>

                            <span class="font-weight-bold">
                                &euro; {{ item.price.total }}
                            </span>
                        </div>

                        <div class="pt-2 pb-2 d-flex justify-content-between">
                            <span> Dal {{ item.dates.from }} </span>
                            <span> Al {{ item.dates.to }} </span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button
                                class="btn btn-sm btn-block btn-outline-secondary"
                                @click="
                                    $store.dispatch(
                                        'removeFromBasket',
                                        item.bookable.id
                                    )
                                "
                            >
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
    computed: {
        ...mapGetters(["itemsInBasket"]),
        ...mapState({
            basket: (state) => state.basket.items,
        }),
        success(){
            return !this.loading && this.itemsInBasket === 0 && this.bookingAttempted;
        }
    },
    mixins: [validationErrors],
    data() {
        return {
            loading: false,
            bookingAttempted: false,
            customer: {
                first_names: null,
                last_name: null,
                address: null,
                email: null,
                street: null,
                city: null,
                country: null,
                state: null,
                zip: null,
            },
        };
    },
    methods: {
        async book() {
            this.loading = true;
            this.errors = null;
            this.bookingAttempted = false;

            try {
                await axios.post("/api/checkout", {
                    customer: this.customer,
                    bookings: this.basket.map((basketItem) => ({
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to: basketItem.dates.to,
                    })),
                }).then(() => {
                    this.$store.dispatch('clearBasket');
                })
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
            this.bookingAttempted = true;
        },
    },
};
</script>

<style scoped>
h6.badge {
    font-size: 100%;
}

a {
    color: black;
}
</style>
