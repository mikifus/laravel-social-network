
@section('footer')
<script type="text/javascript">
    $(function(){
        $('#modal-confirm').on('show.bs.modal', function(e) {
            var item_name = $(e.relatedTarget).data('item_name');
            $("#modal-confirm #item_name").val( item_name );
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
</script>
@append


<div class="modal fade" tabindex="-1" role="dialog" id="modal-confirm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <p>Are you sure you want to delete <span id="item_name"></span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('modals.cancel') }}</button>
        <a class="btn btn-primary btn-ok">{{ trans('modals.confirm') }}</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->