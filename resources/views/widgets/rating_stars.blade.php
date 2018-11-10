<div style="font-size: 25px; margin: auto; text-align: center;">
    <vue-stars v-on:input="($event) => rate('{!! $class !!}', {{ $item->id }}, $event)"
        name="{{ sha1($item->id) }}"
        :active-color="'#ffdd00'"
        :inactive-color="'#DDDDDD'"
        :shadow-color="'#ffff00'"
        :hover-color="'#dddd00'"
        :max="5"
        :value="{{ $item->ratingsAvg() ?? 0 }}"
        :readonly="{{ Auth::check() ? 'false' : 'true' }}"
        :char="''"
        :inactive-char="''"
        :class="'fa'"
    ></vue-stars>
</div>
