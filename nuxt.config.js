export default {
  srcDir: 'frontend/',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'portfolio',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
      { rel: 'preconnect', href: 'https://fonts.gstatic.com' },
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap'
      },
      {
        rel: 'stylesheet',
        href: 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css'
      }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@plugins/date-filter'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: [
    "@components",
    "@components/Auth",
    "@components/Profile",
    "@components/Profile/sub-component",
    "@components/UI",
  ],

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/typescript
    '@nuxt/typescript-build',
    '@nuxtjs/composition-api/module'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios'
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: 'http://localhost:8000'
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},

  loading: {
    color: '#58dc83',
    height: '4px'
  },

  router: {
    middleware: ['check-login']
  },

  watchers: {
    webpack: {
      aggregateTimeout: 300,
      poll: 1000,
      ignored: [
        /.git/,
        /node_modules/,
        /vendor/,
        /.husky/,
        /.nuxt/,
        /.vscode/,
        /.idea/,
        /app/,
        /bootstrap/,
        /config/,
        /database/,
        /public/,
        /resources/,
        /routes/,
        /storage/,
        /stubs/,
        /tests/,
      ],
    },
  },
}
