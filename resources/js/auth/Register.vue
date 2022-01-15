<template>
    <div class="d-flex w-50 m-auto align-content-center">
        <div class="card card-body">
            <form type="POST">
                <div class="form-group">
                    <label for="email"> Username </label>
                    <input
                        id="name"
                        v-model="user.name"
                        :class="[{ 'is-invalid': errorFor('user.name') }]"
                        class="form-control"
                        name="user.name"
                        placeholder="username"
                        type="email"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="email"> Email </label>
                    <input
                        id="email"
                        v-model="user.email"
                        :class="[{ 'is-invalid': errorFor('user.email') }]"
                        class="form-control"
                        name="user.email"
                        placeholder="Indirizzo email richiesto"
                        type="email"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="password"> Password </label>
                    <input
                        id="password"
                        v-model="user.password"
                        :class="[{ 'is-invalid': errorFor('user.password') }]"
                        class="form-control"
                        name="user.password"
                        placeholder="Password"
                        type="password"
                    />
                    <v-errors :errors="errorFor('password')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="password_confirmation"> Ripeti Password </label>
                    <input
                        id="password_confirmation"
                        v-model="password_confirmation"
                        :class="[{ 'is-invalid': errorFor('password_confirmation') }]"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="Conferma password"
                        type="password"
                    />
                    <v-errors :errors="errorFor('password_confirmation')"></v-errors>
                </div>
                <button
                    :disabled="loading"
                    class="btn btn-primary btn-block"
                    type="submit"
                    @click.prevent="register"
                >
                    Login
                </button>
                <hr />

                <div>
                    Hai gi&agrave; un account?
                    <router-link :to="{ name: 'login' }" class="font-weight-bold"
                    >Login</router-link
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
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            loading: false,
        };
    },
    mixins: [validationErrors],
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;

            try {
                const response = await axios.post("/register", this.user);
                if(response.status === 201){
                    logIn();
                    await this.$store.dispatch("loadUser");
                    await this.$router.push({name: 'home'});
                }
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
        },
    },
};
</script>

<style scoped></style>
