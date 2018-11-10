<div style="font-size: 25px;">
    <vue-stars v-on:input="($event) => rate('{!! $class !!}', {{ $item->id }}, $event)"
        name="{{ $item->title }}"
        :active-color="'#ffdd00'"
        :inactive-color="'#DDDDDD'"
        :shadow-color="'#ffff00'"
        :hover-color="'#dddd00'"
        :max="5"
        :value="{{ $item->ratingsAvg() }}"
        :readonly="{{ Auth::check() ? 'false' : 'true' }}"
        :char="''"
        :inactive-char="''"
        :class="'fa'"
    ></vue-stars>
</div>
