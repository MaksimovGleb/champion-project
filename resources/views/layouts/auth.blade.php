<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Личный кабинет</title>
        <link href="{{ mix('/client/css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('/client/css/auth.css') }}" rel="stylesheet">
    </head>

    <body>
		<div class="text-center d-flex">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 offset-0">
					@if(count($errors->all()))
						<div class="alert alert-danger">{{ $errors->first() }}</div>
					@else
						@include('flash-message')
					@endif
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-12 offset-0">
						<img class="mb-4" src="{{ mix('/client/img/champion.logo.jpg') }}" alt="" width="290" height="60">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
    </body>

    <script src="{{ mix('/client/js/auth.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js" integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $("#inputPhone").inputmask("+9-999-999-99-99");
        });
    </script>
    @stack('custom-scripts')
</html>
