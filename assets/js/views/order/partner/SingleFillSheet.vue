<template>
    <fillsheet
        :order="order"
        :products="products"
    />
</template>

<script>
    import FillSheet from '../../../components/FillSheet.vue';
    export default {
        components: {
            'fillsheet' : FillSheet
        },
        data() {
            return {
                order: {
                    bags: [],
                    partner: {},
                },
                products: [],
            };
        },
        created() {
            axios
                .get('/api/orders/partner/' + this.$route.params.id, {
                    params: { include: ['bags', 'lineItems', 'lineItems.product']}
                })
                .then(response => this.order = response.data.data);
            axios
                .get('/api/products', {params: { partnerOrderable: 1}})
                .then(response => this.products = response.data.data);
        }
    }
</script>
