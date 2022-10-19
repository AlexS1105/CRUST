<div class="space-y-2">
  <div class="space-y-2" id="fates">

  </div>

  <div class="font-bold text-lg text-right flex justify-end gap-2">
    {{ __('charsheet.points.fates') }}
    <div id="fates_max">
      {{ $maxFates }}
    </div>
  </div>
</div>

<x-form.error name="fates"/>
<x-form.error name="fates.*.text"/>
<x-form.error name="fates.*.ambition"/>
<x-form.error name="fates.*.flaw"/>

<script>
  var maxFates = @json($maxFates);
  var _fates = @json(old('fates', $character->fates)) || [];
  var ambitionLabelText = @json(__('fates.ambition'));
  var flawLabelText = @json(__('fates.flaw'));
  var continuousLabelText = @json(__('fates.continuous'));
  var fateText = @json(__('fates.placeholder.text'));
  var previewText = @json(__('label.preview'));
</script>
