<template>
    <div>
        <h1>I'm comp A and the counter is {{counter}}</h1>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
    computed:{
        ...mapGetters({
            'counter' : 'getCounter'
        })
    },
}
</script>

<style scoped>

</style>
