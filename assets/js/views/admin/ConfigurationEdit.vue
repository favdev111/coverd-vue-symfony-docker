<template>
    <section class="content">
        <div class="pull-right">
            <button
                class="btn btn-success btn-flat"
                @click.prevent="save"
            >
                <i class="fa fa-save fa-fw" />
                Save Configuration
            </button>
        </div>
        <h3 class="box-title">
            Configuration
        </h3>

        <form role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-group fa-fw" />Expirations
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <OptionListStatic
                                v-model="settings.pullupCategory"
                                label="Pull-up Category"
                                :preloaded-options="getSimpleProductCategories"
                            />
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-calendar fa-fw" />Annual Review Process
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->

                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        Partner Annual Review
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <DateField
                                            v-model="settings.partnerReviewStart"
                                            label="Partner Review Period Start Day"
                                            format="MM/DD"
                                            class="col-xs-6"
                                        />
                                        <DateField
                                            v-model="settings.partnerReviewEnd"
                                            label="Partner Review Period Ends Day"
                                            format="MM/DD"
                                            class="col-xs-6"
                                        />
                                    </div>
                                    <div class="row">
                                        <DateField
                                            v-model="settings.partnerReviewLastStartRun"
                                            label="Last Successful Partner Review Start Process"
                                            format="MM/DD/YYYY h:mm:ss a"
                                            class="col-xs-6"
                                        />
                                        <DateField
                                            v-model="settings.partnerReviewLastEndRun"
                                            label="Last Successful Partner Review End Process"
                                            format="MM/DD/YYYY h:mm:ss a"
                                            class="col-xs-6"
                                        />
                                    </div>
                                </div>
                            </div>


                            <div class="panel box box-success">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        Client Annual Review
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <DateField
                                            v-model="settings.clientReviewStart"
                                            label="Client Review Period Start Day"
                                            format="MM/DD"
                                            class="col-xs-6"
                                        />
                                        <DateField
                                            v-model="settings.clientReviewEnd"
                                            label="Client Review Period End Day"
                                            format="MM/DD"
                                            class="col-xs-6"
                                        />
                                    </div>
                                    <div class="row">
                                        <DateField
                                            v-model="settings.clientReviewLastStartRun"
                                            label="Last Successful Client Review Start Process"
                                            format="MM/DD/YYYY h:mm:ss a"
                                            class="col-xs-6"
                                        />
                                        <DateField
                                            v-model="settings.clientReviewLastEndRun"
                                            label="Last Successful Client Review End Process"
                                            format="MM/DD/YYYY h:mm:ss a"
                                            class="col-xs-6"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-map-pin fa-fw" />Zip/County States
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <StateField
                                v-model="settings.zipCountyStates"
                                :multiple="true"
                            />
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
    import { mapGetters } from 'vuex'
    import OptionListStatic from "../../components/OptionListStatic";
    import StateField from "../../components/StateField";
    import DateField from "../../components/DateField";

    export default {
        name: "ConfigurationEdit",
        components: {DateField, StateField, OptionListStatic},
        data() {
            return {
                settings: {
                    pullupCategory: "",
                    zipCountyStates: [],
                    partnerReviewStart: null,
                    partnerReviewEnd: null,
                    partnerReviewLastStartRun: null,
                    partnerReviewLastEndRun: null,
                    clientReviewStart: null,
                    clientReviewEnd: null,
                    clientReviewLastStartRun: null,
                    clientReviewLastEndRun: null,
                }
            }
        },
        computed: {
            ...mapGetters([
                'getSimpleProductCategories',
            ]),
        },
        created() {
            let self = this;

            this.$store.dispatch('loadProductCategories');
            axios
                .get('/api/system/settings')
                .then(response => self.settings = response.data.data)
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            save: function () {
                var self = this;
                axios
                    .post('/api/system/settings', this.settings)
                    .then(response => self.settings = response.data.data)
                    .catch(function (error) {
                        console.log(error);
                });
            },

        }
    }
</script>
