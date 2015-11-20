<ul class="list-unstyled" v-if="errorMessages.length">
	<li v-for="message in errorMessages">
		<div
				class="alert alert-danger alert-dismissible"
				role="alert"
		>
			<button
						type="button"
						class="close"
						data-dismiss="alert"
						aria-label="Close"
			>
				<span aria-hidden="true">&times;</span>
			</button>
		  <strong>@{{ message }}</strong>
		</div>
	</li>
</ul>
