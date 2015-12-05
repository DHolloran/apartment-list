@if (count($errors) > 0)
    <!-- Form Error List -->
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong!</strong>

        <br><br>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<?php $messages = json_encode([['value' => 'message', 'status' => 'success', 'timeout' => '4000']]); ?>
<alert :messages.sync="{{ $messages }}"></alert>
