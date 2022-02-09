<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Role Management
                        <Button @click="addModel=true">
                            <Icon type="md-add"/>
                            Add new Role
                        </Button>
                    </p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Role type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(role ,i) in roles" :key="i" v-if="roles.length">
                                <td>{{ role.id }}</td>
                                <td class="_table_name">{{ role.roleName }}</td>
                                <td>{{ role.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModel(role,i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(role,i)"
                                            :loading="role.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <!--Adding Role model-->
                <Modal
                    v-model="addModel"
                    title="Add role"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input v-model="data.roleName" placeholder="Role Name..."/>

                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Close</Button>
                        <Button type="primary" @click="addRole" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Adding..' : 'Add Role' }}
                        </Button>
                    </div>
                </Modal>

                <!--Role editing model-->
                <Modal
                    v-model="editModel"
                    title="Edit role"
                    :mask-closable="false"
                    :closable="false"
                >

                    <Input v-model="editData.roleName" placeholder="Edit role name.."/>

                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Close</Button>
                        <Button type="primary" @click="editRole" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Editing..' : 'edit Role' }}
                        </Button>
                    </div>
                </Modal>

                <!--Tag delete confirmation-->
                <!--                <Modal v-model="showDeleteModal" width="360">-->
                <!--                    <p slot="header" style="color:#f60;text-align:center">-->
                <!--                        <Icon type="ios-information-circle"></Icon>-->
                <!--                        <span>Delete confirmation</span>-->
                <!--                    </p>-->
                <!--                    <div style="text-align:center">-->
                <!--                        <p>Are you sure you want to delete tag ?</p>-->
                <!--                        <p>Will you delete it?</p>-->
                <!--                    </div>-->
                <!--                    <div slot="footer">-->
                <!--                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>-->
                <!--                    </div>-->
                <!--                </Modal>-->

                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue'
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            data: {
                roleName: ''
            },
            addModel: false,
            editModel: false,
            isAdding: false,
            roles: [],
            editData: {
                    roleName: ''
            },
            index: -1,
            isDeleting: false,
            showDeleteModal: false,
            deleteItem:{},
            deletingIndex:-1
        }
    },
    methods: {
        async addRole() {
            if (this.data.roleName.trim() === '') return this.e('Role name is required')
            const res = await this.callApi('post', 'app/create_role', this.data)
            if (res.status === 201) {
                this.roles.unshift(res.data)
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

        async editRole() {
            if (this.editData.roleName.trim() === '') return this.e('Role name is required')
            const res = await this.callApi('post', 'app/edit_role', this.editData)
            if (res.status === 200) {
                this.roles[this.index].roleName = this.editData.roleName
                this.s('Role has been edited successfully!')
                this.editModel = false
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

        //--Edit Tag function--//
        showEditModel(role, index) {
            let obj = {
                id: role.id,
                roleName: role.roleName
            }
            this.editData = obj
            this.editModel = true
            this.index = index
        },

        async deleteTag() {
            this.isDeleting = true
            const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
            if (res.status === 200) {
                this.tags.splice(this.deletingIndex, 1)
                this.s('Tag has been deleted successfully')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.showDeleteModal = false
        },

        showDeletingModal(tag, i){
            const deleteModalObj = {
                showDeleteModal:true,
                deleteUrl : 'app/delete_tag',
                data:tag,
                deletingIndex: i,
                isDeleted:false,
            }
            this.$store.commit('setDeletingModalObj',deleteModalObj)

            console.log('Delete method called')
            // this.deleteItem = tag
            // this.deletingIndex=i
            // this.showDeleteModal = true
        }

    },

    async created() {
        const res = await this.callApi('get', 'app/get_role')
        if (res.status === 200) {
            this.roles = res.data
        } else {
            this.swr()
        }
    },

    computed:{
        ...mapGetters(['getDeleteModalObj'])
    },
    components:{
        deleteModal
    },
    watch:{
        getDeleteModalObj(obj){
            if(obj.isDeleted){
                this.tags.splice(obj.deletingIndex,1)
            }
        },
    }
}
</script>

<style scoped>

</style>
