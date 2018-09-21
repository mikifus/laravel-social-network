@section('footer')
<script>
var tagnames = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: "{{ $url }}",
        wildcard: '%QUERY'
    }
});
tagnames.initialize();
var adapter = tagnames.ttAdapter();

$(document).ready(function(){
    $(".bootstrap-tagsinput").tagsinput({
        typeaheadjs: [{
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        source: adapter,
                    }],
        freeInput: true
    });
});
</script>
@append
