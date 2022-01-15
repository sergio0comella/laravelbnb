<template>

    <div class="d-flex">
        <i v-for="star in fullStars" :key="'full' + star" class="fas fa-star"
           @click="$emit('input', star)"></i>
        <i v-for="star in halfStars" :key="'half' + star" class="fas fa-star-half-alt"></i>
        <i v-for="star in emptyStarts" :key="'empty' + star" aria-hidden="true" class="far fa-star"
           @click="$emit('input', fullStars + star)"></i>
    </div>
</template>

<script>
export default {
    name: "StarRatingView",
    props: {
        value: Number
    },
    computed: {
        halfStars() {
            return (this.value - Math.floor(this.value)) * 100;
        },
        fullStars() {
            return Math.round(this.value);
        },
        emptyStarts() {
            return 5 - Math.ceil(this.value);
        }

    },
}
</script>

<style scoped></style>
