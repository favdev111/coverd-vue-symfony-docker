<template>
    <modal
        id="confirmCommitModal"
        :confirm-action="action"
        classes="modal-info"
    >
        <template slot="header">
            Complete Order
        </template>
        <p>Are you sure you want to finalize <strong>{{ orderTitle }}</strong>?</p>
        <p>By completing this order you will not be able to make changes and inventory transactions will be committed.</p>
        <template slot="confirmButton">
            Complete Order
        </template>
    </modal>
</template>

<script>
    import Modal from '../components/Modal.vue';

    export default {
        components: {
            'modal' : Modal
        },
        props: {
            action: { type: Function },
            orderTitle: {type: String },
        },
    }
</script>
