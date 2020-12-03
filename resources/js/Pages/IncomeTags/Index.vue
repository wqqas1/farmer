<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Income Tags</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('income_tags.create')">
        <span>Create</span>
        <span class="hidden md:inline">Income Tag</span>
      </inertia-link>
    </div>
    <!-- Cards Start -->
    <div class="my-12 mx-auto px-4 md:px-12">
      <div class="flex flex-wrap -mx-1 lg:-mx-4">
        <!-- Column -->
        <div v-for="income_tag in income_tags.data" :key="income_tag.id" class="my-1 px-1 w-full md:w-1/3 lg:my-4 lg:px-4 lg:w-1/6">
          <!-- Article -->
          <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('income_tags.edit', income_tag.id)">
            <article class="overflow-hidden rounded-lg shadow-lg">
              <div class="px-2 py-1 font-bold text-sm mb-2" :style="'color: ' + income_tag.color">{{ income_tag.name }}</div>
              <div class="px-2 text-sm mb-2">{{ income_tag.color }}</div>
            </article>
          </inertia-link>
          <button v-if="!income_tag.deleted_at" class="ml-auto mr-auto flex items-center w-5 text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy(income_tag.id)">
            <icon name="trash" class="flex-shrink-0 w-6 h-6 fill-red-400" />
          </button>

          <!-- END Article -->

        </div>
        <!-- END Column -->

      </div>
      <pagination :links="income_tags.links" />
    </div>
    <!-- Cards End -->
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Income Tags' },
  name:'listIncomeTags',
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    income_tags: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('income_tags', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(id) {
      if (confirm('Are you sure you want to delete this income tag?')) {
        this.$inertia.delete(this.route('income_tags.destroy', id))
      }
    },
    restore(id) {
      if (confirm('Are you sure you want to restore this income tag?')) {
        this.$inertia.put(this.route('income_tags.restore', id))
      }
    },
  },
}
</script>
