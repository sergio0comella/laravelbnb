<template>
<span>
    <button
        :disabled="loading"
        class="btn btn-secondary btn-block"
        @click="$emit('check')"
    >
        <span v-if="!loading"><slot></slot></span>
        <span v-if="loading"><i class="fas fa-circle-notch fa-spin"></i> Checking... </span>
    </button>
</span>
</template>

<script>
export default {
    name: "Check",
    props: {
        loading: false
    }
}
</script>

<style scoped>

</style>
