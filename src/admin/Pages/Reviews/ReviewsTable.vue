<template>
    <div class="adrm-reviews-wrapper"> 
        <h3>Reviews</h3>
        <div class="adrm-reviews" v-loading="loading"> 
            <el-table :data="reviews" style="width: 100%" :default-sort="{ prop: 'created_at', order: 'descending' }" lazy>
                <el-table-column prop="created_at" fixed label="Date" width="200" sortable>
                    <template #default="scope">
                        <p>{{ formatDate(scope.row.created_at) }}</p>
                    </template>
                </el-table-column>
                <el-table-column prop="email" label="Email" width="180"/>
                <el-table-column prop="message" label="Review" width="250" />
                <el-table-column prop="rating" label="Rating" width="200" sortable>
                    <template #default="scope">
                        <el-rate v-model="scope.row.rating" disabled show-score text-color="#ff9900"></el-rate>
                    </template>
                </el-table-column>
                <el-table-column label="Thumbnail" width="180" >
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
                <el-table-column fixed="right" label="Operations">
                <template #default>
                    <el-button link type="primary" size="small" @click="handleClick"
                    >Detail</el-button
                    >
                    <el-button link type="danger" size="small">Delete</el-button>
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
    </div>
</template>

<script>
import Icon from '../../Icons/Index.vue';
import { ElNotification } from 'element-plus'
import moment from 'moment';
export default {
    name: 'Reviews',
    components: {
        Icon,
        ElNotification
    },
    data() {
        return {
            reviews: [],
            loading: false,
            pagination: [],
            currentPage: 1,
            total: 0,
            page_sizes: [5, 10, 20, 50]
        }
    },

    methods: {
        getReviews() {
            this.loading = true;
            const _that = this;
            this.$get('',
            {
                action: 'ad_review_manager_ajax',
                route: 'get_formatted_reviews',
                nonce: window.ADRMAdmin.adrm_nonce,
                formID: this.$route.params.id,
                page: this.currentPage
            }).then(function (response) {
                _that.reviews = response.data.reviews;
                _that.pagination = response.data.pagination;
                _that.total = response.data.total_reviews;
                _that.loading = false;
                }).catch(function (error) {
                _that.loading = false;
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
        formatDate(rawDate){
            return moment(rawDate).format('YYYY-MM-DD');
        },
        changePage(page) {
            this.currentPage = page;
            this.getReviews()
        },
        
    },

    mounted() {
        this.getReviews();
    },
}
</script>
