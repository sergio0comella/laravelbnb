<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Riepilogo costi
        </h6>

        <div
            v-for="(days, price) in price.breakdown"
            :key="price"
            class="pt-2 pb-2 border-top border-bottom d-flex justify-content-between"
        >
            <span>{{ days }} x &euro; {{ price }}</span><span> &euro; {{ days * price }}</span>
        </div>
        <div class="font-weight-bold pt-2 d-flex justify-content-between">
            <span>Totale</span> <span>&euro; {{ price.total }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "PriceBreakdown",
    props: {
        price: Object,
    },
};
</script>

<style scoped></style>
