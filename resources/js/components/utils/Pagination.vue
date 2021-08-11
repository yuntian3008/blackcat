<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: isInFirstPage }">
                <button type="button" @click="onClickFirstPage" class="page-link" v-html="firstButtonText"></button>
            </li>

            <li class="page-item" :class="{ disabled: isInFirstPage }">
                <button type="button" @click="onClickPreviousPage" class="page-link" v-html="prevButtonText">Previous</button>
            </li>

            <!-- Visible Buttons Start -->

            <li v-for="page in pages" :key="page.name" class="page-item" :class="{ active: isPageActive(page.name) }">
            <button type="button" :disabled="page.isDisabled" @click="onClickPage(page.name)" class="page-link">
                {{ page.name }}
            </button>
            </li>

            <!-- Visible Buttons End -->

            <li class="page-item" :class="{ disabled: isInLastPage }">
                <button type="button" @click="onClickNextPage" class="page-link" v-html="nextButtonText">Next</button>
            </li>

            <li class="page-item" :class="{ disabled: isInLastPage }">
                <button type="button" @click="onClickLastPage" class="page-link" v-html="lastButtonText">Last</button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        maxVisibleButtons: {
            type: Number,
            required: false,
            default: 3,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
        firstButtonText: {
            type: String,
            required: false,
            default: 'First',
        },
        lastButtonText: {
            type: String,
            required: false,
            default: 'Last',
        },
        nextButtonText: {
            type: String,
            required: false,
            default: 'Next',
        },
        prevButtonText: {
            type: String,
            required: false,
            default: 'Previous',
        },
    },
    computed: {
        startPage() {
            // // When on the first page
            // if (this.currentPage === 1) {
            //     return 1;
            // }

            // // When on the last page
            // if (this.currentPage === this.totalPages) {
            //     return this.totalPages - this.maxVisibleButtons + 1;
            // }

            // // When < center
            // if (this.currentPage <= )

            // // When inbetween
            // return this.currentPage - Math.ceil(this.maxVisibleButtons/2);
            if (this.currentPage === 1 || this.currentPage <= Math.ceil(this.maxVisibleButtons/2)) {
            return 1;
            }

            if (this.currentPage === this.totalPages || this.currentPage > this.totalPages - Math.ceil(this.maxVisibleButtons/2)) { 
            return ((this.totalPages - this.maxVisibleButtons) < 0 ? 0 : (this.totalPages - this.maxVisibleButtons)) + 1;
            }


            return this.currentPage - Math.ceil(this.maxVisibleButtons/2) + 1;

        },
        pages() {
            const range = [];

            for (
                let i = this.startPage;
                i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
                i++
            ) {
                range.push({
                name: i,
                isDisabled: i === this.currentPage
                });
            }

            return range;
        },
        isInFirstPage() {
            return this.currentPage === 1;
        },
        isInLastPage() {
            return this.currentPage === this.totalPages;
        },
    },
    methods: {
        onClickFirstPage() {
            this.$emit('pagechanged', 1);
        },
        onClickPreviousPage() {
            this.$emit('pagechanged', this.currentPage - 1);
        },
        onClickPage(page) {
            this.$emit('pagechanged', page);
        },
        onClickNextPage() {
            this.$emit('pagechanged', this.currentPage + 1);
        },
        onClickLastPage() {
            this.$emit('pagechanged', this.totalPages);
        },
        isPageActive(page) {
            return this.currentPage === page;
        }
    },
};
</script>