<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Users</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Role:</label>
        <select v-model="form.role" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="user">User</option>
          <option value="owner">Owner</option>
        </select>
        <label class="mt-4 block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('users.create')">
        <span>Create</span>
        <span class="hidden md:inline">User</span>
      </inertia-link>
    </div>
    <!-- Cards Start -->
    <div class="my-12 mx-auto px-4 md:px-12">
      <div class="flex flex-wrap -mx-1 lg:-mx-4">
        <!-- Column -->
        <div v-for="user in users.data" :key="user.id" class="my-1 px-1 w-full md:w-1/3 lg:my-4 lg:px-4 lg:w-1/5">
          <!-- Article -->
          <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('users.edit', user.id)">
          <article class="overflow-hidden rounded-lg shadow-lg">
            <img v-if="user.photo" class="block h-auto w-full" :src="user.photo">
            <icon v-if="user.deleted_at" name="trash" class="flex-shrink-0 w-8 h-8 fill-gray-400 ml-2" />
            <div class="px-2 py-1 font-bold text-sm mb-2">{{ user.name }}</div>
            <div class="px-2 text-sm mb-2">{{ user.phone }}</div>
            <div class="px-2 text-sm mb-2">{{ user.email }}</div>

          </article>
          </inertia-link>
          <!-- END Article -->

        </div>
        <!-- END Column -->

      </div>
      <pagination :links="users.links" />
    </div>
    <!-- Cards End -->

  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'
import Pagination from '@/Shared/Pagination'

export default {
  metaInfo: { title: 'Users' },
  name:'listUsers',
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
    Pagination,
  },
  props: {
    users: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        role: this.filters.role,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('users', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
