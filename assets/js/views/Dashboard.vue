<template>
    <section class="content">
        <h3 class="box-title">
            Dashboard
        </h3>
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">
                        <h3 class="box-title">
                            Warehouse Inventory
                        </h3>
                        <WarehouseStock />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import WarehouseStock from '../components/dashboard/WarehouseStock.vue'
    export default {
        components: {WarehouseStock},

        props:[],
        data() {
            return {};
        }
    }
</script>