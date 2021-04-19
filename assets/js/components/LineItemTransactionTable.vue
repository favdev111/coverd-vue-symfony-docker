<template>
    <table class="table table-condensed table-bordered">
        <thead>
            <tr class="bg-gray-light">
                <th>Transaction ID</th>
                <th>Storage Location</th>
                <th>Product</th>
                <th>Inventory Change</th>
                <th>Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="transaction in transactions"
                :key="transaction.id"
            >
                <td>
                    {{ transaction.id }}
                </td>
                <td>
                    {{ transaction.storageLocation.title }}
                </td>
                <td>
                    {{ transaction.product.name }}
                </td>
                <td>
                    {{ transaction.delta }}
                </td>
                <td>
                    {{ transaction.cost }}
                </td>
                <td>
                    {{ transaction.isCommitted ? 'Committed' : "Pending" }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: {
            transactions: { type: Array, required: false, default: function() { return [] } },
        },

    }
</script>