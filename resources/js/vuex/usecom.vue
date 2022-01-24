<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>I'll show how all other components react to changes</h1>
                <h3>The master of components : {{counter}}</h3>

                <div>
                    <comA></comA>
                </div>
                <div>
                    <comB></comB>
                </div>
                <div>
                    <comC></comC>
                </div>

                <button class="btn btn-info" type="info" @click="changeCounter">Change state</button>

            </div>

        </div>

    </div>
</template>

<script>

import comA from './comA'
import comB from './comB'
import comC from './comC'
import {mapGetters,mapActions} from 'vuex'

export default {
    data(){
        return {
            // getCounter: getCounter
        }
    },
    created() {
    },

    methods:{
        changeCounter(){
            this.$store.dispatch('changeCounterAction',1)
            // this.$store.commit('changeTheCounter',1)
        },
        runSomethingWhenCounterChange(){
            console.log('I am running each change happening')
        }
    },
    computed:{
      ...mapGetters({
          'counter' : 'getCounter'
      })
    },
    components:{
        comA,
        comB,
        comC,
    },
    watch:{
        counter(value){
            console.log('counter is changing',value)
            this.runSomethingWhenCounterChange()
        }
    }
}
</script>

<style scoped>

</style>
