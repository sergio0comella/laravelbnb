<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Verifica disponibilit&agrave;
            <span v-if="noAvaibility" class="text-danger"
                >(Non disponibile)</span
            >
            <span v-if="hasAvaibility" class="text-success">(Disponibile)</span>
        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">Da</label>
                <input
                    id="from"
                    v-model="from"
                    :class="[{ 'is-invalid': errorFor('from') }]"
                    class="form-control form-control-sm"
                    name="from"
                    placeholder="Data inizio"
                    type="text"
                    @keyup.enter="check()"
                />
                <v-errors :errors="errorFor('from')"></v-errors>
            </div>

            <div class="form-group col-md-6">
                <label for="to">A</label>
                <input
                    id="to"
                    v-model="to"
                    :class="[{ 'is-invalid': errorFor('to') }]"
                    class="form-control form-control-sm"
                    name="to"
                    placeholder="Data fine"
                    type="text"
                    @keyup.enter="check()"
                />
                <v-errors :errors="errorFor('to')"></v-errors>
            </div>
        </div>

        <check :loading="loading" v-on:check="check">Check</check>
    </div>
</template>

<script>
import { is422 } from "../shared/utils/response";
import validationErrors from "../shared/mixins/validationErrors";
import Check from "../shared/components/Check";

export default {
    name: "Avaibility.vue",
    components: {Check},
    mixins: [validationErrors],
    props: {
        bookableId: [String, Number],
    },
    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            status: null,
        };
    },
    methods: {
        async check() {
            this.loading = true;
            this.errors = null;

            await this.$store.dispatch("setLastSearch", {
                from: this.from,
                to: this.to,
            });
            try{
                this.status = (await axios.get(
                    "/api/bookables/" +
                    this.bookableId +
                    "/availability?from=" +
                    this.from +
                    "&to=" +
                    this.to
                )).status;
                this.$emit("availability", this.hasAvaibility);
            }catch (error){
                if (is422(error)) {
                    this.errors = error.response.data.errors;
                }
                this.status = error.response.status;
                this.$emit("availability", this.hasAvaibility);
            }

            this.loading = false;
        },
    },
    computed: {
        hasErrors() {
            return this.status === 422 && this.errors !== null;
        },
        hasAvaibility() {
            return this.status === 200;
        },
        noAvaibility() {
            return this.status === 404;
        },
    },
};
</script>

<style scoped>
label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: gray;
    font-weight: bolder;
}

.is-invalid,
.invalid-feedback {
    border-color: #bb2222;
}
</style>
