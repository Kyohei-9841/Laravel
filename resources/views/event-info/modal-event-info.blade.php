<div class="modal fade" id="mdl-event-info">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">参加者一覧</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                @if (count($entry_list) > 0)
                    @foreach ($entry_list as $item)
                        <table class="border-none" style="margin: 10px 0px">
                            <tr class="border-none">
                                <td class="border-none text-center" style="padding:0px 30px 0px 5px">
                                    @if (!empty($item->imginfo) && !empty($item->enc_img))
                                        @php
                                            $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                        @endphp
                                        <a href="{{print_r($src, true)}}" target="_blank">
                                            <img class="round-frame" src="{{print_r($src, true)}}">
                                        </a>
                                    @else
                                        <img class="round-frame" src="{{ asset('images/images_4.png')}}">
                                    @endif
                                </td>
                                <td class="border-none">
                                    @if ($item->user_id == Auth::user()->id)
                                        <a href="{{ route('profile', [
                                            'id' => $item->user_id // ユーザーID
                                            , 'event_id' => $id // イベントID
                                            , 'selected_id' => $id // イベントID
                                            , 'admin_flg' => 0 // イベント作成者かのフラグ(プロフィール画面の戻るボタンに使用) 0:一般 1:管理者
                                            , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                            ]) }}">
                                            <span>{{ $item->user_name }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('profile', [
                                            'id' => $item->user_id // ユーザーID
                                            , 'event_id' => $id // イベントID
                                            , 'selected_id' => $id // イベントID
                                            , 'admin_flg' => 0 // イベント作成者かのフラグ(プロフィール画面の戻るボタンに使用) 0:一般 1:管理者
                                            , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                            ]) }}">
                                            <span>{{ $item->user_name }}</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endforeach
                @else
                    <div><p>まだ参加者がいません</p></div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
