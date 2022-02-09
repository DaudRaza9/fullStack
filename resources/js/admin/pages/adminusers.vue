    <template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin users
                        <Button @click="addModel=true">
                            <Icon type="md-add"/>
                            Add Admin
                        </Button>
                    </p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>IDs</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(user ,i) in users" :key="i" v-if="users.length">
                                <td>{{ user.id }}</td>
                                <td class="_table_name">{{ user.fullName }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role_id }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModel(user,i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(user,i)"
                                            :loading="user.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <!--Adding admin-User model-->
                <Modal
                    v-model="addModel"
                    title="Add User"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input type="text" v-model="data.fullName" placeholder="Add fullname..."/>
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Add email..."/>
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Add password..."/>
                    </div>
                    <div class="space">
                        <Select v-model="data.role_id" placeholder="Select Admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{ r.roleName }}</Option>
                        </Select>
                    </div>


                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Close</Button>
                        <Button type="primary" @click="addAdmin" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Adding..' : 'Add User' }}
                        </Button>
                    </div>
                </Modal>

                <!--Admin User editing model-->
                <Modal
                    v-model="editModel"
                    title="Edit Admin"
                    :mask-closable="false"
                    :closable="false"
                >

                    <div class="space">
                        <Input type="text" v-model="editData.fullName" placeholder="Add fullname..."/>
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Add email..."/>
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Add password..."/>
                    </div>
                    <div class="space">
                        <Select v-model="editData.role_id" placeholder="Select Admin type">
                            <Option value="Admin" >Admin</Option>
                            <Option value="Editor" >Editor</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Close</Button>
                        <Button type="primary" @click="editAdmin" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Editing..' : 'edit Admin' }}
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
                fullName:'',
                email:'',
                password:'',
                role_id:null
            },
            addModel: false,
            editModel: false,
            isAdding: false,
            users: [],
            roles:[],
            editData: {
                tagName: ''
            },
            index: -1,
            isDeleting: false,
            showDeleteModal: false,
            deleteItem: {},
            deletingIndex: -1,

        }

    },
    methods: {
        //--Add Admin User--//
        async addAdmin() {

            if (this.data.fullName.trim() === '') return this.e('Full name is required')
            if (this.data.email.trim() === '') return this.e('Email is required')
            if (this.data.password.trim() === '') return this.e('Password is required')
            if (!this.data.role_id) return this.e('Role-Id is required')

            const res = await this.callApi('post', 'app/create_user', this.data)
            if (res.status === 201) {
                this.users.unshift(res.data)
                this.s('Admin User has been added successfully!')
                this.addModel = false
                this.data.tagName = ''
            } else {
                if (res.status === 422) {
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                } else {
                    this.swr()
                }
            }
        },

        async editAdmin() {
            if (this.editData.fullName.trim() === '') return this.e('Full name is required')
            if (this.editData.email.trim() === '') return this.e('Email is required')
            if (!this.editData.role_id) return this.e('User type is required')

            const res = await this.callApi('post', 'app/edit_user', this.editData)
            if (res.status === 200) {
                this.users[this.index] = this.editData
                this.s('User has been has been edited successfully!')
                this.editModel = false
            } else {
                if (res.status === 422) {
                    for(let i in res.editData.errors){
                        this.e(res.editData.errors[i][0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        //--Edit Tag function--//
        showEditModel(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                role_id: user.role_id
            }
            this.editData = obj
            this.editModel = true
            this.index = index
        },

        // async deleteTag() {
        //
        //     this.isDeleting = true
        //     const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
        //     if (res.status === 200) {
        //         this.tags.splice(this.deletingIndex, 1)
        //         this.s('Tag has been deleted successfully')
        //     } else {
        //         this.swr()
        //     }
        //     this.isDeleting = false
        //     this.showDeleteModal = false
        //
        // },

        showDeletingModal(tag, i) {
            // const deleteModalObj = {
            //     showDeleteModal: true,
            //     deleteUrl: 'app/delete_tag',
            //     data: tag,
            //     deletingIndex: i,
            //     isDeleted: false,
            // }
            // this.$store.commit('setDeletingModalObj', deleteModalObj)
            //
            // console.log('Delete method called')
            // this.deleteItem = tag
            // this.deletingIndex=i
            // this.showDeleteModal = true
        }

    },

    async created() {
        const [res,resRole] = await Promise.all([
            this.callApi('get', 'app/get_user'),
            this.callApi('get', 'app/get_role')
        ])

        if (res.status === 200) {
            this.users = res.data
        } else {
            this.swr()
        }
        if (resRole.status === 200) {
            this.roles = resRole.data
        } else {
            this.swr()
        }

    },
    computed: {

        ...mapGetters(['getDeleteModalObj'])

    },
    components: {

        deleteModal

    },
    // watch: {
    //
    //     getDeleteModalObj(obj) {
    //         if (obj.isDeleted) {
    //             this.tags.splice(obj.deletingIndex, 1)
    //         }
    //     },
    //
    // }
}
</script>

<style scoped>

</style>
