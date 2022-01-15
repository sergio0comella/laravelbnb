<template>
    <div class="d-flex w-50 m-auto align-content-center">
        <div class="card card-body">
            <form type="POST">
                <div class="form-group">
                    <label for="email"> Email </label>
                    <input
                        id="email"
                        v-model="email"
                        :class="[{ 'is-invalid': errorFor('email') }]"
                        class="form-control"
                        name="email"
                        placeholder="Indirizzo email richiesto"
                        type="email"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="password"> Password </label>
                    <input
                        id="password"
                        v-model="password"
                        :class="[{ 'is-invalid': errorFor('password') }]"
                        class="form-control"
                        name="password"
                        placeholder="Passoword richiesta"
                        type="password"
                    />
                    <v-errors :errors="errorFor('password')"></v-errors>
                </div>
                <button
                    :disabled="loading"
                    class="btn btn-primary btn-block"
                    type="submit"
                    @click.prevent="login"
                >
                    Login
                </button>
                <hr />

                <div>
                    Non sei registrato?
                    <router-link :to="{ name: 'home' }" class="font-weight-bold"
                        >Registrati</router-link
                    >
                </div>

                <div>
                    Password dimenticata?
                    <router-link :to="{ name: 'home' }" class="font-weight-bold"
                        >Reset password</router-link
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import {logIn} from "../shared/utils/auth";

export default {
    name: "Login.vue",
    data() {
        return {
            email: null,
            password: null,
            loading: false,
        };
    },
    mixins: [validationErrors],
    methods: {
        async login() {
            this.loading = true;
            this.errors = null;

            try {
                await axios.get("/sanctum/csrf-token");
                await axios.post("/login", {
                    email: this.email,
                    password: this.password,
                });

                logIn();
                await this.$store.dispatch("loadUser");
                await this.$router.push({name: 'home'});
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
        },
    },
};
</script>

<style scoped></style>
