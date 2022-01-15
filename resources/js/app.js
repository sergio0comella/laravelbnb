import moment from "moment";

require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";
import router from "./routes";
import storeDefinition from "./store";

import Index from "./Index";

import StarRatingView from "./shared/components/StarRatingView";
import FatalError from "./shared/components/FatalError";
import ValidationErrors from "./shared/components/ValidationErrors";
import Success from "./shared/components/Success";
import axios from "axios";

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.filter("fromNow", (value) => moment(value).locale("it").fromNow());

Vue.component("star-rating", StarRatingView);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("v-errors", ValidationErrors);

const store = new Vuex.Store(storeDefinition);

window.axios.interceptors.response.use(
    response => response,
    error => {
        if(error.response.status === 401){
            store.dispatch("logout");
        }
        return Promise.reject(error);
    }
);

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        index: Index,
    },
    async beforeCreate() {
        await this.$store.dispatch("loadStoredState");
        await this.$store.dispatch("loadUser");
    }
});
