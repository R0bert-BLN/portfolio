import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { VDateInput } from "vuetify/labs/components";
import { createVuetify } from 'vuetify'

import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const myTheme = {
    dark: true,
    colors: {
        background: '#141313',
        surface: '#141313',
        primary: '#2475c8',
        secondary: '#141313',
        error: '#ff5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',

        'on-background': '#ced0d1',
        'on-surface': '#ced0d1',
    },
}

const vuetify = createVuetify({
    components: {
        ...components,
        VDateInput
    },
    directives,
    theme: {
        defaultTheme: 'myTheme',
        themes: {
            myTheme,
        },
    },
})

export default vuetify
