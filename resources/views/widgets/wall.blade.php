
@push('head_scripts')
<script>
var __vue_mixin = {
    data:() => ({
        link_url_input_value: ''
    }),
    mounted() {
        $('.link-url-input').on('change', () => {
            this.link_url_input_value = $('.link-url-input').val();
            $('.link-area').slideDown().css('display', 'inline');
        });
    }
};
</script>
@endpush

<div class="clearfix"></div>
@if($user->id == Auth::user()->id)
<div class="panel panel-default new-post-box">
    <div class="panel-body">
        <form id="form-new-post">
            <input type="hidden" name="group_id" value="{{ $wall['new_post_group_id'] }}">
            <textarea name="content" placeholder="Share what you think or photos"></textarea>
            <div class="image-area">
                <a href="javascript:;" class="image-remove-button" onclick="removePostImage()"><i class="fa fa-times-circle"></i></a>
                <img src="" />
            </div>
            <div class="link-area">
                <input type="hidden" class="link-url-input" name="url" />
                <a href="javascript:;" class="image-remove-button link-remove-button" onclick="removePostLink()"><i class="fa fa-times-circle"></i></a>
                
                <link-prevue key="0" card-width="100%" :url="link_url_input_value" api-url="{{ route('posts.link_preview') }}" v-on:error="$('.link-remove-button').click()"></link-prevue>
<!--                 <link-prevue card-width="100%" :url="link_url_input_value"></link-prevue> -->
            </div>
            <hr />
            <div class="row">
                <div class="col-xs-4">
                    <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImage()">
                        <i class="fa fa-image"></i> Add Image
                    </button>
<!--                    <button type="button" class="btn btn-default btn-add-link btn-sm" onclick="uploadPostLink()">
                        <i class="fa fa-link"></i> Add Link
                    </button>-->
                    <input type="file" accept="image/*" class="image-input" name="photo" onchange="previewPostImage(this)">
                </div>
                <div class="col-xs-4">
                    <div class="loading-post">
                        <img src="{{ asset('img/rolling.gif') }}" alt="">
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="button" class="btn btn-primary btn-submit pull-right" onclick="newPost()">
                        Post!
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<div class="post-list-top-loading">
    <img src="{{ asset('img/rolling.gif') }}" alt="">
</div>
<div class="post-list">

</div>
<div class="post-list-bottom-loading">
    <img src="{{ asset('img/rolling.gif') }}" alt="">
</div>

<div class="modal fade " id="likeListModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Likes</h5>
            </div>

            <div class="user_list">

            </div>
        </div>
    </div>
</div>
