<template>
    <div>
        <aside
            v-for="(exception, key) in exceptions"
            :key="exception.id"
            class="alert alert-danger alert-dismissible"
        >
            <button
                type="button"
                class="close"
                @click="exceptions.splice(key, 1)"
            >
                <i class="fa fa-fw fa-times" />
            </button>
            <button
                type="button"
                class="close"
                @click="showTrace = !showTrace"
            >
                <i class="fa fa-fw fa-search" />
            </button>
            <h4><i class="icon fa fa-ban" /> Exception: {{ exception.message }}</h4>
            <div v-show="showTrace">
                <ol>
                    <li
                        v-for="line in exception.trace"
                        :key="line.id"
                    >
                        {{ line.class }}{{ line.type }}{{ line.function }}()<br>
                        {{ line.file }}:{{ line.line }}
                    </li>
                </ol>
            </div>
        </aside>
    </div>
</template>

<script>
    export default {
        props:['exceptions'],
        data() {
            return {
                showTrace: false
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>