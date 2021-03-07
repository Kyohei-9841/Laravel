<div class="modal fade" id="mdl-outsourcing-section">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HTML5カメラ</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <video id="camera" width="300" height="200"></video>
                <canvas id="picture" width="300" height="200"></canvas>
                <audio id="se" preload="auto">
                    <source src="camera-shutter1.mp3" type="audio/mp3">
                </audio>
                <input id="testtesttest" type="text" value=""/>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                <form>
                    {{ csrf_field() }}
                <button type="button" id="shutter">シャッター</button>
                </form>
            </div>
        </div>
    </div>
</div>
