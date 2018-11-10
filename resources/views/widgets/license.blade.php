@if ($item->license_type == 'copyright')
{{ $item->license_params }}
@elseif ($item->license_type == 'cc')
<img id="cc_image" src='https://i.creativecommons.org/l/{{ $item->license_params }}/4.0/88x31.png'>
@elseif ($item->license_type == 'public_domain')
<img src='https://licensebuttons.net/p/mark/1.0/88x31.png'>
@endif
