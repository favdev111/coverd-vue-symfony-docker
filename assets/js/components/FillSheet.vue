<template>
    <section class="content">
        <h3 class="box-title">
            Fill Worksheet
        </h3>
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-body">
                        <h2
                            class="box-title"
                            v-text="order.partner.title"
                        />
                        <div>
                            <strong>Order Month:</strong> {{ order.orderPeriod | dateTimeMonthFormat }}
                        </div>
                        <div>
                            <strong>Fulfillment Period:</strong> {{ order.partner.fulfillmentPeriod.name }}
                        </div>
                        <div>
                            <strong>Distribution Method:</strong> {{ order.partner.distributionMethod ? order.partner.distributionMethod.name : null }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class=" col-xs-12">
                <div class="box">
                    <div class="box-body no-padding">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th />
                                    <th
                                        v-for="product in products"
                                        :key="product.id"
                                        :class="{'text-black': isLight(product.color), 'text-white': !isLight(product.color)}"
                                        :style="'background-color:'+product.color+' !important;'"
                                        v-text="product.name"
                                    />
                                    <th>Total Packs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Packs</td>
                                    <td
                                        v-for="product in products"
                                        :key="product.id"
                                        v-text="productTotals[product.name]"
                                    />
                                    <td v-text="totalPacks" />
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class=" col-xs-12">
                <div class="box">
                    <div class="box-body no-padding">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th
                                        :colspan="products.length + 2"
                                        v-text="order.partner.title"
                                    />
                                </tr>
                                <tr>
                                    <th />
                                    <th
                                        v-for="product in products"
                                        :key="product.id"
                                        :class="{'text-black': isLight(product.color), 'text-white': !isLight(product.color)}"
                                        :style="'background-color:'+product.color+' !important;'"
                                        v-text="product.name"
                                    />
                                    <th>Total Packs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(bag, index) in order.bags"
                                    :key="bag.id"
                                >
                                    <th>Bag {{ index + 1 }}</th>
                                    <td
                                        v-for="product in products"
                                        :key="product.id"
                                        v-text="packCountFromProduct(bag, product.name)"
                                    />
                                    <td v-text="bag.totalPacks" />
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            order: { type: Object, required: true },
            products: { type: Array, required: true },
        },
        computed: {
            productTotals() {
                let packTotals = {};
                this.products.forEach(function(product) {
                    packTotals[product.name] = 0;
                });

                this.order.bags.forEach(function(bag) {
                    for (name in packTotals) {
                        if (bag.packCounts[name]) {
                            packTotals[name] += bag.packCounts[name];
                        }
                    }
                });

                return packTotals;
            },
            totalPacks() {
                let total = 0;
                this.order.bags.forEach(function(bag) {
                    for (name in bag.packCounts) {
                        total += bag.packCounts[name];
                    }
                });
                return total;
            }
        },
        methods: {
            packCountFromProduct(bag, name) {
                let count = null;
                if (bag.packCounts[name]) {
                    count = bag.packCounts[name];
                }
                return count;
            },
            isLight(hex) {
                let color = tinycolor(hex);
                return color.isLight();
            },
            packSizefromProduct: function (product) {
                if (this.order.partner.partnerType === 'HOSPITAL' && product.hospitalPackSize) {
                    return product.hospitalPackSize;
                }

                return product.agencyPackSize;
            },
        },
    }
</script>