<template>
    <section class="content">
        <router-link
            to="/orders/new"
            class="btn btn-success btn-flat pull-right"
        >
            <i class="fa fa-plus-circle fa-fw" />Create Order
        </router-link>
        <h3 class="box-title">
            Orders List
        </h3>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <!--
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="order in orders.data"
                                    :key="order.id"
                                >
                                    <td>
                                        <router-link :to="'/orders/' + order.id">
                                            <i class="fa fa-edit" />{{ order.id }}
                                        </router-link>
                                    </td>
                                    <td v-text="order.name" />
                                    <td v-text="order.orderCategory.name" />
                                    <td v-text="order.status" />
                                    <td>{{ order.updatedAt | dateTimeFormat }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props:[],
        data() {
            return {
                orders: {}
            };
        },
        created() {
            axios
                .get('/api/orders')
                .then(response => this.orders = response.data);
            console.log('Component mounted.')
        }
    }
</script>