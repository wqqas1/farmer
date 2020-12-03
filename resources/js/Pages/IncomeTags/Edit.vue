<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('income_tags')">Income Tags</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="income_tag.deleted_at" class="mb-6" @restore="restore">
      This goal has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <chrome-picker :value="form.color" @input="(c) => form.color = c.hex"></chrome-picker>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!income_tag.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Income Tag</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update Income Tag</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return {
      title: `${this.form.name}`,
    }
  },
  name:'editIncomeTag',
  layout: Layout,
  components: {
    LoadingButton,
    TextInput,
    TrashedMessage,
  },
  props: {
    errors: Object,
    income_tag: Object
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.income_tag.name,
        color: this.income_tag.color
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.put(this.route('income_tags.update', this.income_tag.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this income tag?')) {
        this.$inertia.delete(this.route('income_tags.destroy', this.income_tag.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this income tag?')) {
        this.$inertia.put(this.route('income_tags.restore', this.income_tag.id))
      }
    },
  },
}
</script>
