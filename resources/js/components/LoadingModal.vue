<template>
	<div class="pax-loading-modal">
		<div class="pax-loading-modal__spinner"></div>	
	</div>
</template>
  
  <script>
  export default {
	props: {
		visible: {
			type: Boolean,
			default: false
		}
	},
	data() {
	  return {
		isLoading: true
	  }
	},
  }
  </script>
  