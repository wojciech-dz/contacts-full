<script setup>
import {ref, defineEmits} from 'vue'

const emits = defineEmits(['pagechanged'])

const props = defineProps({
  maxVisibleButtons: {
    type: Number,
    required: false,
    default: 3
  },
  totalPages: {
    type: Number,
    required: true
  },
  perPage: {
    type: Number,
    default: 10
  },
  currentPage: {
    type: Number,
    required: true
  }
});

const pages = ref([])
const isInFirstPage = ref(true)
const isInLastPage = ref(false)

recalculatePages(props.currentPage)

function drawButtons(startPage, endPage, page) {
  pages.value = [];
  for (let i = startPage; i <= endPage; i++) {
    pages.value.push({
      name: i,
      isDisabled: i === page
    });
  }

  isInFirstPage.value = page === 1
  isInLastPage.value = page === props.totalPages
}

function recalculatePages(current) {
  let offset = ~~(props.maxVisibleButtons / 2);
  let begin = (current < props.totalPages - offset)
    ? current <= offset ? 1 : current - offset
    : props.totalPages - props.maxVisibleButtons + 1
  let end = Math.min(begin + props.maxVisibleButtons - 1, props.totalPages);
  drawButtons(begin, end, current)
}

function onClickFirstPage() {
  recalculatePages(1)
  emits('pagechanged', 1);
}
function onClickLastPage() {
  recalculatePages(props.totalPages)
  emits('pagechanged', props.totalPages);
}
function onClickPrevPage() {
  let page = props.currentPage > 1 ? props.currentPage - 1 : 1
  recalculatePages(page)
  emits('pagechanged', page);
}
function onClickNextPage() {
  let page = props.currentPage < props.totalPages ? props.currentPage + 1 : props.totalPages
  recalculatePages(page)
  emits('pagechanged', page);
}
function onClickPage(page) {
  recalculatePages(page)
  emits('pagechanged', page);
}
</script>

<template>
  <ul class="pagination">
    <li class="pagination-item"><button type="button" @click="onClickFirstPage" :disabled="isInFirstPage"> << </button></li>
    <li class="pagination-item"><button type="button" @click="onClickPrevPage" :disabled="isInFirstPage"> < </button></li>

    <li v-for="page in pages" :key="page.name" class="pagination-item">
      <button type="button" @click="onClickPage(page.name)" :disabled="page.isDisabled">{{ page.name }}</button>
    </li>

    <li class="pagination-item"><button type="button" @click="onClickNextPage" :disabled="isInLastPage"> > </button></li>
    <li class="pagination-item"><button type="button" @click="onClickLastPage" :disabled="isInLastPage"> >> </button></li>
  </ul>
</template>