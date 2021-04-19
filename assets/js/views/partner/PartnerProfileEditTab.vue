<template>
    <AttributesEditForm
        v-model="value.profile.attributes"
    />
</template>


<script>
    import DateField from "../../components/DateField";
    import TextField from "../../components/TextField";
    import NumberField from "../../components/NumberField";
    import OptionListApi from "../../components/OptionListApi";
    import TextareaField from "../../components/TextareaField";
    import RadioField from "../../components/RadioField";
    import BooleanField from "../../components/ToggleField";
    import YesNoRadioField from "../../components/YesNoRadioField";
    import AttributesEditForm from "../../components/AttributesEditForm";
    export default {
        name: 'PartnerProfileEditTab',
        components: {
            AttributesEditForm,
        },
        props: {
            new: { type: Boolean },
            value: { type: Object, required: true }
        },
        computed: {
            attributes: function () {
                if (this.value.profile.attributes) {
                    let attributes = this.value.profile.attributes;
                    return attributes.sort((a, b) => a.orderIndex - b.orderIndex)
                }

                return []
            }
        },
        created() {
        },
        methods: {
            save: function () {
                let self = this;
                if (this.new) {
                    axios
                        .post('/api/partners', this.partner)
                        .then(response => self.$router.push('/partners'))
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    axios
                        .patch('/api/partners/' + this.$route.params.id, this.partner)
                        .then(response => self.$router.push('/partners'))
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
        }
    }
</script>