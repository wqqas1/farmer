<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Goals</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('goals.create')">
        <span>Create</span>
        <span class="hidden md:inline">Goal</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap" v-if="goals.data.length > 0">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Amount</th>
          <th class="px-6 pt-6 pb-4">Period</th>
          <th class="px-6 pt-6 pb-4">Starts</th>
          <th class="px-6 pt-6 pb-4">Ends</th>
          <th class="px-6 pt-6 pb-4">Action</th>
        </tr>
        <tr v-for="goal in goals.data" :key="goal.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('goals.edit', goal.id)">
              {{ goal.name }}
              <icon v-if="goal.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('goals.edit', goal.id)" tabindex="-1">
              {{ goal.amount }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('goals.edit', goal.id)" tabindex="-1">
              {{ goal.period }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('goals.edit', goal.id)" tabindex="-1">
              {{ contact.starts_on }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('goals.edit', goal.id)" tabindex="-1">
              {{ contact.ends_on }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('goals.edit', goal.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
            <button v-if="!goal.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy(goal.id)">Delete</button>
            <button v-if="goal.deleted_at" class="text-green-600 hover:underline" tabindex="-1" type="button" @click="restore(goal.id)">Restore</button>
          </td>
        </tr>
      </table>
      <table v-else class="w-full whitespace-no-wrap">
        <tr>
          <td class="border-t px-6 py-4" colspan="4">No goals found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="goals.links" />
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
  metaInfo: { title: 'Goals' },
  name:'listGoals',
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    goals: Object,
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
        this.$inertia.replace(this.route('goals', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(id) {
      if (confirm('Are you sure you want to delete this goal?')) {
        this.$inertia.delete(this.route('goals.destroy', id))
      }
    },
    restore(id) {
      if (confirm('Are you sure you want to restore this goal?')) {
        this.$inertia.put(this.route('goals.restore', id))
      }
    },
  },
}
</script>
