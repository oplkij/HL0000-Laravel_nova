Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'floorplan',
            path: '/floorplan',
            component: require('./components/Tool'),
        },
    ])
})
