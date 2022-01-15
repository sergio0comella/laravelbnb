<template>
    <div>
        <nav
            class="navbar navbar-expand-lg bg-white border-bottom navbar-light"
        >
            <router-link
                class="navbar-brand mr-auto"
                v-bind:to="{ name: 'home' }"
                >LaravelBnB
            </router-link>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :to="{ name: 'basket' }" class="nav-link">
                        Carrello
                        <span
                            v-if="itemsInBasket"
                            class="badge badge-secondary"
                            >{{ itemsInBasket }}</span
                        >
                    </router-link>
                </li>

                <li v-if="!isLoggedIn" class="nav-item">
                    <router-link :to="{ name: 'register' }" class="nav-link"
                        >Registrati
                    </router-link>
                </li>

                <li v-if="!isLoggedIn" class="nav-item">
                    <router-link :to="{ name: 'login' }" class="nav-link"
                        >Login
                    </router-link>
                </li>

                <li v-if="isLoggedIn" class="nav-item">
                    <a class="nav-link" href="" @click.prevent="logout()"
                        >Logout</a
                    >
                </li>
            </ul>
        </nav>

        <div class="container mt-4 mb-4 pd-4 pl-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { logOut } from "./shared/utils/auth";

export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch,
        };
    },
    computed: {
        ...mapState({
            lastSearchComputed: "lastSearch",
            isLoggedIn: "isLoggedIn",
        }),
        ...mapGetters({
            itemsInBasket: "itemsInBasket",
        }),
    },
    methods: {
        async logout() {
            try {
                await axios.post("/logout");
                await this.$store.dispatch("logout");
            } catch (error) {
                await this.$store.dispatch("logout");
            }
        },
    },
};
</script>
