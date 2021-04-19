<template>
    <modal
        id="bulkDeleteModal"
        :confirm-action="action"
        classes="modal-danger"
    >
        <template slot="header">
            Bulk {{ bulkDeleteType }}
        </template>
        <p>Are you sure you want to bulk {{ bulkDeleteType }} the following <strong>{{ items.length }}</strong> <strong>{{ itemType }}</strong>?</p>
        <ul>
            <li
                v-for="item in items"
                :key="item.id"
                v-text="item"
            />
        </ul>
        <template slot="confirmButton">
            Bulk {{ bulkDeleteType }}
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
            itemType: { type: String, default: 'orders' },
            items: { type: Array },
            bulkDeleteType: { type: String, default: 'delete' }
        },
    }
</script>
