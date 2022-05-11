<template>
    <div>
        <nav class="pagination is-centered is-small" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
        <li><a class="pagination-link" @click="gotoFirstPage" :disabled="isOnFirstPage">First</a></li>
        <li><a class="pagination-link" @click="gotoPreviousPage" :disabled="isOnFirstPage">Previous</a></li>
        <li v-for="page in pages" :key="page.name">
        <a class="pagination-link"
        @click="gotoPage(page.name)"
        :disabled="page.isDisabled"
        :class="{ active: isPageActive(page.name) }"> {{page.name}}
        </a>
        </li>
        <li><a class="pagination-link" @click="gotoNextPage" :disabled="isOnLastPage">Next</a></li>
        <li><a class="pagination-link" @click="gotoLastPage" :disabled="isOnLastPage">Last</a></li>
        </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: {
        firstPage: '',
        previousPage: '',
        currentPage: '',
        nextPage: '',
        lastPage: '',
        totalPages: '',
        url: '',
        maxVisibleButtons: '',
    },
    computed: {
        startPage() {
        if (this.currentPage === 1) {
            return 1
        }  else if (this.totalPages === 2) {
            return 1
        } else if (this.currentPage === this.totalPages) { 
            return (this.totalPages - this.maxVisibleButtons) + 1
        } 
        return this.currentPage - 1

        },

        endPage() {
        
        return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages)
        
        },

        pages() {
        const range = []

        for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
            range.push({
            name: i,
            isDisabled: i === this.currentPage 
            })
        }

        return range
        },

        isOnFirstPage() {
        return this.currentPage === 1
        },

        isOnLastPage() {
        return this.currentPage === this.totalPages;
        },
        
    },
    methods: {
        gotoPage (page) {
            this.$emit('pageChanged', this.url+ "?page=" +page)
        },
        gotoFirstPage () {
            this.$emit('pageChanged', this.firstPage)
        },
        gotoPreviousPage () {
            if (this.currentPage > 1) {
                this.$emit('pageChanged', this.url+ "?page=" +(this.currentPage -1))
            } else {
            }
        },
        gotoNextPage () {
            if (this.currentPage < this.totalPages) {
                this.$emit('pageChanged', this.url+ "?page=" +(this.currentPage +1))
            } else {
            }
        },
        gotoLastPage () {
            this.$emit('pageChanged', this.lastPage)
        },
        isPageActive(page) {
        return this.currentPage === page;
        },

    },
}
</script>

<style scoped>

ul {
  list-style: none;
}

#paginate {
  font-family: Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  margin-left: 50%;
}
/* .pagination {
  list-style-type: none;
}

.pagination-item {
  display: inline-block;
} */

.active {
  background-color: #4AAE9B;
  color: #ffffff;
}
</style>
