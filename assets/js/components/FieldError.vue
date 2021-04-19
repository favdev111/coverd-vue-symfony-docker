<template>
    <span
        class="help-block"
        :class="classes"
    >
        <i class="icon fa fa-warning fa-fw" /><slot /></span>
</template>

<script>
    export default {
        props: {
            classes: { type: String }
        },
    }
</script>