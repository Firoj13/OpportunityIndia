<div id="app-cover">
        <div id="bg-artwork"></div>
        <div id="bg-layer"></div>
        <div id="player">
            <div id="player-track">
                <div id="album-name">{{(!is_null($article->getAudioFiles)) ? $article->getAudioFiles->name : ''}}</div>
                <div id="track-name">{{(!is_null($article->getAudioFiles)) ? $article->getAudioFiles->name : ''}}</div>
                <div style="display: none;" id="track-url">@php echo  (!is_null($article->getAudioFiles) ? env('S3_BUCKET_URL','').'opp/audio/audios/'.trim($article->getAudioFiles->audio_path,'/') : '');@endphp</div>
                <div id="track-time">
                    <div id="current-time"></div>
                    <div id="track-length"></div>
                </div>
                <div id="s-area">
                    <div id="ins-time"></div>
                    <div id="s-hover"></div>
                    <div id="seek-bar"></div>
                </div>
            </div>
            <div id="player-content">
                <div id="album-art">
                    <img alt="brand image" src="{{!empty($article->image_path) ? \App\Http\Controllers\Frontend\IndexController::createimgurl(trim($article->image_path,'/')) : 'https://franchiseindia.s3.ap-south-1.amazonaws.com/uploads/content/fi/int/5ff40e6aaa3da.jpeg'}}" class="active" id="_1">
                    <div id="buffer-box">Buffering ...</div>
                </div>
                <div id="player-controls">
                    <!--<div class="control">
                        <div class="button" id="play-previous">
                            <i class="fas fa-backward"></i>
                        </div>
                    </div>-->
                    <div class="control">
                        <div class="button" id="play-pause-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                   <!-- <div class="control">
                        <div class="button" id="play-next">
                            <i class="fas fa-forward"></i>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>