<script>
import { useStore } from '../store/presence_index'

export default {
  setup() {
    const store = useStore()

    function addItemToCart() {
      store.addItem()
    }

    return {
      // you can return the whole store instance to use it in the template
      addItemToCart,
      store,
    }
  },
}
</script>

<template>
  <div>
    <button @click="addItemToCart">
      From A: {{ store.rawItems }}
    </button>
  </div>
</template>
