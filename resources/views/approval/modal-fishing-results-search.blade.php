<div class="modal fade" id="mdl-fishing-results-search">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="modal-title">検索</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div> --}}
            <form method="post" action="{{ route('approval-search', ['id' => $id]) }}">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <div class="row" style="background-color:#3490dc;">
                        <div class="mx-2 py-1">
                            <span style="color:white">検索条件の設定</span>
                        </div>
                    </div>
                    <input hidden class="form-input" type="text" id="id" name="id" value='{{ $id }}'>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>参加者</label>
                            </div>
                            <div>
                                <select id="entry-user" name="entry-user" placeholder="参加者" autocomplete="no">
                                    <option value="0" {{ $params['entry_user'] == 0 ? 'selected' : '' }}>全て</option>
                                    @foreach($entry_list as $entry)
                                        <option value="{{ $entry->user_id }}" {{ $params['entry_user'] == $entry->user_id ? 'selected' : '' }}>{{$entry->user_name}}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>承認ステータス</label>
                            </div>
                            <div>
                                <select id="approval" name="approval" placeholder="承認ステータス" autocomplete="no">
                                    <option value="-1" {{ $params['approval'] == -1 ? 'selected' : '' }}>全て</option>
                                    <option value="0" {{ $params['approval'] == 0 ? 'selected' : '' }}>未承認</option>
                                    <option value="1" {{ $params['approval'] == 1 ? 'selected' : '' }}>承認済</option>
                                    <option value="2" {{ $params['approval'] == 2 ? 'selected' : '' }}>非承認</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="row" style="background-color:#3490dc;">
                        <div class="mx-2 py-1">
                            <span style="color:white">並び替え条件の設定</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </form>
        </div>
    </div>
</div>
