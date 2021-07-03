<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>チャット</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="wrapper">
			<nav id="follow-header" class="navbar navbar-expand-lg navbar-dark bg-primary">
				<a class="navbar-brand" href="{{ url()->previous() }}">＜戻る</a>
				<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
			</nav>
			<div id="msgfld">
				<div id="board">
					@if (count($chats) > 0)
						@foreach ($chats as $item)
							<div class="mt-3">
								@if($item->send_user_id != Auth::user()->id)
									<div style="margin: 0px auto 0px 10px">
										@if (empty($item->user_image_id))
											<img class="round-frame-chat" src="{{ asset('images/images_4.png')}}">
										@else
											<img class="round-frame-chat" src="{{ asset('storage/upload/' . Auth::user()->id . '/chat_' . $item->send_user_id . '_' . $item->user_image_id . '.jpg')}}">
										@endif
										<span>{{ $item->send_user_name }}</span>
										<div style="width:80%; margin: 0px auto 0px 0px">
											<div style="width:100%; padding:10px; background-color: grey; border-radius: 20px; color: white">
												{!! nl2br(e($item->message)) !!}
											</div>
											<div class="font-size-5 font-color-gray" style="width:100%;">
												{{ Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i:s') }}
											</div>
										</div>
									</div>
								@else
									<div style="width:80%; margin: 0px 10px 0px auto">
										<div style="width:100%; padding:10px; background-color:lightblue; border-radius: 20px;">
											{!! nl2br(e($item->message)) !!}
										</div>
										<div class="text-right font-size-5 font-color-gray" style="width:100%;">
											{{ Carbon\Carbon::parse($item->created_at)->format('Y/m/d H:i:s') }}
										</div>
									</div>
								@endIf
							</div>
						@endforeach
					@endif
				</div>
			</div>
			<footer id="follow-footer">
				<!-- 送信フォーム -->
				<form enctype="multipart/form-data" action="" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="userId" id="userId" value="{{ Auth::user()->id }}">
					<input type="hidden" name="hostUserId" id="hostUserId" value="{{ $hostUserId }}">
					<input type="hidden" name="eventId" id="eventId" value="{{ $eventId }}">
					<div class="search-frame">
						<textarea name="message" class="form-control auto-resize" placeholder="入力してください" id="message" rows="1em"></textarea>        
						<button type="submit" class="post-button clear-decoration" id="submit">送信</button>	
					</div>
				</form>
			</footer>	
		</div>
	</body>
</html>
