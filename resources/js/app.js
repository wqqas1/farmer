require("polyfill-library-node")
import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import vClickOutside from 'v-click-outside'
import VueTailwindModal from "vue-tailwind-modal"
import VueTailwindPicker from 'vue-tailwind-picker'
import { Chrome } from 'vue-color'

Vue.component('chrome-picker', Chrome);
Vue.component("VueTailwindModal", VueTailwindModal)
Vue.component("VueTailwindPicker", VueTailwindPicker)

Vue.use(vClickOutside)
Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueMeta)

InertiaProgress.init()

let app = document.getElementById('app')

new Vue({
  metaInfo: {
    titleTemplate: (title) => title ? `${title} - Farmer` : 'Farmer'
  },
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
