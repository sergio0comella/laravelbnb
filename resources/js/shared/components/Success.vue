<template>
    <div>
        <div class="text-center success">
            <i class="fas fa-thumbs-up"></i>
            <h1 class="mt-4">Successo</h1>
            <h2>
                <slot></slot>
            </h2>
        </div>
    </div>
</template>

<script>
export default {
    name: "Success"
}
</script>

<style scoped>
.success{
    color: #999;
    font-size: 10rem;
}
</style>
