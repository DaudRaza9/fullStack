<template>
    <div>
        <div ref="myref"> Hook tutorial</div>
        <p>My name is: {{name}}</p>
        <span></span>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: 'daud'
        }
    },
    beforeCreate() {
        console.log(this.name)
    },
    created() {
        console.log("data not available but this time it is and owner is ",this.name)
    },
    mounted() {
        console.log(this.$refs.myref)
    }
}
</script>

<style scoped>

</style>
