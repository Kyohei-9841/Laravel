<div class="modal fade" id="mdl-profile-image">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="modal-title">検索</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div> --}}
            <form method="post">
                @method('POST')
                @csrf
                <input hidden class="form-input" type="text" id="id" name="id" value='{{ $user->id }}'>
                <input hidden class="form-input" type="text" id="image_id" name="image_id" value='{{ $user->image_id }}'>
                <div class="modal-body">
                    <div class="row my-3">
                        <div class="col-12">
                            <div>
                                <label class="form-label" for="pic">アップロードする画像を選択してください</label>
                                <input class="form-input" type="file" id="pic" name="pic" accept="image/*">
                            </div>
                            <div>
                                <span class="font-size-11">※イベントのイメージ画像を選択してください</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <canvas id="canvas" width="0" height="0" style="display: none;"></canvas>
                            <div id="images-disp"></div>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <button type="button" id="profile-image-submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>
