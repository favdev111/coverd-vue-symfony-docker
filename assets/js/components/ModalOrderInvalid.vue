<template>
    <modal
        id="invalidModal"
        classes="modal-danger"
        :has-action="false"
    >
        <template slot="header">
            Invalid Values
        </template>
        <p>
            <slot>
                There are incorrect values in on this order. Please see error messages next to applicable fields.
            </slot>
        </p>
        <template slot="cancelButton">
            OK
        </template>
    </modal>
</template>

<script>
    import Modal from '../components/Modal.vue';

    export default {
        components: {
            'modal' : Modal
        },
    }
</script>
