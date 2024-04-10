<template>
    <div class="adrm-reviews-wrapper"> 
        <h3>Reviews</h3>
        <div class="adrm-reviews" v-loading="loading"> 
            <el-table :data="reviews" style="width: 100%" :default-sort="{ prop: 'created_at', order: 'descending' }">
                <el-table-column prop="created_at" fixed label="Date" width="200" sortable>
                    <template #default="scope">
                        <p>{{ formatDate(scope.row.created_at) }}</p>
                    </template>
                </el-table-column>
                <el-table-column prop="email" label="Email" width="180"/>
                <el-table-column prop="message" label="Review" width="250">
                    <template #default="scope">
                        <p>{{ shortenMessage(scope.row.message) }}</p>
                    </template>
                </el-table-column>
                <el-table-column prop="rating" label="Rating" width="200" sortable>
                    <template #default="scope">
                        <el-rate v-model="scope.row.rating" disabled show-score text-color="#ff9900"></el-rate>
                    </template>
                </el-table-column>
                <el-table-column label="Profile" width="180" >
                    <template #default="scope">
                        <div style="display: flex; align-items: center">
                            <el-image :src="scope.row.avatar" style="width: 80px">
                                <template #placeholder>
                                    <div class="image-slot">Loading<span class="dot">...</span></div>
                                </template>
                            </el-image>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column fixed="right" label="Actions" >
                    <template #default="scope">
                        <div style="display: flex; gap: 10px;"> 
                            <button  @click="handleClick"> 
                                <Icon icon="Eye" />
                            </button>
                            <p>|</p>
                            <button  @click="deleteHandler(scope.row.id)"> 
                                <Icon icon="Delete" />
                            </button>
                        </div>
                    </template>
                
                </el-table-column>
            </el-table>
        </div>
        <div class="adrm_pagination">
            <div class="pager-wrap">
                <span class="text">Page 1 to {{ pagination.per_page }} of {{ total }}</span>
                <!-- <el-select v-model="pagination.per_page" placeholder="Select">
                    <el-option v-for="item in page_sizes" :key="item" :label="item + ' Per page'" :value="item" />
                </el-select> -->
            </div>

            <div class="pagination_page_list">
                <el-pagination @size-change="pageSizeChange" @current-change="changePage"
                    :current-page.sync="current_page" :page-sizes="page_sizes"
                    :page-size="pagination.per_page" layout="prev, pager, next" :total="total">
                </el-pagination>
            </div>
        </div>
        <AppModal
            width="40%"
            :dialog-visible-prop="dialogVisibleDeleteProp"
            :confirm-btn-label="'Delete'"
            :title="'Confirmation Delete review!'"
            @update:handle-dialog-close="handleDelDialogClose"
        >
            <div class="adrm-delete-confirmation">
                <p>Are you sure you want to delete this review?</p>
            </div>
        </AppModal>
    </div>
</template>

<script>
import Icon from '../../Icons/Index.vue';
import { ElNotification } from 'element-plus'
import AppModal from '../Common/AppModal.vue';
import moment from 'moment';
export default {
    name: 'Reviews',
    components: {
        Icon,
        ElNotification,
        AppModal
    },
    data() {
        return {
            reviews: [],
            loading: false,
            pagination: [],
            currentPage: 1,
            total: 0,
            page_sizes: [5, 10, 20, 50],
            max_message_length: 20,
            dialogVisibleDeleteProp: false,
            deleteReviewId: null,
        }
    },

    methods: {
        getReviews() {
            this.loading = true;
            this.$get('',
            {
                action: 'ad_review_manager_ajax',
                route: 'get_formatted_reviews',
                nonce: window.ADRMAdmin.adrm_nonce,
                formID: this.$route.params.id,
                page: this.currentPage
            }).then((response) => {
                this.reviews = response.data.reviews;
                this.pagination = response.data.pagination;
                this.total = response.data.total_reviews;
                this.loading = false;
                ElNotification({
                title: 'Successfully Deleted',
                message: 'Clicked',
                type: 'success',
                position: 'bottom-right'
            });
                }).catch(function (error) {
                this.loading = false;
                console.log(error);
            });
        },
        handleClick() {
            ElNotification({
                title: 'Success',
                message: 'Clicked',
                type: 'success',
                position: 'bottom-right'
            });
        },
        shortenMessage(message) {
            if (message.length <= this.max_message_length) {
                return message;
            } else {
                // Trim the message to the maximum length and append ellipsis
                return message.substring(0, this.max_message_length) + '...';
            }
        },
        formatDate(rawDate){
            return moment(rawDate).format('YYYY-MM-DD');
        },
        deleteHandler(id) {
            console.log('delete..id', id);
            this.deleteReviewId = id;
            this.dialogVisibleDeleteProp = true;
        },
        changePage(page) {
            this.currentPage = page;
            this.getReviews()
        },
        handleClose() {
            this.dialogVisibleDeleteProp = false;
            
        },
        handleSuccess(successOrCancel) {
            this.dialogVisible = false;
        },
        handleDelDialogClose(successOrCancel) {
            if (successOrCancel) {
                this.loading = true;
                const _that = this;
                jQuery.ajax({
                method: 'POST',
                url: window.ADRMAdmin.ajax_url,
                dataType: "json",
                data: {
                    action: "ad_review_manager_ajax",
                    route: "delete_review",
                    nonce: window.ADRMAdmin.adrm_nonce,
                    reviewID: this.deleteReviewId
                },
                success(res) {
                    _that.loading = false;
                    _that.getReviews();
                },
                error(err) {
                    _that.loading = false;
                }
                });
            }
            this.dialogVisibleDeleteProp = false;
        },
    },

    mounted() {
        this.dialogVisibleDeleteProp = false;
        this.getReviews();
    },
}
</script>
