<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Manage Role
                        <Button @click="addModel=true">
                            <Icon type="md-add"/>
                            Add new Role
                        </Button>
                    </p>
                    <div class="_overflow _table_div">

                        <editor
                            ref="editor"
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"
                        />

                        <Button type="primary" @click="save">Save the data</Button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    data() {
        return {
            config: {
                image: {
                    field: 'image',
                    types: 'image/*',
                },
            },
            initData:'<h1>this is some data</h1>',
            data: {}
        }
    },
    methods: {
        async addRole() {
            if (this.data.roleName.trim() === '') return this.e('Role name is required')
            const res = await this.callApi('post', 'app/create_role', this.data)
            if (res.status === 201) {
                this.tags.unshift(res.data)
                this.s('Role has been added successfully!')
                this.addModel = false
                this.data.roleName = ''
            } else {
                if (res.status === 422) {
                    if (res.data.errors.roleName) {
                        this.e(res.data.errors.roleName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },

        onSave(response){
            console.log('Response on save',response)
        },
        async save(){
            this.$refs.editor.save()
        }
    },

}
</script>

<style scoped>

</style>
