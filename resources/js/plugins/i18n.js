import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from '../locales/en.json'
import id from '../locales/id.json'

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'en',
    messages: {
        en,
        id
    }
})

export default i18n
