export default defineComponent({
    setup() {
      // this works because pinia knows what application is running inside of
      // `setup()`
      const main = useMainStore()
      return { main }
    },
  })
