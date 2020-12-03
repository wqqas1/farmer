<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('goals')">Goals</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow max-w-3xl">
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
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create Goal</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import AutoComplete from '@/Shared/AutoComplete';
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Create Goal' },
  name:'createGoal',
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    AutoComplete,
  },
  props: {
    errors: Object,
    periods: Object,
    income_tags: Array,
    expense_tags: Array,
    types: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        period: null,
        income_tag_id: null,
        expense_tag_id: null,
        amount: null,
        starts_on: null,
        ends_on: null
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post(this.route('goals.store'), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>
