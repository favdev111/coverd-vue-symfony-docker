<template>
    <div class="form-group">
        <label v-text="label" />
        <select
            v-model="value.id"
            v-chosen
            class="form-control"
            :class="{'loaded': loaded}"
            @change="onChange"
        >
            <option
                value=""
                v-text="emptyOption"
            />
            <option
                v-for="item in options"
                :key="item.id"
                :selected="value.id == item.id"
                :value="item.id"
                v-text="item[displayProperty]"
            />
        </select>
    </div>
</template>

<script>
    export default {
        props: {
            value: { type: Object },
            label: { type: String },
            apiPath: {type: String },
            preloadedOptions: { type: Array, default: function() {return []}},
            displayProperty: { type: String, default: 'name'},
            emptyString: { type: String },
            alphabetize: { type: Boolean, default: true },
        },

        data() {
            return {
                listOptions: [],
            }
        },

        computed: {
            loaded: function() { return this.options.length > 0 },
            options: function() { return this.listOptions.length > 0 ? this.listOptions : this.preloadedOptions },
            emptyOption: function() { return this.emptyString ? this.emptyString : '-- Select Item --'}
        },

        created() {
            var self = this;

            if (!self.value.id) self.value.id = null;

            if (this.apiPath) {
                axios
                    .get('/api/' + this.apiPath)
                    .then(response => {
                        self.listOptions = response.data.data;
                        self.$emit('loaded');
                });
            } else {
                self.listOptions = self.preloadedOptions;
            }
        },

        methods: {
            onChange: function(event) {
                this.$emit('change', event);
            }
        }
    }
</script>