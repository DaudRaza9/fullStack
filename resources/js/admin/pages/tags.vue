<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags
                        <Button @click="addModel=true" v-if="isWritePermitted">
                            <Icon type="md-add"/>
                            Add Tag
                        </Button>
                    </p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(tag ,i) in tags" :key="i" v-if="tags.length">
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">{{ tag.tagName }}</td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModel(tag,i)" v-if="isUpdatePermitted">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(tag,i)"
                                            :loading="tag.isDeleting" v-if="isDeletePermitted">Delete
                                    </Button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <!--Adding tag model-->
                <Modal
                    v-model="addModel"
                    title="Add tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input v-model="data.tagName" placeholder="Add Tag..."/>

                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Close</Button>
                        <Button type="primary" @click="addTag" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Adding..' : 'Add Tag' }}
                        </Button>
                    </div>
                </Modal>

                <!--Tag editing model-->
                <Modal
                    v-model="editModel"
                    title="Edit tag"
                    :mask-closable="false"
                    :closable="false"
                >

                    <Input v-model="editData.tagName" placeholder="Edit tag name.."/>

                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Close</Button>
                        <Button type="primary" @click="editTag" :disable="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Editing..' : 'edit Tag' }}
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
                tagName: ''
            },
            addModel: false,
            editModel: false,
            isAdding: false,
            tags: [],
            editData: {
                tagName: ''
            },
            index: -1,
            isDeleting: false,
            showDeleteModal: false,
            deleteItem:{},
            deletingIndex:-1
        }
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() === '') return this.e('Tag name is required')
            const res = await this.callApi('post', 'app/create_tag', this.data)
            if (res.status === 201) {
                this.tags.unshift(res.data)
                this.s('Tag has been added successfully!')
                this.addModel = false
                this.data.tagName = ''
            } else {
                if (res.status === 422) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editTag() {
            if (this.editData.tagName.trim() === '') return this.e('Tag name is required')
            const res = await this.callApi('post', 'app/edit_tag', this.editData)
            if (res.status === 200) {
                this.tags[this.index].tagName = this.editData.tagName
                this.s('Tag has been edited successfully!')
                this.editModel = false
            } else {
                if (res.status === 422) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        //--Edit Tag function--//
        showEditModel(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName
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
        console.log(this.isWritePermitted)
        const res = await this.callApi('get', 'app/get_tags')
        if (res.status === 200) {
            this.tags = res.data
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
