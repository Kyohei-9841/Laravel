<div class="modal fade" id="mdl-profile">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="modal-title">検索</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div> --}}
            <form method="post" action="{{ route('profile-update', [ 'id' => $user->id ]) }}">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>ユーザー名</label>
                            </div>
                            <div>
                                <input class="form-input" type="text" id="name" name="name" placeholder="タイトル" autocomplete="no" style="width:100%;" value="{{$user->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>苗字</label>
                            </div>
                            <div>
                                <input class="form-input" type="text" id="last_name" name="last_name" placeholder="タイトル" autocomplete="no" style="width:100%;" value="{{$user->last_name}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>名前</label>
                            </div>
                            <div>
                                <input class="form-input" type="text" id="first_name" name="first_name" placeholder="タイトル" autocomplete="no" style="width:100%;" value="{{$user->first_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>年齢</label>
                            </div>
                            <div>
                                <select id="age" class="form-control @error('age') is-invalid @enderror" name="age" placeholder="年齢" autocomplete="age">
                                    <option value="0" {{ empty($user->age) ? 'selected' : '' }}>未選択</option>
                                    @for ($i = 5; $i <= 100; $i++)
                                        <option value="{{$i}}" {{ $user->age == $i ? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>    
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>性別</label>
                            </div>
                            <div>
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" placeholder="性別" autocomplete="gender">
                                    <option value="0" {{ empty($user->gender) ? 'selected' : '' }}>未選択</option>
                                    <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>男性</option>
                                    <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>女性</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>都道府県</label>
                            </div>
                            <div>
                                @php
                                    $prefs = collect(config('const.pref'));
                                @endphp
                                <select id="prefectures" class="form-control @error('prefectures') is-invalid @enderror" name="prefectures" placeholder="都道府県" autocomplete="prefectures">
                                    @for ($i = 0; $i < count($prefs); $i++)
                                        <option value="{{$i}}" {{ $user->prefectures == $i ? 'selected' : '' }}>{{ $prefs[$i] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="address-div" class="col-sm-12 col-md-4 my-3" style="{{ $user->prefectures == 0 ? 'display:none' : '' }}">
                            <div>
                                <label>住所</label>
                            </div>
                            <div>
                                <input class="form-input" type="text" id="address" name="address" placeholder="住所" autocomplete="no" style="width:100%;" value="{{$user->address}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>プロフィール</label>
                            </div>
                            <div>
                                <textarea class="form-input" id="profile" name="profile" placeholder="プロフィール" autocomplete="no" style="width:100%;">{{ $user->profile }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>
