Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'sitemaps',
            path: '/sitemaps',
            component: require('./components/Tool'),
        },
    ])
})
