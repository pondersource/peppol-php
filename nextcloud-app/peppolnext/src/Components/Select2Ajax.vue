<template>
	<select id="select2ajax-template" style="width: 100%">
	</select>
</template>

<script>
export default {
	name: 'Select2Ajax',
	props: ['options', 'value'],
	template: '#select2ajax-template',
	mounted: () => {
		const vm = this
		$(this.$el)
			// init select2
			.select2({
				ajax: {
					url: 'https://api.github.com/search/repositories',
					dataType: 'json',
					delay: 500,
					cache: true,
					data: (params) => {
						const query = {
							search: params.term,
							_type: 'query',
							q: params.term
						}
						// Query parameters will be ?search=[search]&_type=query&q=q
						return query
					},
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
					processResults: (data) => {
						// Tranforms the top-level key of the response object from 'items' to 'results'
						const resultData = $.map(data.items, function(obj) {
							obj.text = obj.name
							return obj
						})
						return {
							results: resultData
						}
					}
				},
				placeholder: 'Select an option',
				minimumInputLength: 3,
				templateResult: (repo) => {
					if (repo.id) {
						return repo.id + ' : ' + repo.text
					}
					return repo.text
				},
				templateSelection: (repo) => {
					if (repo.id) {
						return repo.id + ' : ' + repo.text
					}
					return repo.text
				}
			})
			.val(this.value)
			.trigger('change')
			// emit event on change.
			.on('change', function() {
				vm.$emit('input', this.value)
			})
	},
	watch: {
		value: function(value) {
			// update value
			$(this.$el).val(value)
		},
		options: function(options) {
			// update options
			$(this.$el)
				.empty()
				.select2({ data: options })
		}
	},
	destroyed: () => {
		$(this.$el)
			.off()
			.select2('destroy')
	}
}
</script>

<style>
</style>
