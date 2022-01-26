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
                    <div class="_overflow _table_div blog_editor">

                        <editor
                            ref="editor"
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"
                        />
                    </div>
                    <div class="_input_field">
                        <input type="text" placeholder="title"></input>
                    </div><div class="_input_field">
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
            console.log(response)
        },
        async save(){
            const res = await this.$refs.editor._data.state.editor.save();
        }
    },

}
</script>

<style>
.blog_editor {
    width: 500px;
    margin-left: 160px;
    padding: 4px 7px;
    font-size: 14px;
    border: 1px solid #dcdee2;
    border-radius: 4px;
    color: #515a6e;
    background-color: #fff;
    background-image: none;
    z-index:  -1;
}
.blog_editor:hover {
    border: 1px solid #57a3f3;
}
._input_field input{
    margin: 20px 0 20px 160px;
    width: 500px;
}
._input_field input:hover{
    border: 1px solid #57a3f3;
}
</style>
