<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('goals')">Goals</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="goal.deleted_at" class="mb-6" @restore="restore">
      This goal has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.amount" :error="errors.amount" class="pr-6 pb-8 w-full lg:w-1/2" label="Amount" />
          <select-input v-model="form.period" :error="errors.period" class="pr-6 pb-8 w-full lg:w-1/2" label="Period">
            <option v-for="period in periods" :key="period" :value="period">{{ period }}</option>
          </select-input>
          <select-input v-model="form.type" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type">
            <option v-for="type in types" :key="type" :value="type">{{ type }}</option>
          </select-input>
          <auto-complete
            :data="income_tags"
            v-model.trim="form.income_tag_id"
            :error="errors.income_tag_id"
            placeholder="Search income tags..."
            label="Income Tag"
          ></auto-complete>
          <auto-complete
            :data="expense_tags"
            input-class="form-input"
            v-model.trim="form.expense_tag_id"
            :error="errors.expense_tag_id"
            placeholder="Search expense tags..."
            label="Expense Tag"
          ></auto-complete>
          <VueTailwindPicker
            @change="(v) => form.starts_on = v"
          >
            <text-input v-model="form.starts_on" :error="errors.starts_on" class="pr-6 pb-8 w-full" label="Starts" />
          </VueTailwindPicker>
          <VueTailwindPicker
            @change="(v) => form.ends_on = v"
          >
            <text-input v-model="form.ends_on" :error="errors.ends_on" class="pr-6 pb-8 w-full" label="Ends" />
          </VueTailwindPicker>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!goal.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Goal</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update Goal</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return {
      title: `${this.form.name}`,
    }
  },
  name:'createGoal',
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    errors: Object,
    goal: Object,
    organizations: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        first_name: this.goal.first_name,
        last_name: this.goal.last_name,
        organization_id: this.goal.organization_id,
        email: this.goal.email,
        phone: this.goal.phone,
        address: this.goal.address,
        city: this.goal.city,
        region: this.goal.region,
        country: this.goal.country,
        postal_code: this.goal.postal_code,
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.put(this.route('goals.update', this.goal.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this goal?')) {
        this.$inertia.delete(this.route('goals.destroy', this.goal.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this goal?')) {
        this.$inertia.put(this.route('goals.restore', this.goal.id))
      }
    },
  },
}
</script>
