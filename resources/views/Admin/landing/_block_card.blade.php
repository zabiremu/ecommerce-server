@php
    /** @var string $type  @var int|string $i  @var array $block */
    $block = $block ?? [];
    $meta = [
        'youtube'         => ['icon' => 'fab fa-youtube',    'label' => 'YouTube Video'],
        'rounded_heading' => ['icon' => 'fas fa-heading',    'label' => 'Rounded Heading'],
        'richtext'        => ['icon' => 'fas fa-align-left', 'label' => 'Rich Text'],
        'image'           => ['icon' => 'fas fa-image',      'label' => 'Image'],
        'video_thumbs'    => ['icon' => 'fas fa-photo-film', 'label' => 'Video Thumbnails'],
        'price_offer'     => ['icon' => 'fas fa-tag',        'label' => 'Price Offer'],
    ][$type] ?? ['icon' => 'fas fa-cube', 'label' => ucfirst($type)];
@endphp
<div class="lb-block" data-type="{{ $type }}" data-index="{{ $i }}" data-jindex="{{ $type === 'video_thumbs' ? count($block['items'] ?? []) : 0 }}">
    <div class="lb-block-h">
        <span class="lb-block-title"><i class="{{ $meta['icon'] }}"></i> {{ $meta['label'] }}</span>
        <div class="lb-block-tools">
            <button type="button" title="Move up"   onclick="lbMove(this,-1)"><i class="fas fa-arrow-up"></i></button>
            <button type="button" title="Move down" onclick="lbMove(this,1)"><i class="fas fa-arrow-down"></i></button>
            <button type="button" title="Delete" class="lb-del" onclick="lbRemove(this)"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    <div class="lb-block-body">
        <input type="hidden" name="blocks[{{ $i }}][type]" value="{{ $type }}">

        @switch($type)
            @case('youtube')
                <div class="wc-f"><label>YouTube link</label>
                    <input type="text" name="blocks[{{ $i }}][url]" class="wc-i" value="{{ $block['url'] ?? '' }}" placeholder="https://youtu.be/...">
                </div>
                <div class="wc-f"><label>Title <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="blocks[{{ $i }}][title]" class="wc-i" value="{{ $block['title'] ?? '' }}">
                </div>
                <div class="wc-f"><label>Description <span class="wc-opt">(optional)</span></label>
                    <textarea name="blocks[{{ $i }}][description]" class="wc-i" rows="2">{{ $block['description'] ?? '' }}</textarea>
                </div>
                @break

            @case('rounded_heading')
                <div class="wc-f"><label>Heading</label>
                    <input type="text" name="blocks[{{ $i }}][heading]" class="wc-i" value="{{ $block['heading'] ?? '' }}" placeholder="e.g. 3 piece t-shirt only 1190 Taka">
                </div>
                <div class="wc-f"><label>Subheading <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="blocks[{{ $i }}][subheading]" class="wc-i" value="{{ $block['subheading'] ?? '' }}">
                </div>
                <div class="wc-f"><label>Style</label>
                    <select name="blocks[{{ $i }}][style]" class="wc-i">
                        <option value="green" {{ ($block['style'] ?? 'green') === 'green' ? 'selected' : '' }}>Green banner</option>
                        <option value="dark"  {{ ($block['style'] ?? '') === 'dark' ? 'selected' : '' }}>Dark headline</option>
                    </select>
                </div>
                @break

            @case('richtext')
                <div class="wc-f"><label>Content</label>
                    <div class="lb-rte" data-rte>
                        <div class="lb-rte-toolbar">
                            <button type="button" data-cmd="bold" title="Bold"><b>B</b></button>
                            <button type="button" data-cmd="italic" title="Italic"><i>I</i></button>
                            <button type="button" data-cmd="underline" title="Underline"><u>U</u></button>
                            <button type="button" data-cmd="strikeThrough" title="Strikethrough"><s>S</s></button>
                            <span class="lb-rte-sep"></span>
                            <button type="button" data-block="h2" title="Heading 2">H2</button>
                            <button type="button" data-block="h3" title="Heading 3">H3</button>
                            <button type="button" data-block="p" title="Paragraph">P</button>
                            <span class="lb-rte-sep"></span>
                            <button type="button" data-cmd="insertUnorderedList" title="Bullet list"><i class="fas fa-list-ul"></i></button>
                            <button type="button" data-cmd="insertOrderedList" title="Numbered list"><i class="fas fa-list-ol"></i></button>
                            <button type="button" data-link title="Insert link"><i class="fas fa-link"></i></button>
                            <button type="button" data-cmd="removeFormat" title="Clear formatting"><i class="fas fa-eraser"></i></button>
                        </div>
                        <div class="lb-rte-area" contenteditable="true" data-placeholder="Write here...">{!! $block['html'] ?? '' !!}</div>
                        <textarea name="blocks[{{ $i }}][html]" class="lb-rte-input" hidden>{{ $block['html'] ?? '' }}</textarea>
                    </div>
                </div>
                @break

            @case('image')
                <div class="wc-f">
                    <label>Image</label>
                    <div class="lb-img-preview" style="{{ empty($block['path']) ? 'display:none;' : '' }}">
                        <img src="{{ !empty($block['path']) ? Storage::url($block['path']) : '' }}" alt="">
                    </div>
                    <input type="hidden" name="blocks[{{ $i }}][path]" value="{{ $block['path'] ?? '' }}">
                    <input type="file" name="blocks[{{ $i }}][image_file]" accept="image/*" class="wc-i" onchange="lbImgPreview(this)">
                    <p class="wc-help">Leave empty to keep the current image.</p>
                </div>
                <div class="wc-f"><label>Caption <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="blocks[{{ $i }}][caption]" class="wc-i" value="{{ $block['caption'] ?? '' }}">
                </div>
                @break

            @case('video_thumbs')
                <div class="wc-f"><label>Testimonial / review videos</label>
                    <div class="lb-items">
                        @foreach (($block['items'] ?? []) as $j => $it)
                            <div class="lb-item">
                                <input type="text" name="blocks[{{ $i }}][items][{{ $j }}][url]" class="wc-i" value="{{ $it['url'] ?? '' }}" placeholder="YouTube link">
                                <input type="text" name="blocks[{{ $i }}][items][{{ $j }}][label]" class="wc-i" value="{{ $it['label'] ?? '' }}" placeholder="Label (optional)">
                                <button type="button" class="lb-item-del" onclick="lbRemoveItem(this)"><i class="fas fa-xmark"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="wc-btn-sm" onclick="lbAddVideoItem(this)"><i class="fas fa-plus"></i> Add video</button>
                </div>
                @break

            @case('price_offer')
                <div class="wc-f"><label>Label <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="blocks[{{ $i }}][label]" class="wc-i" value="{{ $block['label'] ?? '' }}" placeholder="e.g. 100 ml">
                </div>
                <div class="wc-grid2">
                    <div class="wc-f"><label>Old price</label>
                        <input type="text" name="blocks[{{ $i }}][old_price]" class="wc-i" value="{{ $block['old_price'] ?? '' }}" placeholder="1570">
                    </div>
                    <div class="wc-f"><label>New price</label>
                        <input type="text" name="blocks[{{ $i }}][new_price]" class="wc-i" value="{{ $block['new_price'] ?? '' }}" placeholder="1080">
                    </div>
                </div>
                <div class="wc-f"><label>Note <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="blocks[{{ $i }}][note]" class="wc-i" value="{{ $block['note'] ?? '' }}" placeholder="e.g. Limited time offer">
                </div>
                @break
        @endswitch
    </div>
</div>
