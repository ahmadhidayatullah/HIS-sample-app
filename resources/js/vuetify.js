// src/plugins/vuetify.js
// import this after install `@mdi/font` package
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'; // Import Vuetify styles
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Import any Vuetify components you use here
// import { VBtn, VTextField } from 'vuetify/components';

export default createVuetify({
  components,
  directives
});
