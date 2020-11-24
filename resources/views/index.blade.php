@extends('layouts.app')

@section('container')

<form method="post" enctype="multipart/form-data" action="">

	<div>
		<label>Add XML File</label>
		<br>
		<input type="file" name="files[]" multiple>
	</div>

	<br>

	<button type="submit">Import XML</button>

	@method('post')
	@csrf

</form>

<br>

<?php foreach ($xml as $x) : ?>
	{{ $x }}
<?php endforeach; ?>

<code style="border: 1px solid; border-radius: 8px; display: block; padding: 15px; background: #ebebeb; color: green; font-style: italic;">
/** <br>
&nbsp;* This information is extracted directly from the PHP configuration file (php.ini). It must be changed directly in the configuration file.<br>
&nbsp;* For more information, consult directly with the provider or adjust on the server <br>
&nbsp;*/
</code>

<?php
/**
 * This information is extracted directly from the PHP configuration file (php.ini). It must be changed directly in the configuration file.
 * For more information, consult directly with the provider or adjust on the server
 */
?>

<p>Maximum upload allowed: <b style="color: #ff0000"> {{ ini_get('max_file_uploads') }}</b> files</p>

@endsection