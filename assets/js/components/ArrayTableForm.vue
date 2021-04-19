<template>
    <div>
        <label
            v-if="label"
            v-text="label"
        />
        <button
            type="button"
            class="btn btn-sm btn-success pull-right"
            title="Add"
            @click="value.push(null)"
        >
            <i class="fa fa-plus" />
        </button>
        <table class="table table-hover table-condensed">
            <thead>
                <th
                    v-if="keyName"
                    v-text="keyName"
                />
                <th
                    v-if="valueName"
                    v-text="valueName"
                />
            </thead>
            <tbody>
                <tr
                    v-for="(val, key) in value"
                    :key="val.id"
                >
                    <td
                        v-if="keyName"
                        v-text="key"
                    />
                    <td class="input-group input-group-sm">
                        <input
                            v-model="value[key]"
                            type="text"
                            class="form-control"
                        >
                        <span class="input-group-btn">
                            <button
                                type="button"
                                class="btn btn-danger"
                                title="Delete"
                                @click="value.splice(key, 1)"
                            >
                                <i class="fa fa-times" />
                            </button>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            keyName: { default: false },
            valueName: { type: [String, Boolean], default: false },
            label: { type: String },
            value: { required: true },
        }
    }
</script>