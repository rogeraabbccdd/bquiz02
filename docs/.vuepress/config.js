module.exports = {
  markdown: {
    lineNumbers: true
  },
  head: [
    ['link', { rel: 'stylesheet', href: '/css/custom.css'}],
    ['link', { rel: 'shortcut icon', href: '/images/favicon.ico'}],
  ],
  markdown: {
    lineNumbers: true,
  },
  base: '/bquiz02/',
  title:'健康促進網',
  description: '國家技術士網頁設計乙級檢定第二題',
  plugins: [
    ['vuepress-plugin-container', { type: 'tip' }],
    ['vuepress-plugin-container', { type: 'warning' }],
    ['vuepress-plugin-container', { type: 'danger' }],
    'vuepress-plugin-nprogress',
    [ 
      '@vuepress/google-analytics',{
        'ga': 'UA-131804412-4'
      }
    ], 'vuepress-plugin-smooth-scroll',
  ],
  themeConfig: {
    yuu: {
      defaultDarkTheme: true,
      defaultTheme: 'blue',
      disableThemeIgnore: true,
      codeTheme: 'okaidia'
    },
    nav: [
      { text: '首頁', link: 'https://bquiz.kento520.tw' },
      { text: 'GitHub', link: 'https://github.com/rogeraabbccdd/bquiz02' },
    ],
    sidebar: [
      ['/', '首頁'],
      {
        title: '前置作業',
        collapsable: false,
        children: [
          'before/file',
          'before/sql',
          'before/func'
        ]
      },
      {
        title: '前台',
        collapsable: false,
        children: [
          'front/indexx',
          'front/main',
          'front/auth',
          'front/article',
          'front/new',
          'front/pop',
          'front/que'
        ]
      },
      {
        title: '後台',
        collapsable: false,
        children: [
          'back/acc',
          'back/new',
          'back/que',
        ]
      },
      ['end/end', '結語'],
    ]
  }
};