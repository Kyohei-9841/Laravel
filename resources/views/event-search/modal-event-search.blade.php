<div class="modal fade" id="mdl-event-search">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="modal-title">検索</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div> --}}
            <form method="post" action="{{ route('event-search-submit') }}">
                @method('POST')
                @csrf
                <div class="modal-body">
                    <div class="row" style="background-color:#3490dc;">
                        <div class="mx-2 py-1">
                            <span style="color:white">検索条件の設定</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>タイトル</label>
                            </div>
                            <div>
                                <input class="form-input" type="text" id="event-name" name="event-name" placeholder="タイトル" autocomplete="no" style="width:100%;" value="{{ $params['event_name'] }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>開始時刻</label>
                            </div>
                            <div>
                                <input class="form-input" type="date" id="start-at" name="start-at" placeholder="開始日" autocomplete="no" value="{{ $params['start_at'] }}">
                                <input class="form-input" type="time" id="start-at-time" name="start-at-time" placeholder="開始時間" autocomplete="no" value="{{ $params['start_at_time'] }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>終了時刻</label>
                            </div>
                            <div>
                                <input class="form-input" type="date" id="end-at" name="end-at" placeholder="終了日" autocomplete="no" value="{{ $params['end_at'] }}">
                                <input class="form-input" type="time" id="end-at-time" name="end-at-time" placeholder="終了時間" autocomplete="no" value="{{ $params['end_at_time'] }}">
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>測定基準</label>
                            </div>
                            <div>
                                <select id="evaluation-criteria" name="evaluation-criteria" placeholder="測定基準" autocomplete="no">
                                    <option value="0">全て</option>
                                    @foreach($evaluation_criteria_result as $evaluation_criteria_data)
                                        <option value="{{ $evaluation_criteria_data->id }}" {{ $params['evaluation_criteria'] == $evaluation_criteria_data->id ? 'selected' : '' }}>{{$evaluation_criteria_data->criteria_name}}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>魚種</label>
                            </div>
                            <div>
                                <select id="fish-species" name="fish-species" placeholder="魚種" autocomplete="no">
                                    <option value="0">全て</option>
                                    @foreach($fish_species_result as $fish_species_data)
                                        <option value="{{ $fish_species_data->id }}" {{ $params['fish_species'] == $fish_species_data->id ? 'selected' : '' }}>{{$fish_species_data->fish_name}}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 my-3">
                            <div>
                                <label>参加費</label>
                            </div>
                            <div>
                                <select id="entry-fee-flg" name="entry-fee-flg" placeholder="参加費" autocomplete="no" disabled>
                                    <option value="0" selected>全て</option>
                                    <option value="1">無料</option>
                                    <option value="2">有料</option>
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
